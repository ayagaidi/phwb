<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VolunteerContent extends Model
{
    protected $fillable = [
        'hero_title', 'hero_title_en',
        'hero_desc', 'hero_desc_en',
        'opportunities', 'opportunities_en',
        'banner_image', 'is_published'
    ];
}
