<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Response extends Model
{
    use HasFactory;

    protected $fillable = [
        'questionnaire_id',
        'question_id',
        'choix_id',
        'user_id',
        'text_answer',
        'numeric_answer'
    ];

    public function questionnaire()
    {
        return $this->belongsTo(Questionnaire::class);
    }

    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    public function choix()
    {
        return $this->belongsTo(Choix::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
