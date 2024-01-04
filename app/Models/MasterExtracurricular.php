<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterExtracurricular extends Model
{
    use HasFactory;
    protected $connection = 'core_service';
    protected $fillable = [
        'organization_id',
        'extracurricular_name',
    ];
}
