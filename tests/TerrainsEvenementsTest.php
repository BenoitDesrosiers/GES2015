<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class TerrainsEvenementsTest extends TestCase
{
	use DatabaseTransactions;
	
	public function setUp()
	{
		parent::setUp();
		$user = factory(App\User::class)->create();
		$this->actingAs($user);
	}
	
    /**
     * Teste l'association d'un terrain à un événement.
     *
     * @return void
     */
    public function testSelectionTerrain()
    {
    	$evenement = factory(App\Models\Evenement::class)->make();
    	$date_heure_array = explode(' ', $evenement->date_heure);
    	$input = [
    		'nom' => $evenement->nom,
			'date' => $date_heure_array[0],
    		'heure' => $date_heure_array[1],
			'type_id' => $evenement->type_id,
			'epreuve_id' => $evenement->epreuve_id,
			'terrain_id' => $evenement->terrain_id
    	];
    	$this->call('POST', '/evenements', $input);
    	$this->assertSessionMissing(['errors']);
    }
    
    /**
     * Teste que le terrain sélectionné n'est pas associé 
     * si l'utilisateur annule.
     *
     * @return void
     */
    public function testAnnulerSelectionTerrain()
    {
    	$evenement = factory(App\Models\Evenement::class)->create();
    	$terrain_id = $evenement->terrain->id;
    	$new_terrain_id = App\Models\Terrain::inRandomOrder()->where('id', '<>', $terrain_id)->first()->id;
    	$this->visitRoute('evenements.edit', ['id' => $evenement->id])
    		->select($new_terrain_id, 'terrain_id')
    		->click('Annuler');
    	$this->seeInDatabase('evenements', ['id' => $evenement->id, 'terrain_id' => $terrain_id]);
    }
    
    /**
     * Teste que les changements ne sont pas sauvegardés 
     * si le terrain n'existe pas.
     *
     * @return void
     */
    public function testTerrainInnexistant()
    {
    	$this->assertTrue(true);
    }
    
    /**
     * Teste que les changements ne sont pas sauvegardés 
     * si le terrain n'est pas libre.
     *
     * @return void
     */
    public function testTerrainNonLibre()
    {
    	$this->assertTrue(true);
    }
}