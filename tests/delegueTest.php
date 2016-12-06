<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class delegueTest extends TestCase
{

    use DatabaseTransactions;

    public function test_delegue_dans_une_region()
    {
        $user = factory(App\User::class)->create();
        $this->actingAs($user);

        $region = factory(App\Models\Region::class)->create();
        $delegue = factory(App\Models\Delegue::class)->create(['region_id' => $region->id]);
        $this->json('GET','/tableau_delegues', ['region_id' => $region->id])
           ->seeJson([
                'nom' => $delegue->nom,
            ]);
    }

    public function test_delegue_dans_une_region_invalide()
    {
        $user = factory(App\User::class)->create();
        $this->actingAs($user);

        $region = factory(App\Models\Region::class)->create();
        $delegue = factory(App\Models\Delegue::class)->create(['region_id' => $region->id]);
        $this->json('GET','/tableau_delegues', ['region_id' => 999999])
            ->seeJson([
                json_decode($delegue, true).emptyArray()
            ]);
    }





}
