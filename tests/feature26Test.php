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
        $region = factory(Region::class)
            ->create();
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
        $participant = factory(Participant::class)
            ->create();
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
        $sport = factory(Sport::class)
            ->create();
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
    public function toutes_les_regions_sont_dans_le_dropdown()
    {
        $this->connexion();
        $region = factory(Region::class)
            ->create();
        $sport = factory(Sport::class)
            ->create();
        $this->visit('/sports/'. $sport->id .'/participants');
        $this->select($region->nom, 'dropdown');
        $this->see($region->name);
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
