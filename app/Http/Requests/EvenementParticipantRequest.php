<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EvenementParticipantRequest extends FormRequest
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
            'evenement' => 'required|integer',
            'participation' => 'array|nullable'
        ];
    }
}
