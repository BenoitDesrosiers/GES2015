<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

use App\Models\Benevole;

class BenevolesTableSeeder extends Seeder {


	public function run()
	{
        //nom, prenom, adresse, numTel, numCell, courriel, disponibilite, accreditation, verification
        $infos = [
		["Desrosiers", "Jérémi", "123 rue Duniquab, Drummondville, J2C 1A1", "8194771234", "8198181234", "j.desrosiers@evenement-sportif.ca", "Tous les matins", "000A123", "À faire"],
		["Pedneault", "Eric", "124 rue Petinichon, Drummondville, J2C 1A2", "8194772345", "8198182345", "e.pedneault@evenement-sportif.ca", "Tous les soirs", "000B123", "En attente"],
		["Girardin", "Simon", "125 rue Sainte-Paire, Drummondville, J2C 1A3", "8194773456", "8198183456", "s.girardin@evenement-sportif.ca", "Mercredi seulement", "000C123", "Fait" ],
        ["Lehoux", "Alexandre", "126 boul. Delamarde, Drummondville, J2C 1A4", "8194774567", "8198184567", "a.lehoux@evenement-sportif.ca", "En tous temps", "000D123", "Fait"],
        ["Dubé", "Sarah", "127 rue Dunimportequoi, Drummondville, J2C 1A5", "8194775678", "8198185678", "s.dube@evenement-sportif.ca", "En tous temps, sauf le mardi", "000E123", "Fait"],
		];

        DB::table('benevoles')->delete();
        foreach($infos as $info) {
		    $benevole = new Benevole();
		    $benevole->nom = $info[0];
		    $benevole->prenom = $info[1];
		    $benevole->adresse = $info[2];
		    $benevole->numTel = $info[3];
		    $benevole->numCell = $info[4];
		    $benevole->courriel = $info[5];
            $benevole->disponibilite = $info[6];
		    $benevole->accreditation = $info[7];
		    $benevole->verification = $info[8];
            $benevole->save();		
        }
	}
}
