<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Database\Eloquent\Collection;

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

     /**
     * On vérifie que l'association bénévole tâche est enlevée de la BD correctement
     */
     /** @test */
    public function test_supprimer_benevole()
    {
        $user = factory(App\User::class)->create();
        $this->actingAs($user);
        
        $tache = factory(App\Models\Taches::class)->create();
        $benevole = factory(App\Models\Benevole::class)->create();
        // associer une tâche à un bénévole
        $benevole->taches()->id = $tache->id;
        
        $this->call('DELETE', '/benevoles/' . $benevole->id);
        $this->assertSessionMissing(['errors']);
        $this->dontSeeInDatabase('benevole_taches', ['benevole_id' => $benevole->id, 'taches_id' => $tache->id]);
    
    }

    /**
     * On vérifie que l'association bénévole tâche est enlevée de la BD correctement
     */
    /** @test */
    public function test_tache_supprimee()
    {
        $user = factory(App\User::class)->create();
        $this->actingAs($user);
    
        $tache = factory(App\Models\Taches::class)->create();
        $benevole = factory(App\Models\Benevole::class)->create();
        // associer une tâche à un bénévole
        $benevole->taches()->id = $tache->id;
    
        $this->call('DELETE', '/taches/' . $tache->id);
        $this->assertSessionMissing(['errors']);
        $this->dontSeeInDatabase('benevole_taches', ['benevole_id' => $benevole->id, 'taches_id' => $tache->id]);
    }
    
   
   
}
