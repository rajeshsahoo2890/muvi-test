<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Video extends Model
{
    #use HasFactory, SoftDeletes;

    protected $table = 'videos';

    protected $primaryKey = 'video_id';

    protected $fillable = [
        'converted_for_streaming_at',
    ];

}
