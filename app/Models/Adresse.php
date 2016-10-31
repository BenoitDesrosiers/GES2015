<?php
/**
 * Classe modèle pour une adresse qui a une description et une 'adresse'.
 * Il appartient à un participant.
 *
 * @author Émilio G!
 * @date 161030
 */
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Adresse extends EloquentValidating
{
	/**
	 * Un id ne change pas.
	 *
	 * @var array La liste des valeurs qui ne peuvent être modifiées.
	 */
	protected $guarded = array('id');

	/**
	 * Une adresse appartient à un participant.
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
		'adresse',
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
			'adresse'	  => 'required|string'
		];
	}
}
