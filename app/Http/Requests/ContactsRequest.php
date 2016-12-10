<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactsRequest extends FormRequest
{
    /**
     * Determine si l'utilisateur est autorisé à faire cette requête.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Les règles à vérifier lorsqu'on créer ou modifie un organisme.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'prenom' => 'required',
            'nom' => 'required',
            'telephone' => 'required',
            'role' => 'required',
        ];
    }
}
