<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::table('music')->insert([
            [
                'title' => 'O Mineiro e o Italiano',
                'views' => 5200000,
                'youtube_id' => 's9kVG2ZaTS4',
                'youtube_link' => 'https://www.youtube.com/watch?v=s9kVG2ZaTS4',
                'thumb' => 'https://img.youtube.com/vi/s9kVG2ZaTS4/hqdefault.jpg',
                'status' => 'approved',
                'user_id' => 1
            ],
            [
                'title' => 'Pagode em Brasília',
                'views' => 5000000,
                'youtube_id' => 'lpGGNA6_920',
                'youtube_link' => 'https://www.youtube.com/watch?v=lpGGNA6_920',
                'thumb' => 'https://img.youtube.com/vi/lpGGNA6_920/hqdefault.jpg',
                'status' => 'approved',
                'user_id' => 1
            ],
            [
                'title' => 'Rio de Lágrimas',
                'views' => 153000,
                'youtube_id' => 'FxXXvPL3JIg',
                'youtube_link' => 'https://www.youtube.com/watch?v=FxXXvPL3JIg',
                'thumb' => 'https://img.youtube.com/vi/FxXXvPL3JIg/hqdefault.jpg',
                'status' => 'approved',
                'user_id' => 1
            ],
            [
                'title' => 'Tristeza do Jeca',
                'views' => 154000,
                'youtube_id' => 'tRQ2PWlCcZk',
                'youtube_link' => 'https://www.youtube.com/watch?v=tRQ2PWlCcZk',
                'thumb' => 'https://img.youtube.com/vi/tRQ2PWlCcZk/hqdefault.jpg',
                'status' => 'approved',
                'user_id' => 1
            ],
            [
                'title' => 'Terra roxa',
                'views' => 3300000,
                'youtube_id' => '4Nb89GFu2g4',
                'youtube_link' => 'https://www.youtube.com/watch?v=4Nb89GFu2g4',
                'thumb' => 'https://img.youtube.com/vi/4Nb89GFu2g4/hqdefault.jpg',
                'status' => 'approved',
                'user_id' => 1
            ],

        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
