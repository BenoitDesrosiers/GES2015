<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class associationTest extends TestCase
{
	
	use DatabaseTransactions;
	
    /** @test */
    public function test_table_association()
    {
        $this->assertTrue(Schema::hasTable('Associations'), "La table 'associations' n'existe pas!");
    }
    
    /** @test */
    public function creation_d_une_association()
    {
    	$user = factory(App\User::class)->create();
    	$this->actingAs($user);
    	
    	$association = factory(App\Models\Association::class)->make();
    	$input = ['nom'=>$association->nom,
    			'abreviation'=>$association->abreviation,
    			'description'=>$association->description];
    	$this->call('POST', '/associations/', $input);
    	$this->assertSessionMissing(['errors']);
    }
    
    /** @test */
    public function sauvegarder_une_association()
    {
    	$user = factory(App\User::class)->create();
    	$this->actingAs($user);
    	
    	 $association = factory(App\Models\Association::class)->make();
    	 $input = ['nom'=>$association->nom,
    	 		   'abreviation'=>$association->abreviation,
    	 		   'description'=>$association->description];
    	 $this->call('POST', '/associations', $input);
    	 $this->assertSessionMissing(['errors']);
    	 $this->seeInDatabase('associations', ['nom'=>$association->nom,
    	 									   'abreviation'=>$association->abreviation,
    	 									   'description'=>$association->description]);
    }
    
    /** @test */
    public function modification_d_une_association()
    {
    	$user = factory(App\User::class)->create();
    	$this->actingAs($user);
    	
    	$association = factory(App\Models\Association::class)->create();
    	$input = ['nom'=>$association->nom . '1',
    			'abreviation'=>$association->abreviation,
    			'description'=>$association->description];
    	$this->call('PUT', '/associations/' . $association->id, $input);
    	$this->assertSessionMissing(['errors']);
    	$this->seeInDatabase('associations', ['nom'=>$association->nom . '1']);
    }
    
    /** @test */
    public function tempter_d_ajouter_deux_noms_pareil_dans_la_BD()
    {
    	$user = factory(App\User::class)->create();
    	$this->actingAs($user);
    	 
    	$association = factory(App\Models\Association::class)->create();
    	$input = ['nom'=>'allo toi',
    			'abreviation'=>'AT',
    			'description'=>'Gens qui se disent le bonjour'];
    	$this->call('POST', '/associations/', $input);
    	$input = [
    			'nom'=>'allo toi',
    			'abreviation'=>'AT1',
    			'description'=>'Gens qui se disent le bonjour'];
    	$this->call('POST', '/associations/', $input);
    	$this->assertSessionHas(['errors']);
    	$this->seeInDatabase('associations', ['nom'=>$association->nom,
    			'abreviation'=>$association->abreviation,
    			'description'=>$association->description]);
    }
    
    /** @test */
    public function tempter_d_ajouter_deux_abreviations_pareilles_dans_la_BD()
    {
    	$user = factory(App\User::class)->create();
    	$this->actingAs($user);
    	
    	$association = factory(App\Models\Association::class)->create();
    	$input = ['nom'=>'allo toi',
    			'abreviation'=>'AT',
    			'description'=>'Gens qui se disent le bonjour'];
    	$this->call('POST', '/associations/', $input);
    	$input = [
    			'nom'=>'allo toi 1',
    			'abreviation'=>'AT',
    			'description'=>'Gens qui se disent le bonjour'];
    	$this->call('POST', '/associations/', $input);
    	$this->assertSessionHas(['errors']);
    	$this->seeInDatabase('associations', ['nom'=>$association->nom,
								    			'abreviation'=>$association->abreviation,
								    			'description'=>$association->description]);
    }
    
    /** @test */
    public function une_association_est_supprime_de_la_bd()
    {
    	$user = factory(App\User::class)->create();
    	$this->actingAs($user);
    	
    	 $association = factory(App\Models\Association::class)->create();
    	 $this->call('DELETE', '/associations/' . $association->id);
    	 $this->assertSessionMissing(['errors']);
    	 $this->dontSeeInDatabase('associations', ['id' => $association->id]);
    }
    
    /** @test */
    public function tester_l_entrer_un_null_au_nom_dans_la_BD()
    {
    	$user = factory(App\User::class)->create();
    	$this->actingAs($user);
    	
    	$association = factory(App\Models\Association::class)->create();
    	$input = ['nom'=>null,
    			'abreviation'=>'AT',
    			'description'=>'Gens qui se disent le bonjour'];
    	$this->call('POST', '/associations/', $input);
    	$this->assertSessionHas(['errors']);
    	$this->seeInDatabase('associations', ['nom'=>$association->nom,
    											'abreviation'=>$association->abreviation,
    											'description'=>$association->description]);
    }
    
    /** @test */
    public function tester_l_entrer_un_null_dans_l_abreviation_dans_la_BD()
    {
    	$user = factory(App\User::class)->create();
    	$this->actingAs($user);
    	 
    	$association = factory(App\Models\Association::class)->create();
    	$input = ['nom'=>'Allo Toi',
    			'abreviation'=>null,
    			'description'=>'Gens qui se disent le bonjour'];
    	$this->call('POST', '/associations/', $input);
    	$this->assertSessionHas(['errors']);
    	$this->seeInDatabase('associations', ['nom'=>$association->nom,
    			'abreviation'=>$association->abreviation,
    			'description'=>$association->description]);
    }
    
    /** @test */
    public function tester_l_entrer_un_null_dans_la_description_dans_la_BD()
    {
    	$user = factory(App\User::class)->create();
    	$this->actingAs($user);
    	 
    	$association = factory(App\Models\Association::class)->create();
    	$input = ['nom'=>'Allo Toi',
    			'abreviation'=>'AT',
    			'description'=>null];
    	$this->call('POST', '/associations/', $input);
    	$this->assertSessionMissing(['errors']);
    	$this->seeInDatabase('associations', ['nom'=>$association->nom,
    			'abreviation'=>$association->abreviation,
    			'description'=>$association->description]);
    }
}
