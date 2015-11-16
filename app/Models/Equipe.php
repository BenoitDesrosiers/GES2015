<?php
/**
 * Pont entre des joueurs (participant.equipe = false) et une équipe (participant.equipe = true)
 * Représente une seule entrée de la table participants_equipes
 *
 * @author obnosim
 * @version 0.0.1 rev 1
 */

namespace App\Models;

class Equipe extends EloquentValidating {
	protected $guarded = array('id');

/**
 * La table correspondant aux équipes
 */
protected $table = 'participants_equipes';

/**
 * Le participant en charge de cette équipe
 * (celui qui est une équipe en soi, soit celui pour quoi participants.equipe = true)
 *
 * @return Participant Le participant-équipe
 */
public function chef() {
    return $this->belongsTo('App\Models\Participant', 'chef_id');
}

/**
 * Le participant propre à cette entrée
 * (participants.equipe = false)
 *
 * @return Participant Le participant
 */
public function joueur() {
    return $this->hasOne('App\Models\Participant', 'id', 'joueur_id');
}

/**
 * Le nombre total de membres dans cette équipe
 *
 * @return int Le nombre de membres
 */
public function nombreJoueurs() {
	return Equipe::where("chef_id", "=", $this->chef_id)->count();
}

/**
 * Toutes les entrées de la table participants_equipes
 * qui sont associées à la même équipe, de type Equipe
 *
 * @return Equipe[] Toutes les entrées pour cette équipe
 */
public function membresEquipe() {
	return Equipe::where("chef_id", "=", $this->chef_id)->get();
}

/**
 * Tous les joueurs qui font partie de la même équipe, de type Participant
 *
 * @return Participant[] Tous les joueurs de cette équipe
 */
public function joueursEquipe() {
	$joueurs = array();
	foreach ($this->membresEquipe() as $joueur) {
		$joueurs[$joueur->joueur_id] = $joueur->joueur();
	}
	return $joueurs;
}

/**
 * La liste des id des joueurs qui font partie de la même équipe
 *
 * @return int[] Tous les id des joueurs de cette équipe
 */
public function idJoueurs() {
	$idJoueurs = array();
	foreach ($this->membresEquipe() as $joueur) {
		$joueurs[] = $joueur->joueur_id;
	}
	return $joueurs;
}

/**
 * Identifie les colonnes qui peuvent être modifiées
 */
protected $fillable = [
        'chef_id',
        'joueur_id'
    ];

public $validationMessages;

/** 
 * Les champs chef_id et participants_id sont des entiers requis
 * chef_id doit correspondre à un id de participant qui est une équipe
 * joueur_id doit correspondre à un id de participant qui N'est PAS une équipe
 */

public function validationRules() {
	return [
        'chef_id' => 'required|integer|exists:participants,participant_id,equipe,1',
        'joueur_id' => 'required|integer|exists:participants,participant_id,equipe,0'
		];
}

public function save(array $options = array())
{
	DB::table('participants_equipes')->insert($options);
}

}