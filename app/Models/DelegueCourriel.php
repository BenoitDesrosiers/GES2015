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

    public function delegue() {
        return $this->belongsTo(Delegue::class);
    }

    /**
     * Identifie les colonnes qui peuvent être modifiées
     */

    protected $fillable = [
        'courriel',
        'delegue_id'
    ];

    /**
     * Le champs «courriel» doit être un «string»
     */

    public function validationRules()
    {
        return [
            'courriel' => 'string'
        ];
    }


}