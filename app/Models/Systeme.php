<?php

 
class Systeme extends EloquentValidating
{
    
	protected $table = 'infos_events';


	public $validationMessages;

	public function validationRules() {
		return 
			[
			'nomEvenement' => 'required',
			];
	}
}

