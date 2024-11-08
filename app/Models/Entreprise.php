<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Entreprise extends Model
{
    protected $primaryKey = 'id_entreprise';
    public $incrementing = false;

    protected $fillable = [
        "nom_entreprise", "sigle", "numero_entreprise", "mail_entreprise",
        "logo_entreprise", "created_by_id", "slogan", "description",
        "id_secteur", "proprietaire_id", "date_anniversaire", "siege_social", "nb_employes_interval"
    ];

    public $timestamps = false;

    // Relations
    public function user()
    {
        return $this->belongsTo(User::class, 'created_by_id');
    }

    public function proprietaire()
    {
        return $this->belongsTo(User::class, 'proprietaire_id');
    }

    public function secteur()
    {
        return $this->belongsTo(Secteur::class, 'id_secteur');
    }

    public function questionnaires()
    {
        return $this->hasMany(Questionnaire::class, 'entreprise_id');
    }

    public function avis()
    {
        return $this->hasMany(Avis::class, 'entreprise_ids', 'id_entreprise');
    }

    public function averageRating()
    {
        return $this->avis()->avg('note');
    }
}

