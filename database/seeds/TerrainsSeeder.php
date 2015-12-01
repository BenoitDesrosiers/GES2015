<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

use App\Models\Terrain;
use App\Models\Region;
use App\Models\Sport;

class TerrainsTableSeeder extends Seeder {


    public function run()
    {
        // Suppression de la base de données
        DB::table('terrains')->delete();

        $regions = DB::table('regions')->get();
        $sports = DB::table('sports')->get();

        // Création de la variable 'items' qui correspond à la 
        // liste des champs à 'seeder' dans la base de données
        $items = [
        ["Football 1 Cégep de Drummondville",   "960 Rue Saint-Georges",    "Drummondville"],
        ["Football 2 Cégep de Drummondville",   "960 Rue Saint-Georges",    "Drummondville"],
        ["Football 3 Cégep de Drummondville",   "960 Rue Saint-Georges",    "Drummondville"],
        ["Soccer 1 Cégep de Drummondville",     "960 Rue Saint-Georges",    "Drummondville"],
        ["Soccer 2 Cégep de Drummondville",     "960 Rue Saint-Georges",    "Drummondville"],
        ["Football 1 Marie-Rivier",             "265 Rue Saint Félix",      "Drummondville"],
        ["Football 2 Marie-Rivier",             "265 Rue Saint Félix",      "Drummondville"],
        ["Football 3 Marie-Rivier",             "265 Rue Saint Félix",      "Drummondville"],
        ["Soccer 1 Marie-Rivier",               "265 Rue Saint Félix",      "Drummondville"],
        ["Soccer 2 Marie-Rivier",               "265 Rue Saint Félix",      "Drummondville"],
        ["Football 1 Jean-Raimbault",           "175 Rue Pelletier",        "Drummondville"],
        ["Football 2 Jean-Raimbault",           "175 Rue Pelletier",        "Drummondville"],
        ["Football 3 Jean-Raimbault",           "175 Rue Pelletier",        "Drummondville"],
        ["Soccer 1 Jean-Raimbault",             "175 Rue Pelletier",        "Drummondville"],
        ["Soccer 2 Jean-Raimbault",             "177 Rue Pelletier",        "Drummondville"]
        ];

        //todo: lire les régions à partir de la BD et associer des ids de régions qui existent
        //      car ca cause un bug lors d'un second seed car les id de régions de sont pas 1,2,3,4
        //      si on aurait utilisé Terrain::save au lieu de create, cette erreur aurait été détecté avant...
        // 		voir ArbitresSeeder pour un exemple de comment le faire.  
         
        // 'seed' de la base de données

        foreach($items as $item) {
            $terrain = new Terrain();
            $terrain->nom = $item[0];
            $terrain->adresse = $item[1];
            $terrain->ville = $item[2];
            $terrain->region_id = rand(1, count($regions));
            $terrain->save();
            $index_sports = array();
            for ($x = 1; $x < rand(1, count($sports)); $x++) {
                $test = rand(0, 1);
                if ($test === 1) {
                    array_push($index_sports, $x);
                }   
            }
            $terrain->sports()->sync($index_sports);
        }
    }
}