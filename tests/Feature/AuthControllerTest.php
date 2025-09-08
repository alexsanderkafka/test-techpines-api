<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Facades\Redis;
use App\Models\User;

class AuthControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     */
    public function test_login(): void
    {

        $data = [
            'email' => 'teste.teste2@gmail.com'
        ];

        $response = $this->postJson('/api/login', $data);


        $response->assertStatus(200);
    }

    public function test_login_invalid_email(): void
    {

        $data = [
            'email' => 'teste.teste2'
        ];

        $response = $this->postJson('/api/login', $data);


        $response->assertStatus(422)
                  ->assertJson([
                     'message' => 'O campo de e-mail deve ser um endereço de e-mail válido.'
                    ]);
    }

    public function test_login_empty_email(): void
    {
        $response = $this->postJson('/api/login');


        $response->assertStatus(422)
                  ->assertJson([
                     'message' => 'O campo de e-mail é obrigatório.'
                    ]);
    }

    public function test_verify_code(): void
    {
        $user = User::factory()->create([
            'email' => 'test.teste@gmail.com',
        ]);

        $data = [
            'email' => $user->email
        ];

        $this->postJson('/api/login', $data);

        $code = Redis::get($user->email);

        $data['code'] = $code;

        $response = $this->postJson('/api/login/verify-code', $data);

        $response->assertStatus(200)
                  ->assertJsonStructure([
                     'token'
                    ]);
    }

    public function test_verify_code_invalid_email(): void
    {
        $data = [
            'email' => 'testeteste',
            'code' => 'RI4L4'
        ];

        $response = $this->postJson('/api/login/verify-code', $data);

        $response->assertStatus(422)
                  ->assertJson([
                     'message' => "O campo de e-mail deve ser um endereço de e-mail válido."
                    ]);
    }

    public function test_verify_code_not_found_email(): void
    {
        $data = [
            'email' => 'teste.test@gmail.com',
            'code' => 'RI4L4'
        ];

        $response = $this->postJson('/api/login/verify-code', $data);

        $response->assertStatus(404)
                  ->assertJson([
                     'message' => "Usuário não cadastrado"
                    ]);
    }

    public function test_verify_code_invalid_code(): void
    {
        $user = User::factory()->create([
            'email' => 'test.teste@gmail.com',
        ]);

        $data = [
            'email' => $user->email,
            'code' => 'RI4L7'
        ];

        $response = $this->postJson('/api/login/verify-code', $data);

        $response->assertStatus(403)
                  ->assertJson([
                     'message' => "Código de verificaçãoo inválido"
                    ]);
    }

    public function test_verify_code_length_code(): void
    {
        $user = User::factory()->create([
            'email' => 'test.teste@gmail.com',
        ]);

        $data = [
            'email' => $user->email,
            'code' => 'RI4L'
        ];

        $response = $this->postJson('/api/login/verify-code', $data);

        $response->assertStatus(422)
                  ->assertJson([
                     "message" => "O campo de código deve ter exatamente 5 caracteres."
                    ]);
    }

    public function test_verify_code_empty_fields(): void
    {
        $data = [
        ];

        $response = $this->postJson('/api/login/verify-code', $data);

        $response->assertStatus(422)
                  ->assertJson([
                     "message" => "O campo de e-mail é obrigatório. (and 1 more error)"
                    ]);
    }
}

