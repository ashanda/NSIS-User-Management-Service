<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentDocument extends Model
{
    use HasFactory;
     protected $connection = 'student_service';
       protected $fillable = [
        'organization_id',
        'student_id',
        'profile_picture',
        'birth_certificate',
        'nic_father',
        'nic_mother',
        'marriage_certificate',
        'permission_letter',
        'leaving_certificate',
    ];
}
