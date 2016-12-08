<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class TestAssociationsBenevolesTaches extends TestCase
{
    use DatabaseTransactions;
	
    /** @test */
    public function test_des_tables()
    {
        $this->assertTrue(Schema::hasTable('benevoles'), "La table 'benevoles' n'existe pas!");
        $this->assertTrue(Schema::hasTable('taches'), "La table 'taches' n'existe pas!");
        $this->assertTrue(Schema::hasTable('benevole_taches'), "La table d'associations 'benevole_taches' n'existe pas!");
    }

    /** @test */
	//test si on supprime le bénévole si sa supprime la relation entre la tâche et le bénévole.
 
    public function un_benevole_est_supprime_de_la_bd()
    {
    	$user = factory(App\User::class)->create();
    	$this->actingAs($user);
    	$benevole = factory(App\Models\Benevole::class)->create();
    	$this->call('DELETE', '/benevoles/' , $benevole->id);
    	$this->assertSessionMissing(['errors']);
    	$this->dontSeeInDatabase('benevoles', ['id' => $benevole->id]);
    }
}
