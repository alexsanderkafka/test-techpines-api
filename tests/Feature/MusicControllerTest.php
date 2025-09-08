<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Music;
use App\Models\User;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Exceptions\FoundModelException;

class MusicControllerTest extends TestCase
{

    use RefreshDatabase;

    public function test_find_top_music(): void
    {
        $response = $this->getJson('/api/musics/top');

        $response->assertStatus(200);
    }

    public function test_find_all_music(): void
    {
        $response = $this->getJson('/api/musics?page=6');

        $response->assertStatus(200);
    }

    public function test_save_music(): void
    {
        $user = User::factory()->create([
            'email' => 'test.teste@gmail.com',
        ]);

        $tokenJwt = JWTAuth::fromUser($user);

        $headers =  [
            'Authorization' => 'Bearer ' . $tokenJwt,
            'Accept' => 'application/json',
        ];

        $payload = [
            'url' => 'https://www.youtube.com/watch?v=rKd02bTr8p0&list=OLAK5uy_nJNYkFbGD7TMjzsGZDvyC-DCFSrJruz24'
        ];


        $response = $this->postJson('/api/musics', $payload, $headers);
        
        $response->assertStatus(201);
    }

    public function test_save_music_unauthorized(): void
    {
        $user = User::factory()->create([
            'email' => 'test.teste@gmail.com',
        ]);

        $tokenJwt = "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vMTI3LjAuMC4xOjgwMDAvYXBpL2xvZ2luL3ZlcmlmeS1jb2RlIiwiaWF0IjoxNzU3MjQ0OTYxLCJleHAiOjE3NTcyNDg1NjEsIm5iZiI6MTc1NzI0NDk2MSwianRpIjoiNEN4QjZKSkVnTlh1VlRhNyIsInN1YiI6ImFsZXhzYW5kZXJrYWZrYTIwMDFhbGV4QGdtYWlsLmNvbSIsInBydiI6IjIzYmQ1Yzg5NDlmNjAwYWRiMzllNzAxYzQwMDg3MmRiN2E1OTc2ZjcifQ.d_RyZ9tOnKDQss81STcxYT-ZOnQNXtZ5KLtH7g9X5Do";

        $headers =  [
            'Authorization' => 'Bearer ' . $tokenJwt,
            'Accept' => 'application/json',
        ];

        $payload = [
            'url' => 'https://www.youtube.com/watch?v=rKd02bTr8p0&list=OLAK5uy_nJNYkFbGD7TMjzsGZDvyC-DCFSrJruz24'
        ];


        $response = $this->postJson('/api/musics', $payload, $headers);
        
        $response->assertStatus(401);
    }

    public function test_save_music_exists(): void
    {

        $user = User::factory()->create([
            'email' => 'test.teste@gmail.com',
        ]);

        $music = Music::factory()->create([
            'user_id' => $user->id,
        ]);

        $tokenJwt = $tokenJwt = JWTAuth::fromUser($user);

        $headers =  [
            'Authorization' => 'Bearer ' . $tokenJwt,
            'Accept' => 'application/json',
        ];

        $payload = [
            'url' => $music->youtube_link
        ];

        $response = $this->postJson('/api/musics', $payload, $headers);
        
        $response->assertStatus(406)
             ->assertJson([
                'message' => 'Música já cadastrada'
             ]);
    }
    
    public function test_save_music_invalid_url(): void
    {

        $user = User::factory()->create([
            'email' => 'test.teste@gmail.com',
        ]);

        $tokenJwt = $tokenJwt = JWTAuth::fromUser($user);

        $headers =  [
            'Authorization' => 'Bearer ' . $tokenJwt,
            'Accept' => 'application/json',
        ];

        $payload = [
            'url' => 'htttps://youtube.teste'
        ];

        $response = $this->postJson('/api/musics', $payload, $headers);
        
        $response->assertStatus(404)
             ->assertJson([
                'message' => 'URL inválida'
             ]);
    }

}
