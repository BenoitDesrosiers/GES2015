<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Models\Benevole;
use App\Models\Disponibilite;

class DisponibilitesBenevolesTest extends TestCase
{
	use DatabaseTransactions;
	
	/**
	 * @test
	 * 
	 * sauvegarder les disponibilités dans une BD
	 */
    public function sauvegarde_d_un_bon_modele()
    {
    	$benevoles = Benevole::all();
    	$disponibilite = new Disponibilite;
    	$disponibilite->benevole_id = $benevoles[0]->id;
    	$disponibilite->title = 'test_sauvegarde_d_un_bon_modele';
    	$disponibilite->isAllDay = 0;
    	$disponibilite->start = "2016-12-08 08:00:00";
    	$disponibilite->end = "2016-12-08 16:00:00";
    	$this->assertTrue($disponibilite->save());
    	$this->seeInDatabase('disponibilites', [
    			'id'=>$disponibilite->id,
    			'benevole_id'=>$disponibilite->benevole_id,
    			'title'=>$disponibilite->title,
    			'isAllDay'=>$disponibilite->isAllDay,
    			'start'=>$disponibilite->start,
    			'end'=>$disponibilite->end
    	]); 
    }
    
    /**
     * @test
     * @expectedException Exception
     * 
     * convertir une date en format AAAA-MM-JJ
     */
    public function une_mauvaise_date_fait_une_exception()
    {
    	$disponibilite = new disponibilite;
    	$disponibilite->start = "allo";
    }
    
    /**
    * @test
    *
    * la date peut être entrée dans le format AAAA-MM-JJ HH:MM:SS
    */
    public function le_format_date_aaaa_mm_jj_est_valide()
    {
    	$disponibilite = new Disponibilite;
    	$disponibilite->start = "2000-12-25 08:12:25";
    	$this->assertTrue("2000-12-25 08:12:25"==$disponibilite->start);
    	$disponibilite->start = "1999-12-25 04:25:12";
    	$this->assertTrue("1999-12-25 04:25:12"==$disponibilite->start);
    	$disponibilite->start = "3000-12-25 13:30:00";
    	$this->assertTrue("3000-12-25 13:30:00"==$disponibilite->start);
    	$disponibilite->start = "1869-12-25 00:00:00";
    	$this->assertTrue("1869-12-25 00:00:00"==$disponibilite->start);
    	
    	$disponibilite->end = "2000-12-25 08:12:25";
    	$this->assertTrue("2000-12-25 08:12:25"==$disponibilite->end);
    	$disponibilite->end = "1999-12-25 04:25:12";
    	$this->assertTrue("1999-12-25 04:25:12"==$disponibilite->end);
    	$disponibilite->end = "3000-12-25 13:30:00";
    	$this->assertTrue("3000-12-25 13:30:00"==$disponibilite->end);
    	$disponibilite->end = "1869-12-25 00:00:00";
    	$this->assertTrue("1869-12-25 00:00:00"==$disponibilite->end);
    
    }
    
    /**
     *
    * @test
    */
    public function les_routes_CRUD_existent()
    {
    	$this->visit("/disponibilites"); //index
    	$this->visit("/disponibilites/create"); //create
    	$this->visit("/disponibilites/edit"); //update
    	$this->visit("/disponibilites/show"); //read
    
    }
    

    /**
     * @test
     */
    /*public function le_ctrl_envoie_les_disponibilites_a_l_index()
    {
    	$this->visit('/disponibilites')
    	->assertViewHas('disponibilites');
    }*/
    
    /**
     * @test
    */
    /*public function le_ctrl_envoie_toutes_les_disponibilites_a_la_view()
    {
    	for($i = 0; $i< 5; $i++) {
    		$lesDisponibilites[$i] = factory(App\Models\Disponibilite::class)->create();
    	}
    	$this->visit('/disponibilites')
    	->assertViewHas('disponibilites');
    	 
    	$personnes = $this->response->original->getData()['disponibilites'] ;
    	$this->assertInstanceOf('Illuminate\Database\Eloquent\Collection',$disponibilites );
    	$this->assertEquals(count($lesDisponibilites), $personnes->count());
    }*/
    
    /**
     * @test
    */
    /*public function le_ctrl_retourne_errors_avec_une_disponibilite_sans_titre()
    {
    	$this->call('POST', '/disponibilites');
    	$this->assertSessionHasErrors(['title']);
    }*/
    
    /**
     * @test
     */
    /*public function le_ctrl_retourne_errors_avec_une_disponibilite_sans_benevole_id
    {
    	$this->call('POST', '/disponibilites');
    	$this->assertSessionHasErrors(['benevole_id']);
    }*/
    
    /**
     * @test
     */
    /*public function le_ctrl_retourne_errors_avec_une_disponibilite_sans_date_de_debut()
    {
    	$this->call('POST', '/disponibilites');
    	$this->assertSessionHasErrors(['start']);
    }*/
    
    /**
     * @test
     */
    /*public function le_ctrl_retourne_errors_avec_une_disponibilite_sans_date_de_fin()
    {
    	$this->call('POST', '/disponibilites');
    	$this->assertSessionHasErrors(['end']);
    }*/
    
    /**
     * @test
     */
    /*public function le_ctrl_retourne_errors_avec_une_disponibilite_sans_isAllDay()
     {
     $this->call('POST', '/disponibilites');
     $this->assertSessionHasErrors(['isAllDay']);
     }*/

    /**
     * @test
    */
    public function le_ctrl_permet_la_creation_d_une_disponibilite_valide()
    {
    	$disponibilite_valide = factory(App\Models\Disponibilite::class)->make();
    	$input = ['title'=>$disponibilite_valide->title, 
    			  'benevole_id'=>$disponibilite_valide->benevole_id,
    			  'isAllDay'=>$disponibilite_valide->isAllDay,
    			  'start'=>$disponibilite_valide->start,
    			  'end'=>$disponibilite_valide->end,
    	];
    	$this->call('POST', '/disponibilites', $input);
    	$this->assertSessionMissing(['errors']);
    }
    
    /**
     * @test
    */
    /*public function le_ctrl_permet_la_sauvegarde_d_une_disponibilite_valide()
    {
    	$disponibilite_valide = factory(App\Models\Disponibilite::class)->make();
    	$input = ['title'=>$disponibilite_valide->title,
    			  'benevole_id'=>$disponibilite_valide->benevole_id,
    			  'isAllDay'=>$disponibilite_valide->isAllDay,
    			  'start'=>$disponibilite_valide->start,
    			  'end'=>$disponibilite_valide->end
    	];
    	$this->call('POST', '/disponibilites', $input);
    	$this->assertSessionMissing(['errors']);
    	$this->seeInDatabase('disponibilites', ['title'=>$disponibilite_valide->title,
    			                                'benevole_id'=>$disponibilite_valide->benevole_id,
    			                                'isAllDay'=>$disponibilite_valide->isAllDay,
    			                                'start'=>$disponibilite_valide->start,
    			                                'end'=>$disponibilite_valide->end
    	]);	 
    }*/
}
