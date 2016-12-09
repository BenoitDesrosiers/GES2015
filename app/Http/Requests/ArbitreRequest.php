<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ArbitreRequest extends FormRequest
{
    /**
     * Détermine si l'usager peut faire la requête
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Les règles de validations d'un arbitre
     *
     * @return array
     */
    public function rules()
    {
        return [
            'nom' => 'required|string',
            'prenom' => 'required|string',
            'region_id' => 'required|integer',
            'numero_accreditation' => 'required|string',
            'association' => 'required|string',
            'sexe' => 'required|boolean',
            'adresse' => 'string',
            'date_naissance' => 'date'
        ];
    }
}
