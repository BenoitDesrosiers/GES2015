<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

use App\Models\Terrain;

class TerrainsTableSeeder extends Seeder {


    public function run()
    {
        // Suppression de la base de données
        DB::table('terrains')->delete();

        // Création de la variable sport qui correspond aux 
        // informations de la table 'sport' de la base de données
        $sports=DB::table('sports');

        // Création de la variable 'terrain' qui correspond à la 
        // liste des champs à 'seeder' dans la base de données
        $terrains = [
        ["Football 1 Cégep de Drummondville",   "960 Rue Saint-Georges",    "Drummondville", "4"],
        ["Football 2 Cégep de Drummondville",   "960 Rue Saint-Georges",    "Drummondville", "4"],
        ["Football 3 Cégep de Drummondville",   "960 Rue Saint-Georges",    "Drummondville", "4"],
        ["Soccer 1 Cégep de Drummondville",     "960 Rue Saint-Georges",    "Drummondville", "4"],
        ["Soccer 2 Cégep de Drummondville",     "960 Rue Saint-Georges",    "Drummondville", "4"],
        ["Football 1 Marie-Rivier",             "265 Rue Saint Félix",      "Drummondville", "4"],
        ["Football 2 Marie-Rivier",             "265 Rue Saint Félix",      "Drummondville", "4"],
        ["Football 3 Marie-Rivier",             "265 Rue Saint Félix",      "Drummondville", "4"],
        ["Soccer 1 Marie-Rivier",               "265 Rue Saint Félix",      "Drummondville", "4"],
        ["Soccer 2 Marie-Rivier",               "265 Rue Saint Félix",      "Drummondville", "4"],
        ["Football 1 Jean-Raimbault",           "175 Rue Pelletier",        "Drummondville", "4"],
        ["Football 2 Jean-Raimbault",           "175 Rue Pelletier",        "Drummondville", "4"],
        ["Football 3 Jean-Raimbault",           "175 Rue Pelletier",        "Drummondville", "4"],
        ["Soccer 1 Jean-Raimbault",             "175 Rue Pelletier",        "Drummondville", "4"],
        ["Soccer 2 Jean-Raimbault",             "177 Rue Pelletier",        "Drummondville", "4"]
        ];

        // 'seed' de la base de données
        foreach($terrains as $terrain) {
            Terrain::create(
                array(
                    'nom'=>$terrain[0], 
                    'adresse'=>$terrain[1], 
                    'ville'=>$terrain[2],  
                    'region_id'=>$terrain[3])
                );
            // Pour chaque valeur envoyée lors du 'seed', ajout 
            // d'une valeur aléatoire pour le sport associé
            for($j=0;$j<rand(1,4);$j++) {
                DB::table('sport_terrain')->insert(array('terrain_id' => DB::table('terrains')->max('id'), 'sport_id' => rand($sports->min('id'),$sports->max('id'))));
            }
        }
    }
}