<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    protected $fillable = ['title', 'title_en', 'description', 'description_en', 'image', 'video_url', 'is_published'];
}
