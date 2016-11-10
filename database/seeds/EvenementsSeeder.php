<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

use App\Models\TypeEvenement;
use App\Models\Epreuve;
use App\Models\Evenement;

class EvenementsTableSeeder extends Seeder {


	public function run()
	{
	    // Suppression de la table 'evenements' de la base de données
		DB::table('evenements')->delete();

        // Création d'une liste de valeurs par défaut
        $items = [
            //nom, type, date_heure, epreuve_id
            ["Demi-Finale 1",   "Demi-Finale",  "2016-10-10 13:15:00", "Simple Masculin"],
            ["Demi-Finale 2",   "Demi-Finale",  "2016-10-10 13:15:00", "Simple Masculin"],
            ["Finale 1",        "Finale",       "2016-10-10 14:30:00", "Simple Masculin"],
        ];

        // Création d'objet 'evenements' et sauvegarde de ceux-ci dans la base de données

        foreach ($items as $item) {
            $evenement = new Evenement();
            $evenement->nom = $item[0];
            $evenement->type_id = TypeEvenement::where("titre", "=", $item[1])->first()->id;
            $evenement->date_heure = $item[2];
            $evenement->epreuve_id = Epreuve::where("nom","=", $item[3])->first()->id;
            $evenement->save();
        }
	}
}