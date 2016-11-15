<?php
/**
 * Classe modèle pour un téléphone qui a une description et un numéro.
 * Il appartient à un participant.
 *
 * @author Émilio G!
 * @date 161025
 */
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Telephone extends EloquentValidating
{
	/**
	 * Un id ne change pas.
	 *
	 * @var array La liste des valeurs qui ne peuvent être modifiées.
	 */
	protected $guarded = array('id');

	/**
	 * Un téléphone appartient à un participant.
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\HasOne
	 */
    public function participant() {
    	return $this->belongsTo(Participant::class);
	}

	/**
	 * Identifie les colonnes qui peuvent être modifiées
	 */
	protected $fillable = [
		'description',
		'numero',
		'participant_id'
	];

	/**
	 * @var String le message à récupérer en cas d'erreur de validation.
	 */
	public $validationMessages;

	/**
	 * Retourne les règles de validation pour l'ajout
	 * ou la modification d'un téléphone.
	 *
	 * @return array Les règles de validation.
	 */
	public function validationRules() {
		return [
			'description' => 'string',
			'numero'	  => 'required|string'
		];
	}
}
