<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use DatabaseTransactions;

class BenevolesSportsTest extends TestCase
{
    /** @test */
    public function la_creation_d_un_benevole_sport_fonctionne()
    {
    	$benevolesSports= factory(App\Models\BenevolesSports::class)
    	->make(['benevole_id'=>'1', 'sport_id'=>'2']);
        $this->assertEquals('1', $voiture->benevole_id);
        $this->assertEquals('2', $voiture->sport_id);
    }
    
    /** @test */
    public function la_creation_d_un_benevole_sport_dans_la_BD()
    {
    	$benevolesSports = factory(App\Models\BenevolesSports::class)
    	->create();
    	$this->seeInDatabase('benevoles_sports', [
    			'benevole_id'=>$benevolesSports->benevole_id,
    			'sport_id'=>$benevolesSports->sport_id,
    	]);
    }
}