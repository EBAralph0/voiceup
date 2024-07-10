<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Avis extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'entreprise_id', 'note', 'commentaire'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // public function entreprise()
    // {
    //     return $this->belongsTo(Entreprise::class);
    // }
}
