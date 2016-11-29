<?php

use App\Models\User;

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
	/**
	 * Débute une transaction pour les tests et
	 * authentifie un utilisateur.
	 * DOIT ÊTRE LE PREMIER TEST.
	 */
	public function testDebut() {
		DB::beginTransaction();
		$this->assertTrue(true);
		$this->actingAs(User::first());
	}

	public function testAjouterConditionParticuliere() {
		$this->assertTrue(true);
	}

	/**
	 * Fait un rollback pour les tests.
	 * DOIT ÊTRE LE DERNIER TEST.
	 */
	public function testFin() {
		DB::rollback();
		$this->assertTrue(true);
	}
}
