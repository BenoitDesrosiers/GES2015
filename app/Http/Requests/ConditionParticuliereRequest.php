<?php

namespace App\Http\Requests;

use Auth;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class ConditionParticuliereRequest
 *
 * Classe pour une requête HTTP pour l'ajout/modification
 * d'une condition particulière.
 *
 * @author Res260
 * @created_at 164227
 * @modified_at 164227
 */
class ConditionParticuliereRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool True si l'utilisateur est connecté.
     */
    public function authorize()
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array Les règles de validation.
     */
    public function rules()
    {
		return [
			'nom' => 'string|required|unique:conditions_particulieres|min:1',
			'description' => 'string'
		];
    }
}
