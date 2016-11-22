<?php
/**
 * @author Jessee
 * @version 0.0.1 rev 1
 */

namespace App\Models;

class TypeEvenement extends EloquentValidating {

    protected $guarded = array('id');
    protected $table = 'types_evenement';

    public function evenements() {
        return $this->belongsToMany('App\Models\Evenement', 'type_id', 'id');
    }

}