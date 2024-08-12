<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypeMedicalProcedure extends Model
{
    use HasFactory;
    protected $table = 'typeMedicalProcedure';
    protected $fillable = [
        'idTypeMedicalProcedure',
        'typeMedicalProcedure'
    ];
}
