<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class TerrainsTableSeeder extends Seeder {


    public function run()
    {
        DB::table('terrains')->delete();

        $terrains = [
        //nom, tournoi (1=oui, 0=non)
        ["Football 1 Cégep de Drummondville","960 Rue Saint-Georges, Drummondville, QC J2C 6A2", "118"],
        ["Football 2 Cégep de Drummondville","960 Rue Saint-Georges, Drummondville, QC J2C 6A2", "118"],
        ["Football 3 Cégep de Drummondville","960 Rue Saint-Georges, Drummondville, QC J2C 6A2", "118"],
        ["Soccer 1 Cégep de Drummondville","960 Rue Saint-Georges, Drummondville, QC J2C 6A2", "118"],
        ["Soccer 2 Cégep de Drummondville","960 Rue Saint-Georges, Drummondville, QC J2C 6A2", "118"],
        ["Football 1 Marie-Rivier","265 Rue Saint Félix, Drummondville, QC J2C 5M1", "118"],
        ["Football 2 Marie-Rivier","265 Rue Saint Félix, Drummondville, QC J2C 5M1", "118"],
        ["Football 3 Marie-Rivier","265 Rue Saint Félix, Drummondville, QC J2C 5M1", "118"],
        ["Soccer 1 Marie-Rivier","265 Rue Saint Félix, Drummondville, QC J2C 5M1", "118"],
        ["Soccer 2 Marie-Rivier","265 Rue Saint Félix, Drummondville, QC J2C 5M1", "118"],
        ["Football 1 Jean-Raimbault","175 Pelletier, Drummondville, QC J2C 2W1", "118"],
        ["Football 2 Jean-Raimbault","175 Pelletier, Drummondville, QC J2C 2W0", "118"],
        ["Football 3 Jean-Raimbault","175 Pelletier, Drummondville, QC J2C 2W1", "118"],
        ["Soccer 1 Jean-Raimbault","175 Pelletier, Drummondville, QC J2C 2W1", "118"],
        ["Soccer 2 Jean-Raimbault","177 Pelletier, Drummondville, QC J2C 2W1", "118"],
        ];

        foreach($terrains as $terrain) {
            Terrain::create(array('nom'=>$terrain[0],'adresse'=>$terrain[1],'region_id'=>$terrain[2]));
        }
    }
}