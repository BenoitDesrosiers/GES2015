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
    	$benevole = new Benevole;
    	$benevole->nom = "Nom Valide";
    	$benevole->prenom = "Prenom Valide";
    	$benevole->adresse = "Adresse Valide";
    	$benevole->numTel = "123-123-1234";
    	$benevole->accreditation = "Accreditation Valide";
    	$benevole->naissance = '2000-12-25';
    	$this->assertTrue($benevole->save());
    	$epreuve = new Epreuve;
    	$epreuve->nom = "Nom Valide";
    	$epreuve->genre = "mixte";  
    	$this->assertTrue($epreuve->save());
    	
    	$this->seeInDatabase('benevole_epreuve', [
    			'benevole_id'=>$benevole->id,
    			'epreuve_id'=>$epreuve->id
    	]);
    	
    }
    /**
     * 
     *
     * Sauvegarder les personnes dans une BD
     */
    public function sauvegarde_d_un_bon_modele_sans_telephone()
    {
    	$personne = new Personne;
    	$personne->nom = "Nom Valide";
    	$personne->dateNaissance = '2000-12-25';
    	$this->assertTrue($personne->save());
    	$this->seeInDatabase('personnes', [
    			'id'=>$personne->id,
    			'nom'=>$personne->nom,
    			'dateNaissance'=>$personne->dateNaissance,
    			'telephone'=>$personne->telephone
    	]);
    	 
    }
}