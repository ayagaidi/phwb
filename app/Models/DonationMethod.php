<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DonationMethod extends Model
{
    protected $fillable = ['name', 'name_en', 'description', 'description_en', 'image'];
}
