<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class delegueTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->assertTrue(true);
    }

    public function test_affiche_le_boutton_pour_ajouter_telephone_et_le_bouton_courriel()
    {
        $user = factory(App\User::class)->create();
        $this->actingAs($user);
        $this->visit('/delegues/create');
        $this->see('test1');
        $this->see('test2');
    }



}
