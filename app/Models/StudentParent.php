<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentParent extends Model
{
    use HasFactory;
     protected $connection = 'student_service';
     protected $fillable = [
        'organization_id',
        'student_id',
        'relationship',
        'first_name',
        'last_name',
        'nic',
        'higher_education_qualification',
        'occupation',
        'official_address',
        'permanent_address',
        'contact_official',
        'contact_mobile',
     ];


}
