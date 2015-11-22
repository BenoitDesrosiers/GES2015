<?php
/**
 * Participant qui représente une équipe
 *
 * @author obnosim
 */

namespace App\Models;

class Equipe extends EloquentValidating {

	/**
	* La table correspondant aux équipes
	*/
	protected $table = 'participants';

	/**
	* Eloquent relationship: Tous les participants faisant partie de cette équipe
	*
	* @return Participant[]
	*/
	public function membres() {
		return $this->belongsToMany('App\Models\Participant', 'participants_equipes', 'chef_id', 'joueur_id');
	}

	/**
	* Eloquent relationship: La région à laquelle l'équipe appartient
	*/
	public function region() {
		return $this->belongsTo('App\Models\Region');
	}

	/**
	* Eloquent relationship: Tous les sports associés à cette équipe
	*/
	public function sports() {
		return $this->belongsToMany('App\Models\Sport', 'participant_sport', 'participant_id', 'sport_id');
	}

	/**
	* La liste des id des joueurs de cette équipe
	*
	* @return int[]
	*/
	public function idMembres() {
		$idMembres = [];
		foreach($this->membres as $membre) {
			$idMembres[] = $membre->id;
		}
		return $idMembres;
	}

	/**
	* Le nombre total de membres dans cette équipe
	*
	* @return int Le nombre de membres
	*/
	public function nombreMembres() {
		return $this->membres->count();
	}

	/**
	* Retourne le sport (ou le premier sport s'il y en a plusieurs) de cette équipe
	*/
	public function sport() {
		return $this->sports->first();
	}

	/**
	* Identifie les colonnes qui peuvent être modifiées
	*/
	protected $fillable = [
			'id',
			'nom',
			'numero',
			'region_id',
		];

	public $validationMessages;

	/**
	* Règles de validation
	*/
	public function validationRules() {
		return [
	//      equipe doit être à 'vrai'
			'equipe' => 'accepted',
			'nom' => 'required|string',
			'region_id' => 'required|integer' //exists:regions, id  ---> ne fonctionne pas
	// 		Numéro unique parmi les équipes mais pas nécessairement parmi les joueurs
	// 		'numero' => 'unique:participants,numero,numero,id,equipe,1' ---> empêche la mise à jour
			];
	}

}
