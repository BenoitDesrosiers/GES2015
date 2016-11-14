<?php
/**
 * La classe DelegueTelephone
 *
 *@author Marc P
 *
 * @version 0.1
 */


namespace App\Models;


/**
 * @property  telephone
 */
class DelegueTelephone extends EloquentValidating
{
    protected $guarded = array('id');

    public function delegue() {
        return $this->belongsTo(Delegue::class);
    }


    /**
     * Identifie les colonnes qui peuvent être modifiées
     */
    protected $fillable = [
        'telephone',
        'delegue_id'
    ];

    /**
     * Le champs «téléphone» doit être un «string»
     */
    public function validationRules()
    {
        return [
            'telephone' => 'string'
        ];
    }
}