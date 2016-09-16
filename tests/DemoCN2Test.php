<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class DemoCN2Test extends TestCase
{
	use DatabaseTransactions; // <---- permet de ne pas créer plein de "déchets" dans la bd. 
	
    /**
     * A basic test example.
     *
     * @return void
     */
	
	public function setUp()
	{
		parent::setup();
		$user = factory(App\User::class)->create();
		$this->actingAs($user);
	}
	
	
    public function la_page_de_creation_demande_la_date_naissance_et_le_sexe()
    {
        $this->visit('/benevoles/create')
        	->see('date_naissance')
        	->see('sexe');
    }
    
   
    
    /** @test */
    public function la_view_create_permet_d_entrer_la_date_naissance_et_un_des_trois_sexes_permis()
    {
    	$this->visit('/benevoles/create'); //va sur la page de création des bénévoles
    	$this->seeInField('sexeh', 'h') // verifie que les 3 choix sont présents
    	->seeInField('sexef', 'f')
    	->seeInField('sexea', 'a');
    	
    	$this->type('2015-01-01','date_naissance')
    	->select('f', 'sexe'); // choisi femme
    	
    	$this->remplir_les_champs_non_testes();
    	
       	$this->press('Créer');
    	;
    	
    	$this->seeInDatabase('benevoles', ['nom'=>'Nic', 'date_naissance'=>'2015-01-01', 'sexe'=>'f']); // est-ce que l'entrée est dans la BD
    }
    
    

    /** @test */
    public function la_view_show_affiche_la_date_et_le_sexe()
    {
    	$benevole = factory(App\Models\Benevole::class)->create();
    	    	   
    	$this->visit('/benevoles/'.$benevole->id)
    		->see('date de naissance') // un peu trop connecté à l'interface 
        	->see('sexe'); 
    }
   
    
    private function remplir_les_champs_non_testes ()
    {
    	//remplie les autres champs ... mais ca ne fait pas parti de ce test
    	$this->type('Nic', 'nom')
    	->type('Pic', 'prenom')
    	->type('En ballon', 'adresse')
    	->type('123-456-7890','numTel')
    	->type('987-654-4321', 'numCell')
    	->type('PicNic@radiocanada.ca', 'courriel')
    	->type('ben oui', 'accreditation')
    	->check('verification','f');    }
}
