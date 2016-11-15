<?php
/**
 * La classe DelegueCourriel
 *
 * @author Marc P
 *
 * @version 0.1
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
     * Le champ «courriel» doit être un «string»
     */

    public function validationRules()
    {
        return [
            'courriel' => 'string'
        ];
    }


}