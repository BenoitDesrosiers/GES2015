<?php

namespace App\Models;

use App\Models\Responsable;
use Illuminate\Database\Eloquent\Model;

/**
  * Class Cafeteria
  *
  * Classe qui représente une cafétéria. Contient un nom, une adresse,
  * une localisation et une relation avec des responsables.
  *
  * @author Alexandre
  */
class Cafeteria extends Model
{

	protected $guarded = ['id'];

	/**
	 * Une cafétéria peut avoir plusieurs responsables
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
    public function responsable()
    {
    	return $this->hasMany('App\Models\Responsable');
    }
}
