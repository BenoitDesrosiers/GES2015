<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CafeteriaRequest extends FormRequest
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
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'nom' => 'required',
            'adresse' => 'required',
            'localisation' => 'required',
            'responsable.*.nom' => 'required',
            'responsable.*.telephone' => 'required|est_numero_telephone',
        ];
    }

    /**
     * @return array
     */
    public function messages()
    {
        return [
            'responsable.*.nom.required' => 'Tous les champs noms doivent être remplis',
            'responsable.*.telephone.required' => 'Tous les champs téléphones doivent être remplis',
            'responsable.*.telephone.est_numero_telephone' => 'Un des champs téléphones est invalides'
        ];
    }
}
