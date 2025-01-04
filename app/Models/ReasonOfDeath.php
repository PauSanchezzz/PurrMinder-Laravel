<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReasonOfDeath extends Model
{
    use HasFactory;
    protected $table = 'reasonOfDeath';
    protected $fillable = [
        'idReasonOfDeath',
        'reasonOfDeath'
    ];
}
