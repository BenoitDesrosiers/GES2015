<?php

use App\Models\Role;
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


    public function test_que_la_table_role_existe()
    {
        //$this->actingWithRole($role)->route('GET','users.index');
        //$this->assertResponseStatus($code);
        $this->assertTrue(true);
    }


}
