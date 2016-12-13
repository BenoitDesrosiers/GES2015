<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

use App\Models\DisponibiliteArbitre;
use App\Models\Arbitre;

class DisponibilitesArbitresTableSeeder extends Seeder {

    /**
     * Création d'arbitres dans la base de données
     */
    public function run()
    {
        DB::table('disponibilites_arbitres')->delete();


        $entrees = [
            //arbitre_id    date            debut           fin 	        commentaire
            ["0",           "2016/12/24",   "08:00:00",		"12:00:00",		""],
            ["0",           "2016/12/25",   "11:00:00",		"17:30:00",		"commentaire utile"],
            ["1",           "2017/01/02",  	"08:15:00",		"10:00:00",		""],
            ["2",           "2015/10/13",	"14:45:00",		"15:00:00",		"arbitre très disponible"]
        ];

        $arbitres = Arbitre::all();

        foreach($entrees as $entree) {
            $disponibilite_arbitre = new DisponibiliteArbitre();

            //arbitre_id correspond à la position de l'arbitre voulu dans $arbitres[]
            $disponibilite_arbitre->arbitre_id = $arbitres[$entree[0]]->id;

            $disponibilite_arbitre->date = $entree[1];
            $disponibilite_arbitre->debut = $entree[2];
            $disponibilite_arbitre->fin = $entree[3];
            $disponibilite_arbitre->commentaire = $entree[4];

            $disponibilite_arbitre->save();

        }
    }
}