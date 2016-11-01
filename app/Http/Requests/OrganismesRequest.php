<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrganismesRequest extends FormRequest
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
            'nomOrganisme' => 'required|string|max:30',
            'telephone' => 'regex:^(\+\d{1,2}\s)?\(?\d{3}\)?[\s.-]\d{3}[\s.-]\d{4}$^',
            'description' => 'string|max:50'
        ];
    }
}
