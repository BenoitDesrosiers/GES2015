<?php
/**
 * Les tests pour les postes des bénévoles.
 *
 * @author Nicolas Bisson (ProgBiss)
 */

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Models\Poste;

class PosteTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function verification_table_postes_existe()
    {
        $this->assertTrue(Schema::hasTable('postes'), "La table 'postes' n'existe pas!");
    }

    /** @test */
    public function creation_d_un_poste()
    {
        $user = factory(App\User::class)->create();
        $this->actingAs($user);

        $poste = factory(App\Models\Poste::class)->make();
        $input = ['nom' => $poste->nom, 'description' => $poste->description];
        $this->call('POST', '/postes', ['input' => $input]);
        $this->assertSessionMissing(['errors']);
    }

    /** @test */
    public function sauvegarde_d_un_poste_dans_BD()
    {
        $user = factory(App\User::class)->create();
        $this->actingAs($user);

        $poste = factory(App\Models\Poste::class)->make();
        $input = ['nom' => $poste->nom, 'description' => $poste->description];
        $this->call('POST', '/postes', $input);
        $this->assertSessionMissing(['errors']);
        $this->seeInDatabase('postes',
            ['nom' => $poste->nom,
            'description' => $poste->description
        ]);
    }

    /** @test */
    public function modification_d_un_poste()
    {
        $user = factory(App\User::class)->create();
        $this->actingAs($user);

        $poste = factory(App\Models\Poste::class)->create();
        $input = ['nom' => $poste->nom . '1', 'description' => $poste->description];
        $this->call('PUT', '/postes/' . $poste->id, $input);
        $this->assertSessionMissing(['errors']);
        $this->seeInDatabase('postes',
            ['nom' => $poste->nom . '1',
            'description' => $poste->description
            ]);
    }

    /** @test */
    public function suppression_d_un_poste()
    {
        $user = factory(App\User::class)->create();
        $this->actingAs($user);

        $poste = factory(App\Models\Poste::class)->create();
        $this->call('DELETE', '/postes/' . $poste->id);
        $this->assertSessionMissing(['errors']);
        $this->dontSeeInDatabase('postes', ['id' => $poste->id]);
    }

    /**
     * @test
     * @dataProvider nullProvider
     */
    public function nullProvider()
    {
        return [
            'poste' => [null, 'Une description descriptive.']
        ];
    }
}
