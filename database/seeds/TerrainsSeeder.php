<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

use App\Models\Terrain;
use App\Models\Region;
use App\Models\Sport;

class TerrainsTableSeeder extends Seeder {

    public function run()
    {
        // Suppression de la table 'terrains' de la base de données
        DB::table('terrains')->delete();

        // Chargement de la liste des régions et des sports existants
        $regions = DB::table('regions')->get();
        $sports = DB::table('sports')->get();

        // Création d'une liste de valeurs par défaut
        $items = [
        ["Football 1 Cégep de Drummondville",   "960 Rue Saint-Georges",   "Drummondville"],
        ["Football 2 Cégep de Drummondville",   "960 Rue Saint-Georges",   "Drummondville"],
        ["Football 3 Cégep de Drummondville",   "960 Rue Saint-Georges",   "Drummondville"],
        ["Soccer 1 Cégep de Drummondville",     "960 Rue Saint-Georges",   "Drummondville"],
        ["Soccer 2 Cégep de Drummondville",     "960 Rue Saint-Georges",   "Drummondville"],
        ["Football 1 Marie-Rivier",             "265 Rue Saint Félix",     "Drummondville"],
        ["Football 2 Marie-Rivier",             "265 Rue Saint Félix",     "Drummondville"],
        ["Football 3 Marie-Rivier",             "265 Rue Saint Félix",     "Drummondville"],
        ["Soccer 1 Marie-Rivier",               "265 Rue Saint Félix",     "Drummondville"],
        ["Soccer 2 Marie-Rivier",               "265 Rue Saint Félix",     "Drummondville"],
        ["Football 1 Jean-Raimbault",           "175 Rue Pelletier",       "Drummondville"],
        ["Football 2 Jean-Raimbault",           "175 Rue Pelletier",       "Drummondville"],
        ["Football 3 Jean-Raimbault",           "175 Rue Pelletier",       "Drummondville"],
        ["Soccer 1 Jean-Raimbault",             "175 Rue Pelletier",       "Drummondville"],
        ["Soccer 2 Jean-Raimbault",             "177 Rue Pelletier",       "Drummondville"]
        ];

        // Création d'objet 'terrain' et sauvegarde de ceux-ci dans la base de données 
        foreach($items as $item) {
            $terrain = new Terrain();
            $terrain->nom = $item[0];
            $terrain->adresse = $item[1];
            $terrain->ville = $item[2];
            $terrain->region_id = rand(1, count($regions));  //FIXME: si les id de régions ne sont pas de 1 à count, ca va planter quand même. Il faut choisir une région au hasard, et prendre son id. 
            $terrain->save();

            // Ajout d'une valeur aléatoire dans la table 'sports_terrains'
            $index_sports = array();
            for ($x = 1; $x < rand(1, count($sports)); $x++) {
                $rand_bin_value = rand(0, 1);
                if ($rand_bin_value === 1) {
                    array_push($index_sports, $x);  //FIXME: ici aussi, c'est pas la valeur de random qu'il faut stocker, mais bien l'id du sport à la position random
                }   
            }
            $terrain->sports()->sync($index_sports);
        }
    }
}