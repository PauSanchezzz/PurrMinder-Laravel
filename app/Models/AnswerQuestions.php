<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnswerQuestions extends Model
{
    use HasFactory;
    protected $table = 'answerQuestions';
    protected $fillable = [
        'id',
        'answer',
        'question_id',
        'application_id'
    ];
}
