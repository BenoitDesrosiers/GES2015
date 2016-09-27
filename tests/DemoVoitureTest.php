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
    	$this->seeInDatabase('Voitures', ['voiture_id'=>$voiture->id]);
    }
}
