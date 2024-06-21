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

    protected $fillable =["nom_entreprise","sigle","numero_entreprise","mail_entreprise","logo_entreprise","created_by_id","slogan","description","id_secteur"];

    public $sortable = [
        "nom_entreprise",
        "sigle",
        "numero_entreprise",
        "mail_entreprise",
        "logo_entreprise",
        "created_by_id",
        "slogan",
        "description",
        "id_secteur"
    ];

    public $timestamps = false;

     // Relation avec User
     public function user()
     {
         return $this->belongsTo(User::class, 'created_by_id');
     }
 
     // Relation avec Secteur
     public function secteur()
     {
         return $this->belongsTo(Secteur::class, 'id_secteur');
     }
}
