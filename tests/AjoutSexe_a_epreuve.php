<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Models\Epreuve;
use App\Models\Participant;

class AjoutSexe_a_epreuve extends TestCase
{

    use DatabaseTransactions;

    public function setUp()
    {
        parent::setUp();
        $user = factory(App\User::class)->create();
        $this->actingAs($user);
    }


    /**
     * @test
     */
    public function testRedirect()
    {

    }

    /**
     * @test
     *
     * @return void
     */
    public function testEpreuve_mixte_vers_masculin()
    {
        $this->creation_participant("M","9000");  // Création d'un participant masculin
        $participants = Participant::all();
        $participant_M = $participants->find('numero',"9000");

        $this->creation_participant("F","9001");  // Création d'une participant féminin
        $participants = Participant::all();
        $participant_F = $participants->find('numero',"9001");

        $this->creation_epreuve("MF");
        $epreuves = Epreuve::all();
        $epreuve_MF = $epreuves->find('','Test_MF');


        //$this->ajouter_participant_dans_epreuve($epreuve_MF);



        $this->assertTrue(true);
    }

    /**
     * Cette fonction permet la création d'un participant
     * selon un sexe.
     *
     * @var string : 'F' pour féminin et 'M' pour masculin
     *
     * @return void
     *
     */
    public function creation_participant($sexe, $numero)
    {
        $this->visit("participants/create");
        if ($sexe == "F"){
            $prenom = "Alice";
            $sexeId = "1";
        }else{
            $prenom = "Bob";
            $sexeId = "0";
        }
        $this->type('Wonder','nom')
            ->type($prenom,'prenom')
            ->type($numero,'numero')
            ->select($sexeId,"sexe")
            ->select("2000","annee_naissance")
            ->select("10","mois_naissance")
            ->select("20","jour_naissance")
            ->check("sport[1]");
    }



    public function creation_epreuve($categorieSexe)
    {
        $this->visit("epreuves/create");

        if ($categorieSexe == "F"){
            $genre = "1";
        }elseif ($categorieSexe == "M"){
            $genre = "0";
        }else{
            $genre = "2";
        }

        $this->type(('Test_'.$categorieSexe),"nom")
            ->select($genre,"genre")
            ->press('Créer');

    }

    public function ajouter_participant_dans_epreuve($idEpreuve, $idParticipant)
    {
        $this->visit("ajtParticipant/".$idEpreuve);

        $this->check("participants[".$idParticipant."]");

        $this->press("Appliquer");



    }


}
