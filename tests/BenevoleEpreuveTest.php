<?php
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Models\Benevole;
use App\Models\Epreuve;
class BenevoleEpreuveTest extends TestCase
{
	use DatabaseTransactions;
	
    /**
     * @test 
     * 
     * Sauvegarde de la liaisons entre un bénévole et une épreuve
     */
    public function sauvegarde_d_une_liaison_entre_benevole_et_epreuve()
    {
    	$benevole = factory(App\Models\Benevole::class)->create();
    	$epreuve = factory(App\Models\Epreuve::class)->create();
    	
    	$this->seeInDatabase('benevole_epreuve', [
    			'benevole_id'=>$benevole->id,
    			'epreuve_id'=>$epreuve->id
    	]);
    	
    }
    
}