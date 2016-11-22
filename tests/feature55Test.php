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

    
    
    private function connexion()
    {
    	$user = User::where('email', 'usager@chose.com')->firstOrFail();
    	$this->actingAs($user);
    }
}
