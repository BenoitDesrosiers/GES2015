<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
  * Class Responsable
  *
  * Classe qui représente un responsable. Contient un nom,
  * un numéro de téléphone et une relation avec une cafétéria.
  *
  * @author Alexandre
  */
class Responsable extends Model
{

	protected $guarded = ['id'];

	/**
	 * Un responsable est assigné à une cafétéria.
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
    public function cafeteria()
    {
    	return $this->belongsTo('App\Models\Cafeteria');
    }
}
