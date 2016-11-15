<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\Models\Organisme;

class OrganismeTests extends TestCase
{
	//use DatabaseTransactions;


    /** @test */
    public function la_creation_d_un_organisme_fonctionne()
    {
    	$organisme = factory(App\Models\Organisme::class)
    		->make(['nomOrganisme'=>'Urgence', 'telephone'=>'911', 'description'=>'Les services urgence']);
    	$this->assertEquals('Urgence', $organisme->nomOrganisme);
    	$this->assertEquals('911', $organisme->telephone);
    	$this->assertEquals('Les services urgence', $organisme->description);
    }

    
    /** @test */
    public function la_creation_d_un_organisme_dans_la_BD_fonctionne()
    {
    	$organisme = factory(App\Models\Organisme::class)->create();
    	$this->seeInDatabase('organisme', ['id'=>$organisme->id,
    											'nomOrganisme'=>$organisme->nomOrganisme,
    											'telephone'=>$organisme->telephone,
    											'description'=>$organisme->description
    									]);
    }

    /** @test */
    public function la_vue_des_organismes_s_affiche()
    {
        $this->visit('/organismes');

    }

    /** @test */
    public function la_vue_de_creation_des_organismes_s_affiche()
    {
        $this->visit('/organismes/create');
    }


    /**  */
    public function un_organisme_est_cree_avec_le_meme_nom_meme_si_une_entree_avec_le_meme_nom_existe_dans_la_BD()
    {
        $user = factory(App\User::class)->create();
        $this->actingAs($user);
        $this->visit('/organismes/create');

        $organisme = factory(App\Models\Organisme::class)
            ->create(['nomOrganisme'=>'Urgence',
                        'telephone'=>'911',
                        'description'=>'Les services urgence'
                    ]);

        if ($organisme->exists()){
            $organisme->create(['nomOrganisme'=>'Urgence',
                            'telephone'=>'432432432',
                            'description'=>'Lorem ipsum'
                        ]);
        }

        $nbOrganismes = $organisme->where('nomOrganisme', 'Urgence')->count();

        $this->assertEquals($nbOrganismes, 2); // ??????? À revoir!
    }

    /** @test */
    public function un_organisme_avec_le_meme_nom_que_celui_cree_est_remplace()
    {
        $organisme = factory(App\Models\Organisme::class)
            ->create(['nomOrganisme'=>'Urgence',
                        'telephone'=>'911',
                        'description'=>'Les services urgence'
                    ]);

        if ($organisme->exists()){

            $organisme->where('nomOrganisme', 'Urgence')
            ->update(['telephone' => '432432432', 'description' => 'Lorem ipsum']);

            $this->dontSeeInDatabase('organisme', ['nomOrganisme' => 'Urgence',
                                                    'telephone'=>'911',
                                                    'description'=>'Les services urgence'
                                                    ]);

            $this->seeInDatabase('organisme', ['nomOrganisme' => 'Urgence',
                                                        'telephone' => '432432432',
                                                        'description' => 'Lorem ipsum'
                                                    ]);
        }
    }

    /** @test 
    *   @expectedException PDOException
    *   @dataProvider nullProvider
    **/
    public function lance_exception_si_le_nom_de_l_organisme_est_vide($nomOrganisme, $telephone, $description)
    {

        $organisme = factory(App\Models\Organisme::class)
        ->create(['nomOrganisme'=> $nomOrganisme,
                            'telephone'=> $telephone,
                            'description'=> $description
                        ]);
    }


    public function nullProvider()
    {
        return [
                'organisme1' => [null, '911', 'Une brève description']
                ];
    }

    /** @test */
    public function un_organisme_est_cree_meme_si_le_telephone_est_nul()
    {
        $organisme = factory(App\Models\Organisme::class)
        ->create(['nomOrganisme'=> 'Services',
                            'telephone'=> null,
                            'description'=> 'Une petite description.'
                        ]);
        $this->seeInDatabase('organisme', ['nomOrganisme' => 'Services',
                                            'telephone' => null,
                                            'description' => 'Une petite description.'
                                        ]);
    }

    /** @test */
    public function un_organisme_est_cree_meme_si_la_description_est_nulle()
    {
        $organisme = factory(App\Models\Organisme::class)
        ->create(['nomOrganisme'=> 'Services',
                            'telephone'=> '123-456-7890',
                            'description'=> null
                        ]);
        $this->seeInDatabase('organisme', ['nomOrganisme' => 'Services',
                                            'telephone' => '123-456-7890',
                                            'description' => null
                                        ]);
        $this->visit('/organismes');
        if ($organisme->description === NULL){
            $this->see('Aucune description');
        }
    }

    /** @test */
    public function un_organisme_est_supprime_de_la_BD()
    {
        $organisme = factory(App\Models\Organisme::class)
            ->create([  'id' => 999999,
                        'nomOrganisme'=>'testNomOrganisme',
                        'telephone'=>'testTelephone',
                        'description'=>'testDescription'
                    ]);
        $organisme->where('id', 999999)->delete();
        $this->dontSeeInDatabase('organisme', ['id' => 999999]);
    }

    /** @test */
    public function on_peut_creer_un_organisme_avec_l_interface_et_le_validateur_de_Laravel()
    {
        $this->visit('/organismes/create');
        $this->type('NomTest', 'nomOrganisme');
        $this->type('819-111-2345', 'telephone');
        $this->type('Une description de test pour un organisme', 'description');
        $this->press('Confirmer');

        $this->seeInDatabase('organisme', ['nomOrganisme' => 'NomTest']);

        $this->visit('/organismes');
        $this->see('NomTest');
    }

    /** @test */
    public function le_validateur_de_Laravel_assure_que_le_nom_de_l_organisme_est_obligatoire()
    {
        $this->visit('/organismes/create');
        
        $this->type('', 'nomOrganisme');
        $this->type('819-222-6789', 'telephone');
        $this->type('Une description de test pour un organisme sans nom', 'description');
        $this->press('Confirmer');

        $this->dontSeeInDatabase('organisme', ['nomOrganisme' => '']);
    }
}