<?php
/**
 * La classe Association
 * 
 * 
 * @author Francis M
 * @version 0.1
 */
 
namespace App\Models;
 
class Association extends EloquentValidating {
	protected $guarded = array('id');


/**
 * Validation
 *
 * une association doit avoir:
 * - nom: obligatoire et unique dans toute la table.
 * - abréviation: obligatoire et unique dans toute la table.
 * - Les autres champs sont falcultatifs.
 */
 
public $validationMessages;

public function validationRules() {
	return [
		'nom' => 'required|unique:associations,nom'.($this->id ? ",$this->id" : ''),
		'abreviation' => 'required|unique:associations,abreviation'.($this->id ? ",$this->id" : '')
		];
}

}