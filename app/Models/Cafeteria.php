<?php

namespace App\Models;

use App\Models\Responsable;
use Illuminate\Database\Eloquent\Model;

class Cafeteria extends Model
{

	protected $guarded = ['id'];

    public function responsable()
    {
    	return $this->hasMany('App\Models\Responsable');
    }
}
