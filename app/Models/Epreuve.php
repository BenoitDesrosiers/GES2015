<?php
/**
 * Une Epreuve est une compétition associée à un sport
 * 
 * Les épreuves sont associées à un seul sport. 
 * Deux épreuves d'un même sport ne peuvent avoir le même nom; mais le même nom peut être utilisé pour 2 sports. 
 * 
 * Exemples d'épreuves: 
 * - pour Atlhétisme
 *   - Cadet féminin 100m 
 * - pour Baseball
 *   - Tournoi masculin
 * 
 * @author benou
 * @version 0.1
 */

namespace App\Models;

class Epreuve extends EloquentValidating {

    protected $guarded = array('id');

    /**
     * Eloquent relationship: une épreuve appartient à un sport
     */

    public function sport() {
        return $this->belongsTo('App\Models\Sport');
    }

    public function evenements() {
        return $this->hasMany('App\Models\Evenement');
    }

    public function participants() {
        return $this->belongsToMany('App\Models\Participant');
    }

    /**
     * Eloquent relationship: un épreuve est associé à plusieurs arbitres
     */
    public function arbitres() {
        return $this->belongsToMany('App\Models\Arbitre');
    }

    /**
     * Validation
     *
     * une épreuve doit avoir:
     *  - nom: obligatoire, et unique pour un sport donné, mais je n'ai pas trouvé comment exprimer ca avec les règles de Laravel
     *  - genre: obligatoire, et la valeur donné doit être parmis les valeurs suivante: ['masculin', 'féminin', 'mixte']
     *  - Les autres champs sont falcultatifs.
     *
     * @return array
     */

    public $validationMessages;

    public function validationRules() {
        return [
            'nom' => 'required',
            'genre' => 'in:masculin,féminin,mixte',
            ];
    }
}