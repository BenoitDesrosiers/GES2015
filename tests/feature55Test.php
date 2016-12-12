<?php

use App\Models\Cafeteria;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class feature55Test extends TestCase
{

    use DatabaseTransactions;

    /**
     * La route vers l'index des cafétérias existe.
     * @test
     * @return void
     */
    public function la_route_vers_l_index_des_cafeterias_existe()
    {
    	$this->connexion();
        $this->visit('/cafeterias')
        	->assertResponseOk();
    }

    /**
     * La route vers la création de cafétéria existe.
     * @test
     * @return void
     */
    public function la_route_vers_la_creation_de_cafeterias_existe()
    {
        $this->connexion();
        $this->visit('/cafeterias/create')
            ->assertResponseOk();
    }

    /**
     * La route vers la modification de cafétéria existe.
     * @test
     * @return void
     */
    public function la_route_vers_la_modification_de_cafeterias_existe()
    {
        $this->connexion();
        $cafeteria = factory(Cafeteria::class)->create();
        $this->visit('cafeterias/'. $cafeteria->id . '/edit')
            ->assertResponseOk();
    }

    /**
     * La route vers le show de cafétéria existe.
     * @test
     * @return void
     */
    public function la_route_vers_le_show_de_cafeterias_existe()
    {
        $this->connexion();
        $cafeteria = factory(Cafeteria::class)->create();
        $this->visit('cafeterias/'. $cafeteria->id)
            ->assertResponseOk();
    }
    
    /**
     * Test que le controlleur peut créer une cafeteria.
     * @test
     */
    public function creation_d_une_cafeteria_fonctionne()
    {
        
        $this->connexion();
        $cafeteria = factory(App\Models\Cafeteria::class)->make();
        $responsable = factory(App\Models\Responsable::class)->make();
        $request = [
            'nom' => $cafeteria->nom,
            'adresse' => $cafeteria->adresse,
            'localisation' => $cafeteria->localisation,
            'responsable' => [
                                [
                                    'nom' => $responsable->nom,
                                    'telephone' => $responsable->telephone,
                                ],
                            ],
        ];
        
        $this->call('POST', '/cafeterias', $request);
        
        $this->seeInDatabase('cafeterias', ['nom' => $cafeteria->nom]);
        $this->seeInDatabase('responsables', ['nom' => $responsable->nom]);
    }

    /**
     * Test que le controlleur efface bien une cafeteria.
     * @test
     */
    public function la_suppression_de_cafeteria_fonctionne()
    {
        $this->connexion();
        $cafeteria = factory(App\Models\Cafeteria::class)->create();
        $this->seeInDatabase('cafeterias', ['id' => $cafeteria->id]);
        $this->call('DELETE', '/cafeterias/' . $cafeteria->id);
        $this->dontSeeInDatabase('cafeterias', ['id' => $cafeteria->id]);
    }

    /**
     * Test que le controlleur puisse modifier une cafeteria.
     * @test
     */
    public function la_modification_de_cafeteria_fonctionne()
    {
        $this->connexion();
        $cafeteria = factory(App\Models\Cafeteria::class)->create();
        $responsable = factory(App\Models\Responsable::class)->create(['cafeteria_id' => $cafeteria->id]);
        $nouvelleCafeteria = factory(App\Models\Cafeteria::class)->make();
        $this->seeInDatabase('cafeterias', ['nom' => $cafeteria->nom]);
        $this->dontSeeInDatabase('cafeterias', ['nom' => $nouvelleCafeteria->nom]);
        $request = [
            'nom' => $nouvelleCafeteria->nom,
            'adresse' => $cafeteria->adresse,
            'localisation' => $cafeteria->localisation,
            'responsable' => [
                                [
                                    'nom' => $responsable->nom,
                                    'telephone' => $responsable->telephone,
                                ],
                            ],
        ];
        $this->call('PUT', '/cafeterias/'.$cafeteria->id, $request);
        $this->seeInDatabase('cafeterias', ['nom' => $nouvelleCafeteria->nom]);
    }

    /**
     * Test que l'index affiche toutes les cafétérias du système.
     * @test
     */
    public function l_index_liste_toute_les_cafeterias()
    {
        $this->connexion();
        factory(App\Models\Cafeteria::class, 5)->create();
        $cafeterias = Cafeteria::all();
        $this->visit('cafeterias');
        foreach ($cafeterias as $key => $cafeteria) {
            $this->see($cafeteria->nom);
        }
    }

    /**
     * Test que le système affiche toutes les informations d'une cafeteria.
     * @test
     */
    public function affiche_toutes_les_informations_d_une_cafeteria()
    {
        $this->connexion();
        $cafeteria = factory(App\Models\Cafeteria::class)->create();
        $responsables = factory(App\Models\Responsable::class, 3)
            ->create(['cafeteria_id' => $cafeteria->id]);

        $this->visit('cafeterias/'.$cafeteria->id);
        $this->see($cafeteria->nom);
        $this->see($cafeteria->adresse);
        $this->see($cafeteria->localisation);
        foreach($responsables as $key => $responsable){
            $this->see($responsable->nom);
            $this->see($responsable->telephone);
        }
    }

    /**
     * S'assure que si le numéro de téléphone est invalide, la request 
     * empêche la création de la cafétéria.
     * @test
     */
    public function le_numero_telephone_doit_etre_valide()
    {
        $this->connexion();

        $request = $this->construireRequestSelonNumero('(819)-123-4567');
        $this->call('POST', '/cafeterias', $request);
        $this->assertSessionMissing('errors');

        $request = $this->construireRequestSelonNumero('8191234567');
        $this->call('POST', '/cafeterias', $request);
        $this->assertSessionMissing('errors');

        $request = $this->construireRequestSelonNumero('819.123.4567');
        $this->call('POST', '/cafeterias', $request);
        $this->assertSessionMissing('errors');

        $request = $this->construireRequestSelonNumero('(819)1234567');
        $this->call('POST', '/cafeterias', $request);
        $this->assertSessionMissing('errors');

        $request = $this->construireRequestSelonNumero('819-123-4567');
        $this->call('POST', '/cafeterias', $request);
        $this->assertSessionMissing('errors');
    
        $request = $this->construireRequestSelonNumero('(819)-123-4567 poste 3');
        $this->call('POST', '/cafeterias', $request);
        $this->assertSessionHas('errors');

        $request = $this->construireRequestSelonNumero('819/123/4567');
        $this->call('POST', '/cafeterias', $request);
        $this->assertSessionHas('errors');

        $request = $this->construireRequestSelonNumero('Texte');
        $this->call('POST', '/cafeterias', $request);
        $this->assertSessionHas('errors');
    }
    
    /**
     * Tous les champs obligatoire du formulaire de création 
     * de cafétéria sont réellement obligatoire.
     * @test
     */
    public function les_champs_obligatoire_sont_obligatoires()
    {
        $this->connexion();

        $request = $this->construireRequestInvalide('nom');
        $this->call('POST', '/cafeterias', $request);
        $this->assertSessionHas('errors');

        $request = $this->construireRequestInvalide('adresse');
        $this->call('POST', '/cafeterias', $request);
        $this->assertSessionHas('errors');

        $request = $this->construireRequestInvalide('localisation');
        $this->call('POST', '/cafeterias', $request);
        $this->assertSessionHas('errors');

        $request = $this->construireRequestInvalide();
        unset($request['responsable'][0]['nom']);
        $this->call('POST', '/cafeterias', $request);
        $this->assertSessionHas('errors');

        $request = $this->construireRequestInvalide();
        unset($request['responsable'][0]['telephone']);
        $this->call('POST', '/cafeterias', $request);
        $this->assertSessionHas('errors');
    }

    /**
     * Construit un array en retirant la clé passé en argument
     * @param  String|null $cle L'élément à retirer, null si aucun
     * @return Array           La request
     */
    private function construireRequestInvalide(String $cle = null)
    {
        $cafeteria = factory(App\Models\Cafeteria::class)->make();  
        $responsable = factory(App\Models\Responsable::class)->make();

        $request = [
            'nom' => $cafeteria->nom,
            'adresse' => $cafeteria->adresse,
            'localisation' => $cafeteria->localisation,
            'responsable' => [
                                [
                                    'nom' => $responsable->nom,
                                    'telephone' => $responsable->telephone,
                                ],
                            ],
        ];

        if (isset($cle)) {
            unset($request[$cle]);
        }

        return $request;
    }

    /**
     * Construit un array représentant une CafeteriaRequest avec le 
     * numéro de téléphone donné.
     * @param  String $numero Un numéro de téléphone
     * @return Array         Représentation d'une cafeteriaRequest
     */
    private function  construireRequestSelonNumero(String $numero)
    {
        $cafeteria = factory(App\Models\Cafeteria::class)->make();
        $responsable = factory(App\Models\Responsable::class)->make(['telephone' => $numero]);
        $request = [
            'nom' => $cafeteria->nom,
            'adresse' => $cafeteria->adresse,
            'localisation' => $cafeteria->localisation,
            'responsable' => [
                                [
                                    'nom' => $responsable->nom,
                                    'telephone' => $responsable->telephone,
                                ],
                            ],
        ];
        return $request;
    } 

    /**
     * Crée et connecte un utilisateur.
     */
    private function connexion()
    {
    	$user = factory(App\User::class)->create();
    	$this->actingAs($user);
    }
}
