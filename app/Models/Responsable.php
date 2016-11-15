<?php

namespace App\Models;

use App\Models\Cafeterias;
use Illuminate\Database\Eloquent\Model;

class Responsable extends Model
{
    public function Cafeteria()
    {
    	return $this->belongsTo('Cafeterias');
    }
}
