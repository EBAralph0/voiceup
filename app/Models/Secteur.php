<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Secteur extends Model
{
    protected $primaryKey = 'id_secteur';
    public $incrementing = false;
    protected $fillable = ['nom_secteur'];
    public $timestamps = false;

    // Relation avec les entreprises (existante)
    public function entreprises()
    {
        return $this->hasMany(Entreprise::class, 'id_secteur');
    }

    // Relation avec les questionnaires du secteur
    public function questionnaires()
    {
        return $this->hasMany(Questionnaire::class, 'id_secteur');
    }
}
