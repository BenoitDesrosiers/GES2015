<?php

/**
 * Class GonzoTest créée par Émilio G! à partir du 161018.
 */
class GonzoTest extends TestCase
{

	/**
	 * Crée un utilisateur test pour les tests.
	 */
	public function creerUsagerMythique() {
		$user = factory(App\User::class)->create();
		$this->actingAs($user);
	}

	/**
	 * Teste que la table 'telephones' existe dans la base de données.
	 */
	public function testTableTelephonesCreee() {
		$this->assertTrue(Schema::hasTable('Telephones'), "La table 'telephones' n'existe pas!");
	}

	/**
	 * Teste que la table 'participant' n'a plus le champ 'telephone'.
	 *
	 * @expectedException PDOException
	 */
	public function testTableParticipantPasDeChampTelephone() {
		DB::select('SELECT p.telephone FROM participants p');
	}

	/**
	 * Teste que la table 'Adresses' existe dans la base de données.
	 */
	public function testTableAdressesCreee() {
		$this->assertTrue(Schema::hasTable('Adresses'), "La table 'Adresses' n'existe pas!");
	}

	/**
	 * Teste que la table 'participant' n'a plus le champ 'adresse'.
	 *
	 * @expectedException PDOException
	 */
	public function testTableParticipantPasDeChampAdresse() {
		DB::select('SELECT p.adresse FROM participants p');
	}
}
