<?php

namespace App\Http\Requests;

use App\Models\Role;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreUsager extends FormRequest
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
     * La regex du mot de passe est:
     *      - Minimum 1 chiffre [0-9]
     *      - Minimum 1 caractère minuscule [a-z]
     *      - Minimum 1 caractère majuscule [A-Z]
     *
     * @return array
     */
    public function rules()
    {
        return [
            'nom' => 'required|max:255',
            'courriel' => 'unique:users,email,'.Auth::id().'|required|max:255',
            'mot_de_passe' => 'min:6|max:60|regex:/^(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])([a-zA-Z0-9]+)$/',
            'role.*' => 'exists:roles,name'
        ];
    }

    /**
     * @return array
     */
    public function messages()
    {
        return [
            'courriel.unique' => 'Le courriel déjà utilisé.',
            'mot_de_passe.min' => 'Mauvais mot de passe! Longueur minimum: 6',
            'mot_de_passe.max' => 'Mauvais mot de passe! Longueur maximum: 60',
            'mot_de_passe.regex' => 'Mauvais mot de passe! Au minimum: Une lettre minuscule, une lettre majuscule et un chiffre minimum.'
        ];
    }
}
