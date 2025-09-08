<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use \Illuminate\Http\JsonResponse;
use App\Service\MusicService;
use App\Models\Music;
use App\Http\Requests\MusicSaveRequest;

use Illuminate\Support\Facades\Log;

class MusicController extends Controller
{

    private $musicService;

    public function __construct(){
        $this->musicService = new MusicService();
    }

    public function findTopMusics(): JsonResponse{
        $currentMusics = $this->musicService->findTopMusics();
        
        return response()->json($currentMusics, 200);
    }

    public function findAllMusic(): JsonResponse{
        $musics = $this->musicService->findAllMusics();

        return response()->json($musics, 200);
    }

    public function saveMusic(MusicSaveRequest $request): Response{
        $jwt = $request->bearerToken();

        $this->musicService->saveNewMusic($request->validated()['url'], $jwt);

        return response()->noContent(201);
    }
}
