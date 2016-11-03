<?php
/**
 * Created by PhpStorm.
 * User: marcopolo
 * Date: 2016-11-02
 * Time: 7:42 PM
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DelegueCourriel extends EloquentValidating
{

    protected $guarded = array('id');

    public function delegue_Courriel() {
        return $this->belongsTo(Delegue::class);
    }

    protected $fillable = [
        'courriel',
        'delegue_id'
    ];

    public function validationRules()
    {
        return [
            'courriel' => 'string'
        ];
    }


}