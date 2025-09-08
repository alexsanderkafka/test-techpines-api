<?php

namespace App\Service;

use \Illuminate\Http\JsonResponse;
use App\Models\Music;
use App\Models\User;
use App\DTO\MusicDTO;
use App\Exceptions\FoundModelException;
use App\Exceptions\NotFoundModelException;
use App\Exceptions\InvalidUrlException;

use Illuminate\Pagination\LengthAwarePaginator;

class MusicService{

    public function __construct(){}

    public function findTopMusics(): array{
        
        //Criar a camada de repository
        
        $currentMusics = Music::where('status', 'approved')
                        ->orderBy('views', 'desc')
                        ->take(5)
                        ->get();

        $musicsDTO = [];

        foreach($currentMusics as $music){
            $musicsDTO[] = MusicDTO::fromModel($music);
        }

        return $musicsDTO;
    }

    public function saveNewMusic(string $url, string $tokenJwt): void{
        $youtubeId = $this->extractVideoId($url);

        //Caso o link seja inválido

        if(!$youtubeId){
            throw new InvalidUrlException("URL inválida");
        }

        $existMusic = Music::where('youtube_id', $youtubeId)->first();

        //Retornar algo se essa música já existe no bd
        if($existMusic){
            throw new FoundModelException("Música já cadastrada");
        }

        $email = $this->getEmailInToken($tokenJwt);

        $currentUser = User::where('email', $email)->first();

        if(!$currentUser){
            throw new NotFoundModelException("Usuário não encontrado");
        }

        $infos = $this->getVideoInfo($youtubeId);
        $infos["status"] = 'approved';
        $infos["user_id"] = $currentUser->id;

        Music::create($infos);
    }

    public function findAllMusics(): LengthAwarePaginator{
        $musics = Music::orderBy('views', 'desc')
            ->skip(5)
            ->paginate(1);

        
        $dto = $musics->through(function (Music $music) {
            return MusicDTO::fromModel($music);
        });

        return $dto;
    }

    private function extractVideoId(string $url): ?string{
        $videoId = null;

        // Padrões de URL do YouTube
        $patterns = [
            '/youtube\.com\/watch\?v=([^&]+)/', // youtube.com/watch?v=ID
            '/youtu\.be\/([^?]+)/',            // youtu.be/ID
            '/youtube\.com\/embed\/([^?]+)/',   // youtube.com/embed/ID
        ];

        foreach ($patterns as $pattern) {
            if (preg_match($pattern, $url, $matches)) {
                $videoId = $matches[1];
                break;
            }
        }

        return $videoId;
    }

    private function getVideoInfo(string $youtubeId): array{
        $url = "https://www.youtube.com/watch?v=" . $youtubeId;

        // Inicializa o cURL
        $ch = curl_init();

        // Configura o cURL para a requisição
        curl_setopt_array($ch, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_USERAGENT => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36'
        ]);

        // Faz a requisição
        $response = curl_exec($ch);

        if ($response === false) {
            throw new InvalidUrlException("URL inválida");
        }

        curl_close($ch);

        // Extrai o título
        if (!preg_match('/<title>(.+?) - YouTube<\/title>/', $response, $titleMatches)) {
            throw new InvalidUrlException("URL inválida");
        }
        $title = html_entity_decode($titleMatches[1], ENT_QUOTES);

        // Extrai as visualizações
        // Procura pelo padrão de visualizações no JSON dos dados do vídeo
        if (preg_match('/"viewCount":\s*"(\d+)"/', $response, $viewMatches)) {
            $views = (int)$viewMatches[1];
        } else {
            // Tenta um padrão alternativo
            if (preg_match('/\"viewCount\"\s*:\s*{.*?\"simpleText\"\s*:\s*\"([\d,\.]+)\"/', $response, $viewMatches)) {
                $views = (int)str_replace(['.', ','], '', $viewMatches[1]);
            } else {
                $views = 0;
            }
        }

        if ($title === '') {
            throw new InvalidUrlException("URL inválida");
        }

        return [
            'title' => $title,
            'views' => $views,
            'youtube_id' => $youtubeId,
            'youtube_link' => $url,
            'thumb' => 'https://img.youtube.com/vi/'.$youtubeId.'/hqdefault.jpg'
        ];
    }

    private function getEmailInToken(string $token): ?string{
        [$header, $payload, $signature] = explode('.', $token);
        $decodedPayload = json_decode(base64_decode(strtr($payload, '-_', '+/')), true);

        $sub = $decodedPayload['sub'] ?? null;

        return $sub;
    }


}