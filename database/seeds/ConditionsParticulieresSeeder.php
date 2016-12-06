<?php

use App\Models\ConditionParticuliere;
use Illuminate\Database\Seeder;

/**
 * Class ConditionsParticulieresSeeder
 *
 * Seeder pour les conditions particulières.
 *
 * @author Res260
 * @created_at 165120
 * @modified_at 165120
 */
class ConditionsParticulieresSeeder extends Seeder {

	/**
	 * 'Seed' la base de données de conditions particulières.
	 */
	public function run() {
		DB::table('conditions_particulieres')->delete();

		$condition1 = ConditionParticuliere::create( ['nom' => 'Condition 1',
													  'description' => 'description 1']);
		$condition1->save();

		$condition2 = ConditionParticuliere::create( ['nom' => 'Condition 2',
			'description' => 'description 2 yeah']);
		$condition2->save();

		$condition3 = ConditionParticuliere::create( ['nom' => 'Condition 3 sans description']);
		$condition3->save();
	}
}
