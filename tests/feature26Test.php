<?php

use App\Models\Participant;
use App\Models\Region;
use App\Models\Sport;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class feature26Test extends TestCase
{
    use DatabaseTransactions;

    /**
     * Je n'aurais pas besoin de tester si la création d'une région fonctionne puisque je n'ai pas crée le modèle.
     * Cependant, tant qu'à l'utiliser, aussi bien m'assurer que ça fonctionne.
     * @test
     */
    public function creation_dune_region_fonctionne()
    {
        $region = $this->creerRegion();
        $this->seeInDatabase('regions', [
            'nom'=>$region->nom,
            'nom_court'=>$region->nom_court
        ]);
    }

    /**
     * Je n'aurais pas besoin de tester si la création d'un participant fonctionne puisque je n'ai pas crée le modèle.
     * Cependant, tant qu'à l'utiliser, aussi bien m'assurer que ça fonctionne.
     * @test
     */
    public function creation_dun_participant_fonctionne()
    {
        $participant = $this->creerParticipant();
        $this->seeInDatabase('participants', [
            'nom' => $participant->nom,
            'prenom' => $participant->prenom,
            'numero' => $participant->numero,
            'region_id' => $participant->region_id,
            'equipe' => $participant->equipe,
            'sexe' => $participant->sexe
        ]);
    }

    /**
     * Je n'aurais pas besoin de tester si la création d'un sport fonctionne puisque je n'ai pas crée le modèle.
     * Cependant, tant qu'à l'utiliser, aussi bien m'assurer que ça fonctionne.
     * @test
     */
    public function creation_dun_sport_fonctionne()
    {
        $sport = $this->creerSport();
        $this->seeInDatabase('sports', [
            'nom' => $sport->nom,
            'saison' => $sport->saison,
            'tournoi' => $sport->tournoi
        ]);
    }

    /**
     * S'assure qu'il est possible appuyé sur une région dans la liste déroulante des régions.
     * @test
     */
    public function on_peut_selectionner_une_region()
    {
        $this->connexion();
        $region = $this->creerRegion();
        $sport = $this->creerSport();
        $this->visit('/sports/'. $sport->id .'/participants');
        $this->select($region->nom, 'region');
        $this->see($region->name);
    }

    /**
     * S'assure que l'appel ajax, déclenché après avoir sélectionné une région, retourne les participants d'une région.
     * @test
     */
    public function choisir_une_region_affiche_ses_participants()
    {
        $this->connexion();
        $participant = $this->creerParticipant();
        $region = $participant->region;

        // FIXME: Utiliser get() comme dans la documentation, mais même Louis n'a pas réussi.
        $this->get('/tableau_participants?region_id=' . $region->id)
            ->seeJson([
               'id' => $participant->id,
            ]);
    }

    /**
     * Créer une région à partir de la factory Region.
     * @return Region
     */
    protected function creerRegion():Region
    {
        $region = factory(Region::class)
            ->create();
        return $region;
    }

    /**
     * Créer un participant à partir de la factory Participant.
     * @return Participant
     */
    protected function creerParticipant():Participant
    {
        $participant = factory(Participant::class)
            ->create();
        return $participant;
    }

    /**
     * Créer un sport à partir de la factory Sport.
     * @return Sport
     */
    protected function creerSport():Sport
    {
        $sport = factory(Sport::class)
            ->create();
        return $sport;
    }

    /**
     * Méthode pour simuler une connexion d'un usager.
     */
    protected function connexion()
    {
        $user = factory(App\User::class)->create();
        $this->actingAs($user);
    }
}
