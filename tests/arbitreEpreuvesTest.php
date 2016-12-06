<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class arbitreEpreuvesTest extends TestCase
{
	//use DatabaseTransactions;
	
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testSauvegarde()
    {
    	$user = factory(App\User::class)->create();
    	$this->actingAs($user);
    	
    	$arbitre = factory(App\Models\Arbitre::class)->create()->first();
    	$epreuve = factory(App\Models\Epreuve::class)->create()->first();
    	$input = $arbitre->toArray();
    	$this->call('PUT', 'arbitres/' . $arbitre->id, $input);
    	$this->assertSessionMissing(['errors']);
    	$this->seeInDatabase('arbitre_epreuve', ['epreuve_id' => $epreuve->id,
    												'arbitre_id' => $arbitre->id
    			
    	]);
    }
}
