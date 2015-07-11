<?php
/**
 * La classe EloquentValidating ajoute une fonctionnalité de validation à la classe Eloquent
 * 
 * Ses sous-classes peuvent définir des règles de validation en redéfinissant validationRules().  
 * 
 * Cette classe écoute les évènement "creating" et "updating" afin de valider si l'information entré dans
 * objet est bonne. 
 * Si il y'a des erreurs, les messages seront conservés dans la $validationMessages. 
 * 
 * @author benou
 * @version 0.1
 */
class EloquentValidating extends Eloquent {
	
private $valMessages;

/**
 * Attache les "model event" creating et updating. 
 * La fonction isValid sera appelée sur cette objet chaque fois que save() sera appelé.  
 * @return boolean
 */
public static function boot()
{
	parent::boot();
	
	static::creating(function($item)
		{
			if(!$item->isValid()) return false;	
		});
	static::updating(function($item)
		{
			if(!$item->isValid()) return false;
		});
	
}

/**
 * Change le message de validation
 *
 * @author François Allard
 * @param array
 */
public function setValidationMessages($messages) {
	$valMessages = $messages;
}

/**
 * Retourne le message de validation
 *
 * @author François Allard
 * @return array
 */
public function validationMessages() {
	return $valMessages;
}

/**
 * Les règles de validation. Ces règles seront envoyées à un Validator de Laravel.
 * Elles peuvent être redéfinies dans les sous-classes. 
 * 
 * @author benou
 * @return array  
 */
public function validationRules() {
	return [];
}

/**
 * Valide si l'information contenu dans cet objet respecte les règles définies dans validationRules.
 * Si non, la fonction retourne faux, et les messages d'erreurs seront conservé dans $validationMessages. 
 * 
 * 
 */
public function isValid() {
	$validation = Validator::make($this->toArray(), $this->validationRules());
	$this->setValidationMessages($validation->messages());

	return $validation->passes();
}
}