<?php

namespace App\Service;

use App\Utils\CodeGenerator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;
use App\Models\User;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Mail;
use App\Mail\CodeMail;
use App\DTO\AuthDTO;
use App\DTO\TokenDTO;
use App\Exceptions\NotFoundModelException;
use App\Exceptions\InvalidCodeException;

#Log::info('Retrieved musics: ');

class AuthService
{
    public function __construct(){}

    public static function login(string $email): void{

        //Verificação do email é feito na Request

        $user = User::where('email', $email)->first();

        if(!$user){
            User::create([
                'email' => $email
            ]);
        }

        $code = CodeGenerator::generateCode();

        Redis::set($email, $code);
        Redis::expire($email, 60 * 10);

        //Parte de enviar o e-mail
        Mail::to($email)->send(new CodeMail($code));
    }

    public static function verifyCode(AuthDTO $data): TokenDTO{

        //Verificação do email é feito na Request
        
        $user = User::where('email', $data->email)->first();
    
        if(!$user){
            throw new NotFoundModelException("Usuário não cadastrado");
        }

        $storedCode = Redis::get($user->email);

        if(!$storedCode || $storedCode !== $data->code){
            throw new InvalidCodeException("Código de verificaçãoo inválido");
        }

        //Gerar token JWT   
        $token = JWTAuth::fromUser($user);



        return new TokenDTO($token);
    }

}