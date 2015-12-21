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

        // Chargement de la liste des sports existants
        $sports = Sport::all();

        // Création d'une liste de valeurs par défaut
        $items = [
        ["Football 1 Cégep de Drummondville",   "960 Rue Saint-Georges",   "Drummondville", [0,1,2]],
        ["Football 2 Cégep de Drummondville",   "960 Rue Saint-Georges",   "Drummondville", [0,1,2]],
        ["Football 3 Cégep de Drummondville",   "960 Rue Saint-Georges",   "Drummondville", [0,1,2]],
        ["Soccer 1 Cégep de Drummondville",     "960 Rue Saint-Georges",   "Drummondville", [0,1,2]],
        ["Soccer 2 Cégep de Drummondville",     "960 Rue Saint-Georges",   "Drummondville", [0,1,2]],
        ["Football 1 Marie-Rivier",             "265 Rue Saint Félix",     "Drummondville", [0,1,2]],
        ["Football 2 Marie-Rivier",             "265 Rue Saint Félix",     "Drummondville", [0,1,2]],
        ["Football 3 Marie-Rivier",             "265 Rue Saint Félix",     "Drummondville", [0,1,2]],
        ["Soccer 1 Marie-Rivier",               "265 Rue Saint Félix",     "Drummondville", [0,1,2]],
        ["Soccer 2 Marie-Rivier",               "265 Rue Saint Félix",     "Drummondville", [0,1,2]],
        ["Football 1 Jean-Raimbault",           "175 Rue Pelletier",       "Drummondville", [0,1,2]],
        ["Football 2 Jean-Raimbault",           "175 Rue Pelletier",       "Drummondville", [0,1,2]],
        ["Football 3 Jean-Raimbault",           "175 Rue Pelletier",       "Drummondville", [0,1,2]],
        ["Soccer 1 Jean-Raimbault",             "175 Rue Pelletier",       "Drummondville", [0,1,2]],
        ["Soccer 2 Jean-Raimbault",             "177 Rue Pelletier",       "Drummondville", [0,1,2]]
        ];

        // Création d'objet 'terrain' et sauvegarde de ceux-ci dans la base de données 
        
        foreach($items as $item) {
            $terrain = new Terrain();
            $terrain->nom = $item[0];
            $terrain->adresse = $item[1];
            $terrain->ville = $item[2];
            $terrain->region_id = Region::where("nom_court","=","CDQ")->first()->id; //un peu de favoritisme pour le Centre du Québec. 
            $terrain->save();

            // Ajout de l'association entre les terrains et les sports
            $index_sports = array();
            for ($x = 0; $x < count($item[3]); $x++) {
                array_push($index_sports, $sports[$x]->id);  
            }
            $terrain->sports()->sync($index_sports);
        }
    }
}