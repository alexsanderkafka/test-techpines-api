<?php

namespace App\DTO;

use App\Models\Music;

class MusicDTO{
    public function __construct(
        public string $title,
        public int $views,
        public string $thumb,
        public string $youtubeLink,
    ){}

    public static function fromModel(Music $data): self{
        return new self(
            title: $data->title,
            views: $data->views,
            thumb: $data->thumb,
            youtubeLink: $data->youtube_link,
        );
    }


}