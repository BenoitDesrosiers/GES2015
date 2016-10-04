<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\Models\Voiture;

class DemoVoitureTest extends TestCase
{
	
    /**
     * Demo de la construction d'un test pour CN2
     *
     * @return void
     */
	
	use DatabaseTransactions; // <---- permet de ne pas créer plein de "déchets" dans la bd.
	
	/** @test */
    public function la_creation_d_une_voiture_fonctionne()
    {
        $voiture = factory(App\Models\Voiture::class)
        	->make(['modele'=>'Kia', 'date_achat'=>'2015-01-01', 'identifiant'=> 101 ]);
        $this->assertEquals('Kia', $voiture->modele);
        $this->assertEquals('2015-01-01', $voiture->date_achat);
        $this->assertEquals(101, $voiture->identifiant);
    }
    
    /** @test */
    public function la_creation_d_une_voiture_fonctionne_dans_la_BD()
    {
    	$voiture = factory(App\Models\Voiture::class)
    	->create();
    	$this->seeInDatabase('Voitures', ['id'=>$voiture->id, 
    										'modele'=>$voiture->modele, 
    										'identifiant'=>$voiture->identifiant,
    										'date_achat'=>$voiture->date_achat
								    	]);
    }

    /** @test 
     * @expectedException PDOException*/
    public function le_champ_model_est_valide()
    {
        //$this->setExpectedException(PDOException::class);
       	//le champs modele est obligatoire dans la description du problème
    	$voiture = factory(App\Models\Voiture::class)
    	->create(['modele'=>null]);
    }
    
    /** @test
     * @expectedException PDOException
     * @dataProvider nullProvider */
    public function les_champs_sont_valide($modele, $identifiant, $date_achat)
    {
    	$voiture = factory(App\Models\Voiture::class)
    	->create(['modele'=>$modele, 'identifiant'=>$identifiant, 'date_achat'=>$date_achat]);
    }

    
    public function nullProvider()
    {
    	return [
    			'modele' => [null, '1', '2015-01-01'],
    			'identifiant' => ['kia', null, '2015-01-01'],
    			'date_achat' => ['kia', '1', null]
    	    	];
    }
    
    
    /** @test */
    public function on_peut_creer_une_voiture_avec_l_interface_et_le_validateur_de_Laravel()
    {
    	
    	//La première chose à tester est si on peut créer une voiture avec une view. 
    	$user = factory(App\User::class)->create();
    	$this->actingAs($user);
    	$this->visit('/voitures/create')
    	->see('modele');
    	
    	$this->type('Kia', 'modele');
    	$this->type('2016-01-01', 'date_achat');
    	$this->type('1023', 'identifiant');
    	$this->press('Créer');
    	
    	$this->seeInDatabase('voitures', ['modele' => 'Kia']);
    }
    
    /** @test */
    public function le_validateur_de_Laravel_assure_que_le_modele_est_obligatoire()
    {
    	 
    	//La première chose à tester est si on peut créer une voiture avec une view.
    	$user = factory(App\User::class)->create();
    	$this->actingAs($user);
    	$this->visit('/voitures/create')
    	->see('modele');
    	 
		//on ne fournit pas le modele. 
    	$this->type('2016-01-01', 'date_achat');
    	$this->type('1023', 'identifiant');
    	$this->press('Créer');
    	 
    	$this->dontseeInDatabase('voitures', ['modele' => 'Kia']);
    }
   
    
    
}
