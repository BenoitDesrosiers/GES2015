<?php
namespace App\Http\Controllers;

use App\Http\Controllers\BaseController;
use View;
use Redirect;
use Input;

use App\Models\Disponibilite;
use App\Models\Benevole;

use Illuminate\Database\Eloquent\ModelNotFoundException;
/**
 * Le controller pour les disponibilités
 * 
 * @author dada
 * @version 0.1
 */
class DisponibilitesController extends BaseController {

	/**
	 * Affiche le formulaire de création de la ressource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Enregistre dans la bd la ressource qui vient d'être créée.
	 *
	 * @return Response
	 */
	public function store()
	{
		$input = Input::all();
		
		$disponibilite = new Disponibilite;
        $disponibilite->benevole_id = $input['benevole_id'];
        $disponibilite->title = $input['title'];
		$disponibilite->isAllDay = $input['isAllDay'];
		$disponibilite->start = $input['start'];
		$disponibilite->end = $input['end'];
        
		if($disponibilite->save()) {
			return Redirect::action('BenevolesController@index');
		} else {
			return Redirect::back()->withInput()->withErrors($benevole->validationMessages());
		}	
	}


	/**
	 * Affiche la ressource.
	 *
	 * @param  int  $id l'id du bénévole à afficher
	 * @return Response
	 */
	public function show($id)
	{
		try {
			$benevole = Benevole::findOrFail($id);
			$disponibilites = [];
            $disponibilites[] = \Calendar::event(
                'Event One',
                false,
                '2015-02-11T0800',
                '2015-02-12T0800'
            );
            $disponibilites[] = \Calendar::event(
                "Valentine's Day",
                true,
                new \DateTime('2015-02-14'),
                new \DateTime('2015-02-14')
            );
            //$disponibilites = $benevole->disponibilites();
            $calendrier = \Calendar::addEvents($disponibilites)->setOptions(['editable' => true, 'eventLimit' => true]);
		} catch(ModelNotFoundException $e) {
			App::abort(404);
		}
		return View::make('disponibilites.show', compact('benevole', 'calendrier'));
	}


	/**
	 * Affiche le formulaire pour éditer la ressource.
	 *
	 * @param  int  $id l'id du bénévole à éditer 
	 * @return Response
	 */
	public function edit($id)
	{
        //
	}


	/**
	 * Mise à jour de la ressource dans la bd.
	 *
	 * @param  int  $id l'id du bénévole à changer.
	 * @return Response
	 */
	public function update($id)
	{
		//
	}


	/**
	 * Efface la ressource de la bd.
	 *
	 * @param  int  $id l'id du benevole à effacer
	 * @return Response
	 */
	public function destroy($id)
	{
        //
	}


}
