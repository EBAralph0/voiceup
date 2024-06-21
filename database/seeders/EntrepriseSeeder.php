<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Secteur;
use App\Models\User;
use App\Models\Entreprise;
use Illuminate\Support\Str;


class EntrepriseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $s1 = Secteur::where('nom_secteur', 'Banque')->first();
        $s2 = Secteur::where('nom_secteur', 'Sante')->first();
        $user = User::where('name', 'User1')->first();

        Entreprise::create([
            'id_entreprise' => Str::uuid(),
            'sigle' => 'SGC',
            'nom_entreprise' => 'Societe Generale du Cameroun',
            'numero_entreprise' => '+234699887766',
            'mail_entreprise' => 'socgen@gmail.com',
            'logo_entreprise' => 'https://media.licdn.com/dms/image/C4D0BAQGJnQFPz55esg/company-logo_200_200/0/1630524480221/sgcameroun_logo?e=2147483647&v=beta&t=DNNfxg0p1Uw0HWPYhKLPzrwtG2D6-HE2JN1BxF83H2g',
            'created_by_id' => $user->id,
            'slogan' => "C'est vous l'avenir !",
            'description' => "Dotée de 675 collaborateurs, elle s'engage à offrir à sa clientèle de grandes et moyennes entreprises, de professionnels, d'institutions, d'associations et de particuliers...",
            'id_secteur' => $s1->id_secteur,
        ]);

        

        $user->proprietaire=true;
        $user->save();
    }
}
