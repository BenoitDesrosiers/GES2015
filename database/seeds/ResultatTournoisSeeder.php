<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

use App\Models\Resultat;

class ResultatTournoisTableSeeder extends Seeder {


	public function run()
	{
		DB::table('resultats_tournois')->delete();
		$evenements = DB::table('evenements');
		$epreuves = DB::table('epreuves');
		$participants = DB::table('participant_sport');

		$liens = array();

		foreach($evenements->get() as $evenement) {
			//var_dump($evenement);
			$epreuve = $epreuves->where('id', $evenement->epreuve_id)->first();
			foreach($participants->get() as $participant) {
				//var_dump($participant);
				if ($participant->sport_id == $epreuve->sport_id) {
					echo "Matching ".$participant->participant_id." => ".$evenement->id."\r\n";
					array_push($liens, array($evenement->id => $participant->participant_id));
				}
			}
		}
		echo "hi!";
		foreach($liens as $lien) {
			if ($lien[1] != null) {
				$res1 = rand(1, 10);
				$res2 = rand(1, 10);
				$pts1 = ($res1 * 10) - rand(1, 10);
				$pts2 = ($res2 * 10) - rand(1, 10);
				if ($res1 > $res2) {
					DB::table('resultats_tournois')->insert(array('evenement_id' => $evenement->pluck('id'), 'participant1_id' => $lien[0]->pluck('id'), 'participant2_id' => $lien[1]->pluck('id'), 'resultat1' => $res1, 'resultat2' => $res2, 'points1' => $pts1, 'points2' => $pts2, 'gagnant_id' => $lien[0]->pluck('id')));
				}
				elseif ($res1 < $res2) {
					DB::table('resultats_tournois')->insert(array('evenement_id' => $evenement->pluck('id'), 'participant1_id' => $lien[0]->pluck('id'), 'participant2_id' => $lien[1]->pluck('id'), 'resultat1' => $res1, 'resultat2' => $res2, 'points1' => $pts1, 'points2' => $pts2, 'gagnant_id' => $lien[1]->pluck('id')));
				}
				else {
					DB::table('resultats_tournois')->insert(array('evenement_id' => $evenement->pluck('id'), 'participant1_id' => $lien[0]->pluck('id'), 'participant2_id' => $lien[1]->pluck('id'), 'resultat1' => $res1, 'resultat2' => $res2, 'points1' => $pts1, 'points2' => $pts2));
				}
			}
		}
	}
}