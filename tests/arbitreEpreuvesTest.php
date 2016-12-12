<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class arbitreEpreuvesTest extends TestCase
{
	use DatabaseTransactions;
	
    /**
     * On vérifie que l'entrée est bien sauvegardée dans la BD.
     *
     * @return void
     */
    public function testSauvegarde()
    {
    	$user = factory(App\User::class)->create();
    	$this->actingAs($user);
    	
    	$arbitre = factory(App\Models\Arbitre::class)->create();
    	$epreuve = factory(App\Models\Epreuve::class)->create();
    	$input = $arbitre->toArray();
    	
    	$input['epreuves'] = [$epreuve->id.""];
    	$input['annee_naissance'] = "1999";
    	$input['mois_naissance'] = "10";
    	$input['jour_naissance'] = "15";
    	
    	$this->call('PUT', 'arbitres/' . $arbitre->id, $input);
    	$this->assertSessionMissing(['errors']);
    	$this->seeInDatabase('arbitre_epreuve', ['epreuve_id' => $epreuve->id,
    												'arbitre_id' => $arbitre->id
    			
    	]);
    }
    
    
    /**
     * On vérifie que l'association arbitre-épreuves est enlevée de la BD correctement
     * 
     * @return void
     */
    public function testSauvegardeDeselection()
    {
    	$user = factory(App\User::class)->create();
    	$this->actingAs($user);
    	
    	// On associe un arbitre à une épreuve
    	$arbitre = factory(App\Models\Arbitre::class)->create();
    	$epreuve = factory(App\Models\Epreuve::class)->create();
    	
   		$input = $arbitre->toArray();
    	 
    	$input['epreuves'] = [$epreuve->id.""];
    	$input['annee_naissance'] = "1999";
    	$input['mois_naissance'] = "10";
    	$input['jour_naissance'] = "15";
    	 
    	$this->call('PUT', 'arbitres/' . $arbitre->id, $input);
    	
    	// On brise cette association en n'envoyant aucune épreuve au controlleur
    	$input['epreuves'] = [];
    	$this->call('PUT', 'arbitres/' . $arbitre->id, $input);
    	
    	$this->assertSessionMissing(['errors']);
    	$this->dontSeeInDatabase('arbitre_epreuve', ['epreuve_id' => $epreuve->id,
    			'arbitre_id' => $arbitre->id]);
    }
    
    /**
     * On vérifie que l'association arbitre-épreuves est enlevée de la BD correctement
     * lorsque l'arbitre est supprimé
     *
     * @return void
     */
    public function testSiArbitreSupprime()
    {
    	$user = factory(App\User::class)->create();
    	$this->actingAs($user);
    	 
    	// On associe un arbitre à une épreuve
    	$arbitre = factory(App\Models\Arbitre::class)->create();
    	$epreuve = factory(App\Models\Epreuve::class)->create();
    	 
    	$input = $arbitre->toArray();
    
    	$input['epreuves'] = [$epreuve->id.""];
    	$input['annee_naissance'] = "1999";
    	$input['mois_naissance'] = "10";
    	$input['jour_naissance'] = "15";
    
    	$this->call('PUT', 'arbitres/' . $arbitre->id, $input);
    	
    	// On brise cette association en supprimant l'arbitre
    	$arbitre->delete();
    	    	   	 
    	$this->assertSessionMissing(['errors']);
    	$this->dontSeeInDatabase('arbitre_epreuve', ['epreuve_id' => $epreuve->id,
    			'arbitre_id' => $arbitre->id]);
    }
    
    /**
     * On vérifie que l'association arbitre-épreuves est enlevée de la BD correctement
     * lorsque l'épreuve est supprimée
     *
     * @return void
     */
    public function testSiEpreuveSupprimee()
    {
    	$user = factory(App\User::class)->create();
    	$this->actingAs($user);
    
    	// On associe un arbitre à une épreuve
    	$arbitre = factory(App\Models\Arbitre::class)->create();
    	$epreuve = factory(App\Models\Epreuve::class)->create();
    
    	$input = $arbitre->toArray();
    
    	$input['epreuves'] = [$epreuve->id.""];
    	$input['annee_naissance'] = "1999";
    	$input['mois_naissance'] = "10";
    	$input['jour_naissance'] = "15";
    
    	$this->call('PUT', 'arbitres/' . $arbitre->id, $input);
    	
    	// On brise cette association en supprimant l'épreuve
    	$epreuve->delete();
    	 
    	$this->assertSessionMissing(['errors']);
    	$this->dontSeeInDatabase('arbitre_epreuve', ['epreuve_id' => $epreuve->id,
    			'arbitre_id' => $arbitre->id]);
    }
    
    
}
