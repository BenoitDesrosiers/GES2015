<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use Symfony\Component\HttpFoundation\Request;

class EvenementParticipantTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * Teste que le lien entre le modèle des événements et le modèle des participants
     * soit valide.
     *
     * @test
     */
    public function testLienModeleValide()
    {
        $evenement = factory(App\Models\Evenement::class)->create();
        $participant = factory(App\Models\Participant::class)->create();

        $evenement->participants()->attach($participant->id);
        $this->seeInDatabase('evenement_participant', [
            'evenement_id' => $evenement->id,
            'participant_id' => $participant->id
        ]);
    }

    /**
     * Teste que le contrôleur envoie les données valides à la vue.
     *
     * @test
     */
    public function testEnvoiDonneesControleur()
    {
        $this->withoutMiddleware();
        $evenement = factory(App\Models\Evenement::class)->create();
        $participant = factory(App\Models\Participant::class)->create();
        $evenement->epreuve->participants()->attach($participant->id);
        $this->action('GET', 'EvenementParticipantController@index', ['id' => $evenement->id]);
        $this->assertViewHas('evenement');
        $this->assertViewHas('participants');
    }

    /**
     * Teste que la vue affiche les participants associés à l'épreuve associée à l'événement.
     *
     * @test
     */
    public function testVueRecoitDonneesValides()
    {
        $this->withoutMiddleware();
        $evenement = factory(App\Models\Evenement::class)->create();
        $participant = factory(App\Models\Participant::class)->create();
        $evenement->epreuve->participants()->attach($participant->id);
        $this->visit('evenements/'.$evenement->id.'/participants');
        $this->assertViewHas('evenement');
        $this->assertViewHas('participants');

        $participants = $this->response->original->getData()['participants'];
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $participants);
        $this->assertEquals($participants->first()->id, $participant->id);
        $this->assertEquals($evenement->id, $this->response->original->getData()['evenement']->id);
    }

    /**
     * Teste que le contrôleur ajoute les données lorsqu'on l'appelle en POST.
     *
     * @test
     */
    public function testValeurRetourControleur()
    {
        $this->withoutMiddleware();
        $evenement = factory(App\Models\Evenement::class)->create();
        $participant = factory(App\Models\Participant::class)->create();
        $donnees = ['evenement' => $evenement->id, 'participation' => [$participant->id => 'on']];
        $this->call('POST', 'evenements/'.$evenement->id.'/participants', $donnees);
        $this->seeInDatabase('evenement_participant', [
            'evenement_id'=>$evenement->id,
            'participant_id'=>$participant->id
        ]);
    }

    /**
     * Teste que le lien entre un événement et un participant dans la base de données
     * s'enlève lorsqu'un événement est effacé.
     *
     * @test
     */
    public function testEnleverLiensEvenementEfface()
    {
        $this->withoutMiddleware();
        $evenement = factory(App\Models\Evenement::class)->create();
        $participant = factory(App\Models\Participant::class)->create();
        $evenement->participants()->attach($participant->id);
        $this->seeInDatabase('evenement_participant', [
            'evenement_id' => $evenement->id,
            'participant_id' => $participant->id]);

        $evenement->delete();
        $this->notSeeInDatabase('evenement_participant', [
            'evenement_id' => $evenement->id,
            'participant_id' => $participant->id]);
    }

    /**
     * Teste que le lien entre un événement et un participant dans la base de données
     * s'enlève lorsqu'un participant est effacé.
     *
     * @test
     */
    public function testEnleverLiensParticipantEfface()
    {
        $this->withoutMiddleware();
        $evenement = factory(App\Models\Evenement::class)->create();
        $participant = factory(App\Models\Participant::class)->create();
        $evenement->participants()->attach($participant->id);
        $this->seeInDatabase('evenement_participant', [
            'evenement_id' => $evenement->id,
            'participant_id' => $participant->id]);

        $participant->delete();
        $this->notSeeInDatabase('evenement_participant', [
            'evenement_id' => $evenement->id,
            'participant_id' => $participant->id]);
    }


}
