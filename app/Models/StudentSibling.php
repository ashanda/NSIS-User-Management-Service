<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentSibling extends Model
{
    use HasFactory;
     protected $connection = 'student_service';
     protected $fillable = [
        'organization_id',
        'student_id',
        'first_name',
        'last_name',
        'gender',
        'date_of_birth',
        'school',
    ];
}
