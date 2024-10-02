<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $fillable = ['questionnaire_id', 'text', 'type'];

    public function questionnaire()
    {
        return $this->belongsTo(Questionnaire::class);
    }

    public function choix()
    {
        return $this->hasMany(Choix::class);
    }
    public function responses()
    {
        return $this->hasMany(Response::class, 'question_id');
    }
}
