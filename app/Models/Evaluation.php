<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evaluation extends Model
{
    use HasFactory;
    protected $table = 'evaluation';
    protected $fillable = [
        'id',
        'comments',
        'application_id',
        'evaluationStatus_id'
    ];
}
