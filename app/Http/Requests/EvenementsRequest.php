<?php

namespace App\Http\Requests;

use Illuminate\Validation\Factory as ValidatorFactory;
use Illuminate\Foundation\Http\FormRequest;

class EvenementsRequest extends FormRequest
{
	public function validator(ValidatorFactory $factory) 
	{
		$date = $this->get('date');
		$heure = $this->get('heure');
		$date_heure = $date.' '.$heure;
		$this->merge(['date_heure' => $date_heure]);
		return $factory->make($this->input(), $this->rules(), $this->messages());
	}
	
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
            'nom' => 'required',
            'date' => array('required', 'regex:/^\d{4}\-(0?[1-9]|1[012])\-(0?[1-9]|[12][0-9]|3[01])$/'),
            'heure' => array('required', 'regex:/^([0-9]|0[0-9]|1[0-9]|2[0-3]):[0-5][0-9]$/'),
            'type_id' => 'required',
            'epreuve_id' => 'required',
        		/*La règle 'terrain_id' vérifie qu'aucun autre événement utilise 
        		le terrain au même moment, mais ignore les événements ayant le nom choisi.*/
        	'terrain_id' => 'nullable|unique:evenements,terrain_id,'.$this->get('nom').',nom,date_heure,'.$this->get('date_heure')
        ];
    }
    
    public function messages()
    {
    	return [
    		"terrain_id.unique" => "Le terrain sélectionné n'est pas disponnible pour cette date et heure."
    	];
    }
}
