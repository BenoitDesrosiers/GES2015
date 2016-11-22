<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

/**
 * Class CreerParticipantsCSVTest
 * Classe de jeu de tests pour la création de participants par CSV
 * @author ZeLarpMaster
 */
class CreerParticipantsCSVTest extends TestCase {
	use DatabaseTransactions;

	/**
	 * Crée un utilisateur et se connecte en tant que cet utilisateur
	 */
	private function loginAsUser() {
		$user = factory(App\User::class)->create();
		$this->actingAs($user);
	}

	/**
	 * Test qui vérifie la navigation
	 * de la page participants à la page de création par csv
	 *
	 * @return void
	 */
    public function testNavigationParticipantsVersCreationCSV() {
		$this->loginAsUser();

		$this->visit("/participants")
			->click("Créer des participants")
			->seePageIs("/participants/createBatch");
	}

	/**
	 * Test qui vérifie la présence d'une section d'aide
	 *
	 * @return void
	 */
	public function testPresenceSectionAideCreationCSV() {
		$this->loginAsUser();

		$this->visit("/participants/createBatch")
			->see("aide");
	}

	/**
	 * Test qui vérifie la présence d'un bouton d'envoi de fichier
	 *
	 * @return void
	 */
	public function testPresenceBoutonEnvoiFichierCSV() {
		$this->loginAsUser();

		$this->visit("/participants/createBatch")
			->see("Envoyer un fichier CSV");
	}
}
