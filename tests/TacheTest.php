<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class TacheTest extends TestCase
{

	use DatabaseTransactions;

        /** @test */
    public function la_creation_d_une_taches_fonctionne()
    {
        $tache = factory(App\Models\Taches::class)->make(['id'=> 101, 'nom'=>'Balais', 'description'=>'passer balais' ]);
		$this->assertEquals(101, $tache->id);
		$this->assertEquals('Balais', $tache->nom);
		$this->assertEquals('passer balais', $tache->description);
    }


    /** @test */
	public function la_creation_d_une_tache_fonctionne_dans_la_BD()
	    {
	        $tache = factory(App\Models\Taches::class)
	        ->create();
	    }

}
