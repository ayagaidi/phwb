<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactSetting extends Model
{
    protected $fillable = [
        'phone', 'email',
        'address_ar', 'address_en',
        'facebook', 'instagram', 'whatsapp',
        'working_hours_ar', 'working_hours_en',
        'latitude', 'longitude',
    ];
}
