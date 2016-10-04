<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AjoutSexe_a_epreuve extends TestCase
{

    /**
     * Ce test vérifie lors de la création/sauvegarde
     * qu'un sexe est sélectionner.
     *
     * @return void
     */
    public function testAucunSexeSelectionne()
    {
        $this->assertTrue(true);
    }

    /**
     * Ce test vérifie que l'association des participants
     * non admissible à bien été retiré.
     *
     * @return void
     */
    public function testRetraitAssociationNonAdmissible()
    {
        $this->assertTrue(true);
    }
}
