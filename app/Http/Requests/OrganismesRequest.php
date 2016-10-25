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
            'telephone' => 'max:13|regex:/(819)([0-9]{3})([0-9]{3})/',
            'description' => 'string|max:50'
        ];
    }
}
