<?php
/**
 * DisponbiliteArbitre représente une disponibilité d'un arbitre
 *
 *
 * @author Simon Gagné
 * @version 0.0.1 rev 1
 */

namespace App\Models;

class DisponibiliteArbitre extends EloquentValidating {
    protected $guarded = array('id');

    protected $table = 'disponibilites_arbitres';

    /**
     * Eloquent relationship:
     * - Une disponibilité est associé à un arbitre
     * PS: Un arbitre n'es pas obligé d'avoir une disponibilité.
     */
    public function arbitre() {
        return $this->belongsTo('App\Models\Arbitre');
    }


    /**
     * Identifie les colonnes qui peuvent être modifiées
     */
    protected $fillable = [
        'arbitre_id',
        'date',
        'debut',
        'fin',
        'commentaire'
    ];

    /**
     * Validation
     *
     * Un arbitreTelephone doit obligatoirement avoir:
     *  - numero_telephone :string
     *
     * Un arbitreTelephone peut facultativement avoir
     *  - description:string
     */

    public $validationMessages;

    public function validationRules() {
        return [
            'arbitre_id'=> 'required|integer',
            'date' => 'required|date',
            'debut' => 'required|date_format:H:i:s',
            'fin' => 'required|date_format:H:i:s|after:debut',
            'commentaire' => 'string',
        ];
    }
}