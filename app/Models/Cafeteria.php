<?php

namespace App\Models;

use App\Models\Responsable;
use Illuminate\Database\Eloquent\Model;

class Cafeteria extends Model
{
    public function Responsable()
    {
    	return $this->hasMany('Responsable');
    }
}
