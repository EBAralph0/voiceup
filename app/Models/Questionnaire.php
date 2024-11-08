<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Questionnaire extends Model
{
    protected $fillable = ['intitule', 'description', 'created_by', 'entreprise_id', 'id_secteur'];

    // Relation avec le secteur d'activité
    public function secteur()
    {
        return $this->belongsTo(Secteur::class, 'id_secteur');
    }

    // // Relation avec l'entreprise (pour les questionnaires personnalisés d'une entreprise)
    // public function entreprise()
    // {
    //     return $this->belongsTo(Entreprise::class, 'entreprise_id');
    // }

    // Relation avec l'utilisateur créateur du questionnaire
    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Relation avec les questions associées au questionnaire
    public function questions()
    {
        return $this->hasMany(Question::class);
    }
}
