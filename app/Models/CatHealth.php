<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CatHealth extends Model
{
    use HasFactory;
    protected $table = 'catHealth';
    protected $fillable = [
        'idCatHealth',
        'catHealth',
    ];
}
