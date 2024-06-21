<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Secteur extends Model
{
    //use HasFactory;
    protected $primaryKey = 'id_secteur';
    public $incrementing = false;

    protected $fillable =["nom_secteur"];

    public $sortable = [
        "nom_secteur"
    ];

    public $timestamps = false;

    public function entreprises()
    {
        return $this->hasMany(Entreprise::class, 'id_secteur');
    }
}
