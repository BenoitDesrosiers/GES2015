<?php

use App\Models\Role;
use App\User;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CRUD_UsagerTest extends TestCase
{

    use DatabaseTransactions;

    public function setUp()
    {
        parent::setUp();

        $this->actingWithRole('admin');
    }

    /**
     * Cette fonction permet changer l'usager en cours
     * pour un nouveau usager avec le rôle voulu.
     *
     * @param $roleName string
     * @return $this
     */
    public function actingWithRole($roleName){
        $role = Role::all()->where('name',$roleName)->first();
        $user = factory(App\User::class)->create();
        $user->attachRole($role);
        $this->actingAs($user);
        return $this;
    }

    /**
     * Test la création d'un usager avec un contrôleur.
     *
     * @group crud_usager
     * @group reussi
     */
    public function test_la_creation_dun_usager_avec_controller()
    {
        $requete = $this->requete_valide();

        $this->call('POST', '/users/', $requete);
        $this->assertSessionMissing(['errors']);
        $this->seeInDatabase('users', ['name' => $requete['nom'], 'email' => $requete['courriel']]);
    }

    /**
     * Test la suppression d'un usager avec un contrôleur.
     *
     * @group crud_usager
     * @group reussi
     */
    public function test_la_suppression_dun_usager_avec_controller()
    {
        $requete = $this->requete_valide();

        $this->call('POST', '/users/', $requete);
        // Test que l'usager qui vient d'être créé existe afin de supprimer un usager existant.
        $this->seeInDatabase('users', ['name' => $requete['nom'], 'email' => $requete['courriel']]);
        $usager = User::all()->last();

        $this->route('DELETE', 'users.destroy', $usager);
        $this->notSeeInDatabase('users', ['name' => $requete['nom'], 'email' => $requete['courriel']]);
    }

    /**
     * Test la modification d'un usager avec un contrôleur.
     *
     * @group crud_usager
     * @group reussi
     */
    public function test_la_modification_dun_usager_avec_controller()
    {
        $requete = $this->requete_valide();

        $lastId = $this->get_Dernier_Usager()->id;
        $nouveauNom = str_random(10);
        $old_name = $requete['nom'];
        $requete['nom'] = $nouveauNom;

        $this->visit('/users/'.$lastId.'/edit');
        $this->call('PUT', '/users/'.$lastId,$requete);
        $this->assertRedirectedToAction('UsagersController@index');
        $this->notSeeInDatabase('users', ['name' => $old_name, 'email' => $requete['courriel']]);
        $this->seeInDatabase('users',['name' => $nouveauNom, 'email' => $requete['courriel']]);
    }

    /**
     * Test la modification d'un usager avec un contrôleur.
     *
     * @group crud_usager
     * @group reussi
     */
    public function test_la_modification_de_lusager_en_cours_avec_controller()
    {

        // Crée un usager
        $requete = $this->requete_valide();
        $this->call('POST', '/users/', $requete);

        // Obtient le dernier usager
        $usager = $this->get_Dernier_Usager();

        $this->actingAs($usager);

        $old_name = $requete['nom'];
        $nouveauNom = str_random(10);
        $requete['nom'] = $nouveauNom;

        $this->visit('/users/MonCompte');
        $this->call('PUT', '/users/MonCompteUpdate',$requete);

        $this->assertSessionMissing(['errors']);
        $this->assertRedirectedToAction('HomeController@index');

        $this->notSeeInDatabase('users', ['name' => $old_name, 'email' => $requete['courriel']]);
        $this->seeInDatabase('users',['name' => $nouveauNom, 'email' => $requete['courriel']]);
    }

    /**
     * Test la création d'un usager avec un contrôleur avec un mauvais nom.
     *
     * @group crud_usager
     * @group erreur
     */
    public function test_de_la_creation_dun_usager_avec_controller_Erreur_Nom()
    {
        // Trop de lettre.
        $invalideParametre = ['nom' => str_random(256)];
        $requete = $this->construire_Request_Invalide($invalideParametre);
        $this->call('POST', '/users/', $requete);
        $this->assertSessionHas(['errors']);

        // Vide
        $invalideParametre = ['nom' => ''];
        $requete = $this->construire_Request_Invalide($invalideParametre);
        $this->call('POST', '/users/', $requete);
        $this->assertSessionHas(['errors']);

        // Null.
        $invalideParametre = ['nom' => null];
        $requete = $this->construire_Request_Invalide($invalideParametre);
        $this->call('POST', '/users/', $requete);
        $this->assertSessionHas(['errors']);
    }

    /**
     * Test la création d'un usager avec un contrôleur avec un mauvais courriel.
     *
     * @group crud_usager
     * @group erreur
     */
    public function test_de_la_creation_dun_usager_avec_controller_Erreur_Courriel()
    {
        // Usager valide
        $requete_valide = $this->requete_valide();
        $this->call('POST', '/users/', $requete_valide);
        $courriel_existant = $requete_valide['courriel'];

        $invalideParametre = ['courriel' => $courriel_existant];
        $requete = $this->construire_Request_Invalide($invalideParametre);
        $this->call('POST', '/users/', $requete);
        $this->assertSessionHas(['errors']);

        // Trop de lettre.
        $invalideParametre = ['courriel' => str_random(256)];
        $requete = $this->construire_Request_Invalide($invalideParametre);
        $this->call('POST', '/users/', $requete);
        $this->assertSessionHas(['errors']);

        // Vide
        $invalideParametre = ['courriel' => ''];
        $requete = $this->construire_Request_Invalide($invalideParametre);
        $this->call('POST', '/users/', $requete);
        $this->assertSessionHas(['errors']);

        // Null.
        $invalideParametre = ['courriel' => null];
        $requete = $this->construire_Request_Invalide($invalideParametre);
        $this->call('POST', '/users/', $requete);
        $this->assertSessionHas(['errors']);
    }

    /**
     * Test la création d'un usager avec un contrôleur avec un mauvais mot de passe.
     *
     * @group crud_usager
     * @group erreur
     */
    public function test_de_la_creation_dun_usager_avec_controller_Erreur_motDePasse()
    {
        // Manque une majuscule
        $invalideParametre = ['mot_de_passe' => 'patate123456'];
        $requete = $this->construire_Request_Invalide($invalideParametre);
        $this->call('POST', '/users/', $requete);
        $this->assertSessionHas(['errors']);

        // Manque une minuscule
        $invalideParametre = ['mot_de_passe' => 'PATATE123456'];
        $requete = $this->construire_Request_Invalide($invalideParametre);
        $this->call('POST', '/users/', $requete);
        $this->assertSessionHas(['errors']);

        // Manque un degit
        $invalideParametre = ['mot_de_passe' => 'Patateeeeee'];
        $requete = $this->construire_Request_Invalide($invalideParametre);
        $this->call('POST', '/users/', $requete);
        $this->assertSessionHas(['errors']);

        // Trop long
        $invalideParametre = ['mot_de_passe' => 'Patate123456'.str_random(60)];
        $requete = $this->construire_Request_Invalide($invalideParametre);
        $this->call('POST', '/users/', $requete);
        $this->assertSessionHas(['errors']);

        // Trop court
        $invalideParametre = ['mot_de_passe' => 'Pa3'];
        $requete = $this->construire_Request_Invalide($invalideParametre);
        $this->call('POST', '/users/', $requete);
        $this->assertSessionHas(['errors']);

        // Null
        $invalideParametre = ['mot_de_passe' => null];
        $requete = $this->construire_Request_Invalide($invalideParametre);
        $this->call('POST', '/users/', $requete);
        $this->assertSessionHas(['errors']);
    }

    /**
     * Test la création d'un usager avec un contrôleur avec un mauvais role.
     *
     * @group crud_usager
     * @group erreur
     */
    public function test_de_la_creation_dun_usager_avec_controller_Erreur_role()
    {
        // Role non existant
        $invalideParametre = ['role' => [0 => str_random(4)]];
        $requete = $this->construire_Request_Invalide($invalideParametre);
        $this->call('POST', '/users/', $requete);
        $this->assertSessionHas(['errors']);

        // Null
        $invalideParametre = ['role' => [0 => null]];
        $requete = $this->construire_Request_Invalide($invalideParametre);
        $this->call('POST', '/users/', $requete);
        $this->assertSessionHas(['errors']);
    }

    /**
     * Cette fonction permet de construire une requête personnalisée.
     *
     * @param array $parametres
     *
     * @return array
     */
    private function construire_Request_Invalide(Array $parametres = []){
        $requete = $this->requete_valide();
        // Si la liste est vide
        if (!empty($parametres)){
            // Pour chaque clé de la liste de paramètre
            foreach (array_keys($parametres) as $key){
                // Si la clé de la liste existe aussi dans $requete
                if (array_key_exists($key, $requete)){
                    $requete[$key] = $parametres[$key];
                }
            }
        }
        return $requete;
    }

    /**
     * Cette fonction renvoie une requête valide.
     */
    private function requete_valide(){
        $usager = factory(User::class)->make();
        // Afin de réduire les chances qu'il y ait un autre usager
        // avec le même courriel.
        $usager->email = $usager->email.str_random(4);
        $requete = [
            'nom' => $usager->name,
            'courriel' => $usager->email,
            'mot_de_passe' => $usager->password,
            'old_mot_de_passe' => $usager->password,
            'role' => [
                0 => 'employe'
            ]
        ];
        return $requete;
    }

    /**
     * Cette fonction permet de retourné le dernier usager.
     *
     * @return User|null
     */
    private function get_Dernier_Usager(){
        $usager = User::orderBy('id','desc')->first();
        return $usager;
    }

}
