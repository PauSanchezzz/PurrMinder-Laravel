<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuestionsForm extends Model
{
    use HasFactory;
    protected $table = 'questionsForm';
    protected $fillable = [
        'id',
        'question',
        'shelter_id',
    ];
}
