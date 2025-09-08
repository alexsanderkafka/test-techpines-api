<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Music extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'music';

    public $timestamps = false;

    protected $fillable = [
        'title',
        'views',
        'youtube_id',
        'youtube_link',
        'thumb',
        'status',
        'user_id'
    ];
}
