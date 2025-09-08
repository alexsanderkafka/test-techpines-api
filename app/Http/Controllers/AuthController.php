<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Service\AuthService;
use \Illuminate\Http\JsonResponse;
use App\Http\Requests\AuthLoginRequest;
use App\Http\Requests\AuthVerifyCodeRequest;
use Symfony\Component\HttpFoundation\Response;

use App\DTO\AuthDTO;

class AuthController extends Controller
{

    public function login(AuthLoginRequest $request): Response{

        $email = $request->validated()['email'];

        AuthService::login($email);

        return response()->noContent(200);
    }

    public function verifyCode(AuthVerifyCodeRequest $request): JsonResponse{

        $dto = AuthDTO::fromArray($request->validated());

        $tokenDto = AuthService::verifyCode($dto);

        return response()->json($tokenDto, 200);
    }
}