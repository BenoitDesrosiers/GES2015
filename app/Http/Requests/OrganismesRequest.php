<?php
// Classe servant à vérifier les champs entrés dans la vue.

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrganismesRequest extends FormRequest
{
    /**
     * Determine si l'utilisateur est autorisé à effectuer les requêtes.
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
            'nomOrganisme' => 'required|string|max:30',
            'description' => 'string|max:50'
        ];
    }
}
