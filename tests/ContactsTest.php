<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ContactsTest extends TestCase
{

	use DatabaseTransactions;

	/**
	 * @test
	 */
	public function la_table_contact_existe_dans_la_BD() {
		$this->assertTrue(Schema::hasTable('contacts'), "La table 'contacts' n'existe pas!");
	}

    /**
     * @test
     * @expectedException PDOException
     * @dataProvider nullProvider
     */
    public function lance_exception_si_un_champ_n_est_pas_remplit_dans_la_BD($prenom, $nom, $telephone, $role)
    {
        $user = factory(App\User::class)->create();
        $this->actingAs($user);

        $organisme = factory(App\Models\Organisme::class)->create();
        $contact = factory(App\Models\Contact::class)->create(
                ['prenom' => $prenom,
                    'nom' => $nom,
                    'telephone' => $telephone,
                    'role' => $role
                    ]);
    }

    /**
     * @test
     * @dataProvider nullProvider
     */
    public function assure_que_le_controlleur_retourne_des_erreurs_si_un_champ_n_est_pas_remplit($prenom, $nom, $telephone, $role)
    {
        $user = factory(App\User::class)->create();
        $this->actingAs($user);

        $organisme = factory(App\Models\Organisme::class)->create();
        $contact = factory(App\Models\Contact::class)->make();
        $input = ['prenom' => $prenom,
                    'nom' => $nom,
                    'telephone' => $telephone,
                    'role' => $role];
        $this->call('POST', 'organismes/' . $organisme->id . '/contacts', $input);
        $this->assertSessionHas(['errors']);
        $this->dontSeeInDatabase('contacts', ['prenom' => $contact->prenom,
                                            'nom' => $contact->nom,
                                            'telephone' => $contact->telephone,
                                            'role' => $contact->role
                                         ]);

    }

    public function nullProvider()
    {
        return [
                'contactPrenom' => [null, 'Lachance', '8191234567', 'Directeur'],
                'contactNom' => ['Georges', null, '8191234567', 'Directeur'],
                'contactTelephone' => ['Georges', 'Lachance', null, 'Directeur'],
                'contactRole' => ['Georges', 'Lachance', '8191234567', null]
                ];
    }

    /**
     * @test
     *
     */
    public function la_modification_d_un_contact_fonctionne_dans_la_BD()
    {
    	$user = factory(App\User::class)->create();
    	$this->actingAs($user);

    	$organisme = factory(App\Models\Organisme::class)->create();
        $contact = factory(App\Models\Contact::class)->create();
        $input = ['prenom' => $contact->prenom . '1',
        			'nom' => $contact->nom,
        			'telephone' => $contact->telephone,
        			'role' => $contact->role,
        			'organisme_id' => $organisme->id];

        $this->call('PUT', 'organismes/' . $organisme->id . '/contacts' . '/' . $contact->id, $input);
        $this->assertSessionMissing(['errors']);
    	$this->seeInDatabase('contacts', [	
    							'prenom' => $contact->prenom . '1'
							]);
        $this->dontSeeInDatabase('contacts', [  
                                'prenom' => $contact->prenom
                            ]);
    }

    /**
     * @test
     *
     */
    public function la_creation_d_un_contact_fonctionne_dans_la_BD()
    {
    	$user = factory(App\User::class)->create();
    	$this->actingAs($user);

    	$organisme = factory(App\Models\Organisme::class)->create();
        $contact = factory(App\Models\Contact::class)->make();
        $input = ['prenom' => $contact->prenom,
        			'nom' => $contact->nom,
        			'telephone' => $contact->telephone,
        			'role' => $contact->role,
        			'organisme_id' => $organisme->id
        		 ];
        $this->call('POST', 'organismes/' . $organisme->id . '/contacts', $input);
        $this->assertSessionMissing(['errors']);
        $this->seeInDatabase('contacts', ['prenom' => $contact->prenom,
        									'nom' => $contact->nom,
    									   	'telephone' => $contact->telephone,
    									   	'role' => $contact->role
    									 ]);
    }

    /**
     * @test
     *
     */
    public function la_suppression_d_un_contact_fonctionne_dans_la_BD()
    {
    	$user = factory(App\User::class)->create();
    	$this->actingAs($user);

    	$organisme = factory(App\Models\Organisme::class)->create();
        $contact = factory(App\Models\Contact::class)->create();
        
        $this->call('DELETE', 'organismes/' . $organisme->id . '/contacts' . '/' . $contact->id);
        $this->assertSessionMissing(['errors']);
    	$this->dontSeeInDatabase('contacts', ['prenom' => $contact->prenom,
                                                'nom' => $contact->nom,
                                                'telephone' => $contact->telephone,
                                                'role' => $contact->role]);
    }
}
