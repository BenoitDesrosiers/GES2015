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
    //use DatabaseTransactions;

    /** @test */
    public function verification_table_postes_existe()
    {
        $this->assertTrue(Schema::hasTable('postes'), "La table 'postes' n'existe pas!");
    }

    /** @test */
    public function creation_d_un_poste()
    {
        $poste = factory(App\Models\Poste::class)->make();
        $input = ['nom' => $poste->nom, 'description' => $poste->description];
        $this->call('POST', '/postes', $input);
        $this->assertSessionMissing(['errors']);
    }

    /** @test */
    public function sauvegarde_d_un_poste_dans_BD()
    {
        $poste = factory(App\Models\Poste::class)->make();
        $input = ['nom' => $poste->nom, 'description' => $poste->description];
        $this->call('POST', '/postes/store', $input);
        $this->assertSessionMissing(['errors']);
        $this->seeInDatabase('postes',
            ['nom' => $poste->nom,
            'description' => $poste->description
        ]);
    }

    /** @test */
    public function modification_d_un_poste()
    {
        $poste = factory(App\Models\Poste::class)->make();
        $input = ['nom' => $poste->nom, 'description' => $poste->description];
        $this->call('PUT', '/postes/update', $input);
        $this->assertSessionMissing(['errors']);
        $this->seeInDatabase('postes',
            ['nom' => $poste->nom,
            'description' => $poste->description
            ]);
    }

    /** @test */
    public function suppression_d_un_poste()
    {
        $poste = factory(App\Models\Poste::class)->make();
        $input = ['nom' => $poste->nom, 'description' => $poste->description];
        $this->call('DELETE', '/postes/destroy', $input);
        $this->assertSessionMissing(['errors']);
        $this->dontSeeInDatabase('postes',
            ['nom' => $poste->nom,
            'description' => $poste->description
            ]);
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
