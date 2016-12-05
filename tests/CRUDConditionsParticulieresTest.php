<?php

use App\Models\ConditionParticuliere;
use Illuminate\Foundation\Testing\DatabaseTransactions;


/**
 * Class CRUDConditionsParticulieres
 *
 * Classe de tests unitaires pour le CRUD des
 * conditions particulières.
 *
 * @author Res260
 * @created_at 161122
 * @modified_at 161128
 */
class CRUDConditionsParticulieres extends TestCase
{
	use DatabaseTransactions;

	/**
	 * Teste que l'ajout d'une condition particulière fonctionne avec description.
	 */
	public function testAjouterConditionParticuliereAvecDescription() {
		$this->actingAs(factory(\App\User::class)->make()->first());
		$this->ajouterConditionParticuliere(
			factory(App\Models\ConditionParticuliere::class, 'AvecDescription')
				->make()->toArray()
		);
	}

	/**
	 * Teste que l'ajout d'une condition particulière fonctionne sans description.
	 */
	public function testAjouterConditionParticuliereSansDescription() {
		$this->actingAs(factory(\App\User::class)->make()->first());
		$this->ajouterConditionParticuliere(
			factory(App\Models\ConditionParticuliere::class, 'SansDescription')
				->make()->toArray()
		);
	}

	/**
	 * Teste qu'il est impossible d'ajouter une condition
	 * particulière qui existe déjà.
	 */
	public function testImpossibleDAjouterUneConditionParticuliereQuiExisteDeja() {
		$this->actingAs(factory(\App\User::class)->make()->first());
		$conditionAvecDescription = factory(App\Models\ConditionParticuliere::class, 'AvecDescription')
			->make()->toArray();
		$this->ajouterConditionParticuliere($conditionAvecDescription);
		$this->validerErreurLorsDeLAjout($conditionAvecDescription);

		$conditionAvecDescription['nom'] = $conditionAvecDescription['nom'] . '    ';
		$this->validerErreurLorsDeLAjout($conditionAvecDescription);
	}

	/**
	 * Teste qu'il est possible de modifier la description d'une condition
	 * particulière.
	 */
	public function testModifierDescriptionDUneConditionParticuliere() {
		$this->actingAs(factory(\App\User::class)->make()->first());
		$conditionAvecDescription = factory(App\Models\ConditionParticuliere::class, 'AvecDescription')
			->make()->toArray();
		$this->ajouterConditionParticuliere($conditionAvecDescription);
		$conditionAvecDescriptionModifiee = $conditionAvecDescription;
		$conditionAvecDescriptionModifiee['description'] = 'Une description modifiée!';
		$this->modifierConditionParticuliere($this->getDerniereConditionParticuliereId(),
											 $conditionAvecDescriptionModifiee);
	}

	/**
	 * Teste qu'il est possible de modifier le nom d'une condition particulière.
	 */
	public function testModifierNomDUneConditionParticuliere() {
		$this->actingAs(factory(\App\User::class)->make()->first());
		$conditionSansDescription = factory(App\Models\ConditionParticuliere::class, 'SansDescription')
			->make()->toArray();
		$this->ajouterConditionParticuliere($conditionSansDescription);
		$conditionSansDescriptionModifiee = $conditionSansDescription;
		$conditionSansDescriptionModifiee['nom'] = 'Un nom modifié!';
		$this->modifierConditionParticuliere($this->getDerniereConditionParticuliereId(),
											 $conditionSansDescriptionModifiee);
	}

	/**
	 * Teste qu'il est impossible de modifier le nom d'une condition particulière
	 * pour un nom qui existe déjà.
	 */
	public function testImpossibleDeModifierPourUnNomQuiExisteDeja() {
		$this->actingAs(factory(\App\User::class)->make()->first());
		$this->ajouterConditionParticuliere(['nom' => 'UN NOM QUI EXISTE']);
		$this->ajouterConditionParticuliere(
			factory(App\Models\ConditionParticuliere::class, 'AvecDescription')
				->make()->toArray()
		);
		$this->validerNonModificationConditionParticuliere(
			$this->getDerniereConditionParticuliereId(),
			['nom' => 'UN NOM QUI EXISTE']);
	}

	/**
	 * Teste que l'affichage d'une condition particulière fonctionne.
	 */
	public function testAffichageConditionParticuliere() {
		$this->actingAs(factory(\App\User::class)->make()->first());
		$condition = factory(App\Models\ConditionParticuliere::class, 'AvecDescription')
						->make()->toArray();
		$this->ajouterConditionParticuliere($condition);
		$this->visit('/conditionsParticulieres/' . $this->getDerniereConditionParticuliereId());
		$this->see($condition['nom']);
		$this->see($condition['description']);
	}

	/**
	 * Teste la suppression d'une condition particulière.
	 */
	public function testSuppressionDUneConditionParticuliere() {
		$this->actingAs(factory(\App\User::class)->make()->first());
		$condition = factory(App\Models\ConditionParticuliere::class, 'AvecDescription')
						->make()->toArray();
		$this->ajouterConditionParticuliere($condition);
		$this->call('DELETE', '/conditionsParticulieres/' . $this->getDerniereConditionParticuliereId());
		$this->assertRedirectedToAction('ConditionsParticulieresController@index');
		$this->dontSeeInDatabase('conditions_particulieres', $condition);
	}

	/**
	 * Fais le test d'ajout d'une condition particulière
	 * avec les données $data dans la BDD.
	 *
	 * @param array $data les données de la conditionParticuliere
	 */
	private function ajouterConditionParticuliere(array $data) {
		$this->visit('/conditionsParticulieres/create');
		$this->call('POST', '/conditionsParticulieres', $data);
		$this->assertSessionMissing('errors');
		$this->seeInDatabase('conditions_particulieres', $data);
		$this->assertRedirectedTo('/conditionsParticulieres/' .
			$this->getDerniereConditionParticuliereId());
	}

	/**
	 * Valide que $conditionParticuliereTest ne peut être ajouté à la BDD.
	 *
	 * @param array $conditionParticuliereTest Les données d'une condition
	 *                                         particulière test.
	 */
	private function validerErreurLorsDeLAjout(array $conditionParticuliereTest)
	{
		$compteInitial = ConditionParticuliere::get()->count();
		$this->visit('/conditionsParticulieres/create');
		$this->call('POST', '/conditionsParticulieres', $conditionParticuliereTest);
		$this->assertSessionHas('errors');
		$this->assertEquals($compteInitial, ConditionParticuliere::get()->count());
		$this->assertRedirectedToRoute('conditionsParticulieres.create');
	}


	/**
	 * Modifie une condition particulière dans la BDD et vérifie que la modification
	 * s'est bien déroulée.
	 *
	 * @param int   $conditionInitialeId L'id de la condition particulière initiale.
	 * @param array $conditionModifiee   Les valeurs de la condition particulière modifiée.
	 */
	private function modifierConditionParticuliere(int $conditionInitialeId, array $conditionModifiee)
	{
		$this->visit('/conditionsParticulieres/' . $conditionInitialeId . '/edit');
		$this->call('PUT', '/conditionsParticulieres/' . $conditionInitialeId, $conditionModifiee);
		$this->assertSessionMissing('errors');
		$this->assertRedirectedToAction('ConditionsParticulieresController@index');
		$this->seeInDatabase('conditions_particulieres', $conditionModifiee);
	}

	/**
	 * Tente de modifier la condition particulière #$id avec $modification
	 * comme informations et valide que la modification n'a pas eu lieu.
	 *
	 * @param int $conditionId L'id de la condition particulière à valider la non-modification.
	 * @param array $modification Les informations à utiliser pour la tentative de modification.
	 */
	private function validerNonModificationConditionParticuliere($conditionId, $modification)
	{
		$this->visit('/conditionsParticulieres/' . $conditionId . '/edit');
		$this->call('PUT', '/conditionsParticulieres/' . $conditionId, $modification);
		$this->assertSessionHas('errors');
		$this->assertRedirectedToAction('ConditionsParticulieresController@edit', $conditionId);
	}

	/**
	 * @return mixed
	 */
	private function getDerniereConditionParticuliereId()
	{
		return ConditionParticuliere::orderBy('id', 'desc')->first()->id;
	}
}

