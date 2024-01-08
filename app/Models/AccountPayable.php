<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccountPayable extends Model
{
    use HasFactory;
    protected $connection = 'student_service';
    protected $fillable = ['student_id', 'amount', 'type', 'eligibility', 'status'];
}
