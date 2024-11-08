<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $fillable = ['questionnaire_id', 'text', 'type', 'is_general'];

    // Relation avec le questionnaire
    public function questionnaire()
    {
        return $this->belongsTo(Questionnaire::class);
    }

    // Relation avec les choix de réponse
    public function choix()
    {
        return $this->hasMany(Choix::class);
    }

    // Relation avec les réponses
    public function responses()
    {
        return $this->hasMany(Response::class, 'question_id');
    }
}
