<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MembershipApplication extends Model
{
    protected $fillable = [
        'full_name', 'date_of_birth', 'gender', 'phone', 'whatsapp', 'email',
        'city', 'address',
        'qualification', 'university', 'graduation_year', 'license_number',
        'current_workplace', 'years_experience', 'specialization',
        'membership_type', 'reason', 'contribution_areas', 'available_for_fieldwork',
        'status', 'admin_notes', 'read_at',
    ];
}
