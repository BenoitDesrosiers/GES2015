<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class DemoCN2Test extends TestCase
{
	use DatabaseMigrations;
	
    /**
     * A basic test example.
     *
     * @return void
     */
	/** @test */
    public function la_page_de_creation_demande_la_date_naissance_et_le_sexe()
    {
    	$user = factory(App\User::class)->create();
    	$this->actingAs($user);
        $this->visit('/benevoles/create')
        	->see('date_naissance')
        	->see('sexe');
    }
    
    /** @test */
    public function on_peut_entrer_la_date_naissance_et_le_sexe()
    {
    	
    	$user = factory(App\User::class)->create();
    	$this->actingAs($user);
    	$this->visit('/benevoles/create')
    	->type('2015-01-01','date_naissance')
    	//->check('f')
    	//->check('h')
    	->check('sexe')
    	//remplie les autres champs ... mais ca ne fait pas parti de ce test
    	->type('Nic', 'nom')
    	->type('Pic', 'prenom')
    	->type('En ballon', 'adresse')
    	->type('123-456-7890','numTel')
    	->type('987-654-4321', 'numCell')
    	->type('PicNic@radiocanada.ca', 'courriel')
    	->type('ben oui', 'accreditation')
    	->check('verification')
       	->press('Créer')
    	;
    	
    	
    	
    }
}
