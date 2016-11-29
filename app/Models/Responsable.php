<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Responsable extends Model
{

	protected $guarded = ['id'];

    public function cafeteria()
    {
    	return $this->belongsTo('App\Models\Cafeteria');
    }
}
