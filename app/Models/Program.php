<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    protected $fillable = ['title', 'description', 'image', 'video_url', 'is_published'];
}
