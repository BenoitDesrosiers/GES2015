<?php

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class feature55Test extends TestCase
{

    /**
     * La route vers l'index des cafétérias existe.
     * @test
     * @return void
     */
    public function la_route_vers_l_index_des_cafeterias_existe()
    {
    	$this->connexion();
        $this->visit('/cafeterias')
        	->see('Liste des cafétérias');
    }

    /**
     * Si on appuie sur cafétéria dans le menu, on arrive à l'index des cafétérias.
     * @test
     * @return void
     */
    public function le_bouton_de_cafeteria_existe_dans_le_menu()
    {
    	$this->connexion();
    	$this->visit('/')
    		->press('cafeterias')
    		->assertRedirectTo('/');
    }

    private function connexion()
    {
    	$user = User::where('email', 'usager@chose.com')->firstOrFail();
    	$this->actingAs($user);
    }
}
