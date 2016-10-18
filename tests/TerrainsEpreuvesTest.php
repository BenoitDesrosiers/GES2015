<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App;

class TerrainsEpreuvesTest extends TestCase
{
    /**
     * Teste la création d'une épreuve.
     *
     * @return void
     */
    public function testCreationEpreuve()
    {
        $epreuve = factory(App\Models\Epreuve::class)
        	->make(['nom' => 'Quintuple transgenre']);
    }
    
    /**
     * Teste la création d'un terrain.
     *
     * @return void
     */
    public function testCreationTerrain()
    {
    	
    }
}
