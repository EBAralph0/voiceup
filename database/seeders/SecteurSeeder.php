<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Secteur;
use Illuminate\Support\Str;

class SecteurSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Secteur::create([
            'id_secteur' => Str::uuid(),
            'nom_secteur' => 'Banque',
        ]);

        Secteur::create([
            'id_secteur' => Str::uuid(),
            'nom_secteur' => 'Sante',
        ]);

        Secteur::create([
            'id_secteur' => Str::uuid(),
            'nom_secteur' => 'Restaurant',
        ]);
    }
}
