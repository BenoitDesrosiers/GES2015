<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ArbitreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Validation
     *
     * Un arbitre doit avoir:
     *  - nom, prenom, region_id, numero_accreditation, association, numero_telephone et sexe
     *  - Les autres champs sont falcultatifs.
     */
    public function rules()
    {
        return [
            'nom' => 'required|string',
            'prenom' => 'required|string',
            'region_id' => 'required|integer',
            'numero_accreditation' => 'required|string',
            'association' => 'required|string',
            'numero_telephone' => 'required|string',
            'sexe' => 'required|boolean',
            'adresse' => 'string',
            'date_naissance' => 'date'
        ];
    }
}
