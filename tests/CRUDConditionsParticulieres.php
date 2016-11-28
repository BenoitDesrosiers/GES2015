<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

/**
 * Class CRUDConditionsParticulieres
 *
 * Classe de tests unitaires pour le CRUD des
 * conditions particulières.
 *
 * @author Res260
 * @created_at 161122
 * @modified_at 161126
 */
class CRUDConditionsParticulieres extends TestCase
{
	/**
	 * Débute une transaction pour les tests.
	 * DOIT ÊTRE LE PREMIER TEST.
	 */
	public function testDebut() {
		DB::beginTransaction();
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
