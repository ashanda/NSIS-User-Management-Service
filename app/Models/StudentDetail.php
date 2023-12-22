<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentDetail extends Model
{
    use HasFactory;
     protected $connection = 'student_service';

    protected $fillable = [
        'student_id',
        'organization_id',
        'year_grade_class_id',
        'admission_no',
        'first_name',
        'last_name',
        'name_with_initials',
        'name_in_full',
        'address_line1',
        'address_line2',
        'address_city',
        'telephone_residence',
        'telephone_mobile',
        'telephone_whatsapp',
        'email_address',
        'gender',
        'date_of_birth',
        'religion',
        'ethnicity',
        'birth_certificate_number',
        'profile_picture_path',
        'health_conditions',
        'admission_date',
        'admission_payment_amount',
        'no_of_installments',
        'admission_status',
        'school_fee',
        'total_due',
        'payment_status',
        'academic_status',
    ];
}
