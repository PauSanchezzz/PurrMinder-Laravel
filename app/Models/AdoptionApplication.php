<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdoptionApplication extends Model
{
    use HasFactory;
    protected $table = 'adoptionApplication';
    protected $fillable = [
        'id',
        'cat_id',
        'adopter_id'
    ];
}
