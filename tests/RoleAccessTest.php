<?php

use App\Models\Role;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class RoleAccessTest extends TestCase
{
    use DatabaseTransactions;

    public function setUp()
    {
        parent::setUp();

        $user = factory(App\User::class)->create();
        $this->actingAs($user);
    }

    /**
     * Cette fonction permet d'avoir un usager random avec
     * une factory.
     *
     * @return \App\User
     */
    public function getFactoryUser(){
        $user = factory(App\User::class)->create();
        return $user;
    }



    /**
     * Cette fonction permet changer l'usager en cours
     * pour un nouveau usager avec le rôle voulu.
     *
     * @param $roleName
     * @return $this
     */
    public function actingWithRole($roleName){
        $role = Role::all()->where('name',$roleName)->first();
        $user = $this->getFactoryUser();
        if ($roleName != 'aucun_role'){
            $user->attachRole($role);
        }
        $this->actingAs($user);
        return $this;
    }

    /**
     * Teste que la table 'Roles' existe dans la base de données.
     */
    public function testTableRoleCreee() {
        $this->assertTrue(Schema::hasTable('roles'), "La table 'roles' n'existe pas!");
    }

    // Test d'accès avec le rôle 'responsable'

    /**
     * Test qu'un usager avec le rôle 'admin' reçoive le code 200
     * en tentant d'accèder à une route du groupe administrative.
     *
     * @group admin
     * @group access
     *
     */
    public function test_Admin_Accessing_Administrative_Route()
    {
        $this->actingWithRole('admin')->route('GET','users.index');
        $this->assertResponseStatus(200);
    }

    /**
     * Test qu'un usager avec le rôle 'admin' reçoive le code 200
     * en tentant d'accèder à une route du groupe responsable.
     *
     * @group admin
     * @group access
     *
     */
    public function test_Admin_Accessing_Responsable_route()
    {
        $this->actingWithRole('admin')->route('GET','epreuves.index');
        $this->assertResponseStatus(200);
    }

    /**
     * Test qu'un usager avec le rôle 'admin' reçoive le code 200
     * en tentant d'accèder à une route pour les usagers connectés.
     *
     * @group responsable
     * @group access
     *
     */
    public function test_Admin_Accessing_Current_User_Edit_URL()
    {
        $this->actingWithRole('admin')->get('/users/MonCompte');
        $this->assertResponseStatus(200);
    }

    /**
     * Test qu'un usager avec le rôle 'admin' reçoive le code 200
     * en tentant d'accèder à une route sans protection.
     *
     * @group admin
     * @group access
     *
     */
    public function test_Admin_Accessing_No_Middleware_URL()
    {
        $this->actingWithRole('admin')->get('/about');
        $this->assertResponseStatus(200);
    }




    // Test d'accès avec le rôle 'responsable'

    /**
     * Test qu'un usager avec le rôle 'responsable' reçoive le code 403
     * en tentant d'accèder à une route du groupe administrative.
     *
     * @group responsable
     * @group access
     *
     */
    public function test_Responsable_Accessing_Administrative_Route()
    {
        $this->actingWithRole('responsable')->route('GET','users.index');
        $this->assertResponseStatus(403);
    }

    /**
     * Test qu'un usager avec le rôle 'responsable' reçoive le code 200
     * en tentant d'accèder à une route du groupe responsable.
     *
     * @group responsable
     * @group access
     *
     */
    public function test_Responsable_Accessing_Responsable_route()
    {
        $this->actingWithRole('responsable')->route('GET','epreuves.index');
        $this->assertResponseStatus(200);
    }

    /**
     * Test qu'un usager avec le rôle 'employe' reçoive le code 200
     * en tentant d'accèder à une route pour les usagers connectés.
     *
     * @group responsable
     * @group access
     *
     */
    public function test_Responsable_Accessing_Current_User_Edit_URL()
    {
        $this->actingWithRole('responsable')->get('/users/MonCompte');
        $this->assertResponseStatus(200);
    }

    /**
     * Test qu'un usager avec le rôle 'employe' reçoive le code 200
     * en tentant d'accèder à une route sans protection.
     *
     * @group responsable
     * @group access
     *
     */
    public function test_Responsable_Accessing_No_Middleware_URL()
    {
        $this->actingWithRole('responsable')->get('/about');
        $this->assertResponseStatus(200);
    }




    // Test d'accès avec le rôle 'employe'

    /**
     * Test qu'un usager avec le rôle 'employe' reçoive le code 403
     * en tentant d'accèder à une route du groupe administrative.
     *
     * @group employe
     * @group access
     *
     */
    public function test_Employe_Accessing_Administrative_Route()
    {
        $this->actingWithRole('employe')->route('GET','users.index');
        $this->assertResponseStatus(403);
    }

    /**
     * Test qu'un usager avec le rôle 'employe' reçoive le code 403
     * en tentant d'accèder à une route du groupe responsable.
     *
     * @group employe
     * @group access
     *
     */
    public function test_Employe_Accessing_Responsable_route()
    {
        $this->actingWithRole('employe')->route('GET','epreuves.index');
        $this->assertResponseStatus(403);
    }

    /**
     * Test qu'un usager avec le rôle 'employe' reçoive le code 200
     * en tentant d'accèder à une route pour les usagers connectés.
     *
     * @group employe
     * @group access
     *
     */
    public function test_Employe_Accessing_Current_User_Edit_URL()
    {
        $this->actingWithRole('employe')->get('/users/MonCompte');
        $this->assertResponseStatus(200);
    }

    /**
     * Test qu'un usager avec le rôle 'employe' reçoive le code 200
     * en tentant d'accèder à une route sans protection.
     *
     * @group employe
     * @group access
     *
     */
    public function test_Employe_Accessing_No_Middleware_URL()
    {
        $this->actingWithRole('employe')->get('/about');
        $this->assertResponseStatus(200);
    }




    // Test d'accès avec aucun rôle

    /**
     * Test qu'un usager avec aucun rôle reçoive le code 403
     * en tentant d'accèder à une route du groupe administrative.
     *
     * @group aucun_role
     * @group access
     *
     */
    public function test_Aucun_Role_Accessing_Administrative_Route()
    {
        $this->actingWithRole('aucun_role')->route('GET','users.index');
        $this->assertResponseStatus(403);
    }

    /**
     * Test qu'un usager avec aucun rôle reçoive le code 403
     * en tentant d'accèder à une route du groupe responsable.
     *
     * @group aucun_role
     * @group access
     *
     */
    public function test_Aucun_Role_Accessing_Responsable_route()
    {
        $this->actingWithRole('aucun_role')->route('GET','epreuves.index');
        $this->assertResponseStatus(403);
    }

    /**
     * Test qu'un usager avec aucun rôle reçoive le code 200
     * en tentant d'accèder à une route pour les usagers connectés.
     *
     * @group aucun_role
     * @group access
     *
     */
    public function test_Aucun_Role_Accessing_Current_User_Edit_URL()
    {
        $this->actingWithRole('aucun_role')->get('/users/MonCompte');
        $this->assertResponseStatus(200);
    }

    /**
     * Test qu'un usager avec aucun rôle reçoive le code 200
     * en tentant d'accèder à une route sans protection.
     *
     * @group aucun_role
     * @group access
     *
     */
    public function test_Aucun_Role_Accessing_No_Middleware_URL()
    {
        $this->actingWithRole('aucun_role')->get('/about');
        $this->assertResponseStatus(200);
    }

}
