<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class ConditionParticuliere
 *
 * Classe qui représente une condition particulière avec un nom unique
 * et une description.
 *
 * @author Res260
 * @created_at 165420
 * @modified_at 165420
 */
class ConditionParticuliere extends EloquentValidating
{
	/**
	 * La table associée au modèle.
	 *
	 * @var string
	 */
	protected $table = 'conditions_particulieres';

	/**
	 * Un id ne change pas.
	 *
	 * @var array La liste des valeurs qui ne peuvent être modifiées.
	 */
	protected $guarded = array('id');

	protected $fillable = [
		'nom',
		'description'
	];

	/**
	 * @var String le message à récupérer en cas d'erreur de validation.
	 */
	public $validationMessages;

	/**
	 * Retourne les règles de validation pour l'ajout
	 * ou la modification d'une condition particulière.
	 *
	 * @return array Les règles de validation.
	 */
	public function validationRules() {
		return [
			'nom' => 'string|required|unique:conditions_particulieres',
			'description' => 'string'
		];
	}
}
