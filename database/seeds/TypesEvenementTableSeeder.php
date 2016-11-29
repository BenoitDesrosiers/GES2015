<?php
/**
 * @author Jessee
 * @version 0.0.1 rev 1
 */
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

use App\Models\TypeEvenement;

class TypesEvenementTableSeeder extends Seeder
{
    /**
     * Exécuter le seeder de la table.
     *
     * @return void
     */
    public function run()
    {
        DB::table('types_evenement')->delete();

        //Les différents types d'événement possible
        $types= ['Finale', 'Demi-Finale', 'Quart-Finale', 'Classement', 'Autre'];

        foreach ($types as $type) {
            DB::table('types_evenement')->insert(array('titre'=>$type));
        }
    }
}
