<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedicalProcedure extends Model
{
    use HasFactory;
    protected $table = 'medicalProcedure';
    protected $fillable = [
        'dateMedicalProcedure',
        'CostMedicalProcedure',
        'commentsMedicalProcedure',
        'supportMedicalProcedure',
        'cat_id',
        'typeMedicalProcedure_id'
    ];
}
