<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class YearGradeClass extends Model
{
    use HasFactory;
    protected $connection = 'core_service';
    protected $fillable = [
        'organization_id',
        'title',
        'year',
        'master_grade_id',
        'master_class_id',
        'active_status',
    ];

    public function grade()
    {
        return $this->belongsTo(MasterGrade::class, 'master_grade_id', 'id');
    }

    public function class()
    {
        return $this->belongsTo(MasterClass::class, 'master_class_id', 'id');
    }
}
