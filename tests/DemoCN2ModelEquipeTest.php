<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Models\Equipe;


class DemoCN2ModelEquipeTest extends TestCase
{
    /**
     * Tests du modèle Equipe.
     *
     * @return void
     */
	
	
	/*
	 * -vérifier que le sports est bien associé à l'équipe dans la bd. 
	 * -ajouter l'ajout de participants dans l'équipe
	 * -ajouter le delete de participants dans l'équipe
	 * -ajouter la validation pour que les participants soient inscrits au meme sport que l'équipe
	 * 
	 */
	/** @test */
	public function la_creation_d_une_equipe_fonctionne()
	{
		$equipe1 = factory(App\Models\Equipe::class)->create(); 
		 
		$this->seeInDatabase('participants', ['id'=>$equipe1->id]); //oui, les équipes sont dans participants...
		
	}
		
	/** @test */
	public function la_creation_d_une_equipe_valide_les_champs()
	{
		
		$equipe_a_ne_pas_creer = factory(App\Models\Equipe::class)->create(['nom'=>null]); //nom is required
		$this->dontseeInDatabase('participants', ['id'=>$equipe_a_ne_pas_creer->id]); 
		
		$equipe_a_ne_pas_creer = factory(App\Models\Equipe::class)->create(['numero'=>null]); 
		$this->dontseeInDatabase('participants', ['id'=>$equipe_a_ne_pas_creer->id]); 
		
		$equipe_a_ne_pas_creer = factory(App\Models\Equipe::class)->create(['region_id'=>null]); 
		$this->dontseeInDatabase('participants', ['id'=>$equipe_a_ne_pas_creer->id]); 
		
		//Les autres champs obligatoires devraient avoir été testés par participants. 
		
		
		
    }
    
    /** @test */
    public function region_id_doit_exister()
    {
    	$this->setExpectedException('PDOException');
    	$equipe_a_ne_pas_creer = factory(App\Models\Equipe::class)->create(['region_id'=>100000000]);
    }
    
    /** @test */
    public function 
    
}
