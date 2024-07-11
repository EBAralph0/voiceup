<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Entreprise extends Model
{
    //use HasFactory;'

    //use Sortable;

    protected $primaryKey = 'id_entreprise';
    public $incrementing = false;

    protected $fillable =["nom_entreprise","sigle","numero_entreprise","mail_entreprise","logo_entreprise","created_by_id","slogan","description","id_secteur","proprietaire_id"];

    public $sortable = [
        "nom_entreprise",
        "sigle",
        "numero_entreprise",
        "mail_entreprise",
        "logo_entreprise",
        "created_by_id",
        "slogan",
        "description",
        "id_secteur",
        "proprietaire_id"
    ];

    public $timestamps = false;

     // Relation avec User
     public function user()
     {
         return $this->belongsTo(User::class, 'created_by_id');
     }

     // Relation avec User
     public function proprietaire()
     {
         return $this->belongsTo(User::class, 'proprietaire_id');
     }

     // Relation avec Secteur
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
}
