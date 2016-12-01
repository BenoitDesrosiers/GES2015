<?php
/**
 * La classe Association
 * 
 * 
 * @author GBEY0402
 * @version 0.1
 */
 
namespace App\Models;
 
class Association extends EloquentValidating {
	protected $guarded = array('id');


/**
 * Validation
 *
 * un code doit avoir:
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