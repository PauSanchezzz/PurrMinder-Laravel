<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Death extends Model
{
    use HasFactory;
    protected $table = 'death';
    protected $fillable = [
        'dateOfDeath',
        'associatedCosts',
        'comments',
        'cat_id',
        'reasonOfDeath_id'
    ];
}
