<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cat extends Model
{
    use HasFactory;

    protected $table = 'cats';

    protected $fillable = [
        'nameCat',
        'imageCat',
        'descriptionCat',
        'ageCat',
        'calendar_id',
        'weightCat',
        'sexCat_id',
        'specialCondition',
        'specialCondition_id',
        'catHealth_id',
        'personality_id',
        'availabilityCat',
        'adoptedCat'
    ];
}
