<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EvenementsRequest extends FormRequest
{
    /**
     * Determiner si l'utilisateur est autorisé à faire la requête.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Trouver les règles de validation pour la requête
     *
     * @return array
     */
    public function rules()
    {
        return [
            'nom' => 'required',
            'date' => array('required', 'regex:/^\d{4}\-(0?[1-9]|1[012])\-(0?[1-9]|[12][0-9]|3[01])$/'),
            'heure' => array('required', 'regex:/^([0-9]|0[0-9]|1[0-9]|2[0-3]):[0-5][0-9]$/'),
            'type_id' => 'required',
            'epreuve_id' => 'required'
        ];
    }
}
