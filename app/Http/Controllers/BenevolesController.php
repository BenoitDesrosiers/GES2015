<?php
namespace App\Http\Controllers;

use App\Http\Controllers\BaseController;
use View;
use Redirect;
use Input;

use App\Models\Benevole;
use App\Models\Disponibilite;
use Request;
use Response;

use Illuminate\Database\Eloquent\ModelNotFoundException;
/**
 * Le controller pour les bénévoles
 * 
 * @author dada
 * @version 0.1
 */
class BenevolesController extends BaseController {

	/**
	 * Affiche une liste de ressource.
	 *
	 * @return Response
	 */
	public function index()
	{
        try {
		    $benevoles = Benevole::all();
		} catch(ModelNotFoundException $e) {
			App::abort(404);
		}
		return View::make('benevoles.index', compact('benevoles'));
		
	}


	/**
	 * Affiche le formulaire de création de la ressource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('benevoles.create');	
	}


	/**
	 * Enregistre dans la bd la ressource qui vient d'être créée.
	 *
	 * @return Response
	 */
	public function store()
	{
        $input = Input::all();
        		
		$benevole = new Benevole;
        $benevole->prenom = $input['prenom'];
		$benevole->nom = $input['nom'];
		$benevole->adresse = $input['adresse'];
		$benevole->numTel = $input['numTel'];
        $benevole->numCell = $input['numCell'];
        $benevole->courriel = $input['courriel'];
		$benevole->accreditation = $input['accreditation'];
		$benevole->verification = $input['verification'];
		
		if($benevole->save()) {
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
		} catch(ModelNotFoundException $e) {
			App::abort(404);
		}
		return View::make('benevoles.show', compact('benevole'));
	}

    /**
	 * Affiche la ressource.
	 *
	 * @param  int  $id l'id du bénévole pour lequel on veut afficher
     * ses disponibilités.
	 * @return Response
	 */
    public function showDisponibilites($id)
    {
        try {
			$benevole = Benevole::findOrFail($id);
			$disponibilites = $benevole->disponibilites;
            $calendrier = \Calendar::addEvents($disponibilites)->setOptions(['editable' => false, 'eventLimit' => true]);
		} catch(ModelNotFoundException $e) {
			App::abort(404);
		}
		return View::make('benevoles.showDisponibilites', compact('benevole', 'calendrier'));
    }

	/**
	 * Affiche le formulaire pour éditer la ressource.
	 *
	 * @param  int  $id l'id du bénévole à éditer 
	 * @return Response
	 */
	public function edit($id)
	{
        try{
		    $benevole = Benevole::findOrFail($id);
        } catch(ModelNotFoundException $e) {
            App::abort(404);
        }
		return View::make('benevoles.edit', compact('benevole'));
	}

    /**
	 * Affiche le formulaire pour éditer la ressource.
	 *
	 * @param  int  $id l'id du bénévole pour lequelle on veut éditer
     * ses disponibilités. 
	 * @return Response
	 */
	public function editDisponibilites($id)
	{
        try{
		    $benevole = Benevole::findOrFail($id);
			$disponibilites = $benevole->disponibilites;

            $calendrier = \Calendar::addEvents($disponibilites)
                ->setOptions([
                    'editable' => true,
                    'eventLimit' => true,
                    'selectable' => true,
                    'selectableHelper' => false,
                    'displayEventTime' => true,
                    'displayEventEnd' => true
                ]);
            $calendrier->setCallbacks([
                    'select' => "function(start, end) {
                        var title = prompt('Event Title');
                        var eventData;

                        if(title){
                            eventData = {
                                title: title,
                                start: start,
                                end: end
                            };
                            $('#calendar-" . $calendrier->getId() ."').fullCalendar('renderEvent', eventData, true);
                        }
                        $('#calendar-" . $calendrier->getId() ."').fullCalendar('unselect');                                            
                        $.ajax({
			                type: 'POST',
			                url: '" . action('BenevolesController@editDisponibilitesSave') . "',
                            data: {  _token : $('meta[name=\"csrf-token\"]').attr('content'),
                                benevole_id: " . $id . ",
                                title: title,
                                start: new Date(start),
                                end: new Date(end),
                                backgroundColor: '#80ACED'
                                },
			                timeout: 10000,
			                success: function(data){
                                if(data.status == \"fail\"){
                                    alert(data.msg);
                                };
				            },
                            error: function(data){
                                alert('Le serveur ne répond pas.');
                            }
		                });

                    }",
                    'eventClick' => "function(calEvent, jsEvent, view) {

                            alert('Voulez-vous vraiment supprimer cette événement?');

                            // change the border color just for fun
                            $(this).css('border-color', 'red');

                        }"
                ]); 

        } catch(ModelNotFoundException $e) {
            App::abort(404);
        }
		return View::make('benevoles.editDisponibilites', compact('benevole', 'calendrier'));
	}

    /**
     * Fonction du gars de NMédia :
     * eventRender : function(event, elem){
     * elem.append($('<span>x</span>').css({ display: 'inline-block' }).click(function(){alert('coucou');}));
     */

    /**
	 * Enregistre dans la BD sur le serveur et affiche un message d'erreur si ça plante.
	 *
	 * @param  int  $id l'id du bénévole pour lequelle on veut éditer
     * ses disponibilités. 
	 * @return Response
	 */
    public function editDisponibilitesSave()
	{        
        
        if(Request::ajax()) {
            $input = Input::all();
            //print_r($input);die;
		    try {
			    $benevole = Benevole::findOrFail($input['benevole_id']); 
		    } catch (ModelNotFoundException $e) {
			    $response = array(
                    'status' => 'fail',
                    'msg' => 'fail1',
                );
                return $response;
		    }
            
		    $disponibilite = new Disponibilite;
            $disponibilite->benevole_id = $input['benevole_id'];
	        $disponibilite->title = $input['title'];
	        //$disponibilite->isAllDay = $input['isAllDay'];
	        $disponibilite->start = strtotime($input['start']);
            $disponibilite->end = strtotime($input['end']);
            if($disponibilite->save()) {
		        $response = array(
                    'status' => 'success',
                    'msg' => 'Setting created successfully',
                );
                return $response;
	        } else {
		        $response = array(
                    'status' => 'fail',
                    'msg' => 'fail2',
                );
                return $response;
	        }
	    } else {
		    return App::abort(404);
	    }
	}

	/**
	 * Mise à jour de la ressource dans la bd.
	 *
	 * @param  int  $id l'id du bénévole à changer.
	 * @return Response
	 */
	public function update($id)
	{
		$input = Input::all();
		
		$benevole = Benevole::findOrFail($id);
		$benevole->nom = $input['prenom'];
        $benevole->nom = $input['nom'];
		$benevole->adresse = $input['adresse'];
		$benevole->numTel = $input['numTel'];
        $benevole->numCell = $input['numCell'];
        $benevole->courriel = $input['courriel'];
		$benevole->accreditation = $input['accreditaiton'];
		$benevole->verification = $input['verification'];
		
		if($benevole->save()) {
			return Redirect::action('BenevolesController@index');
		} else {
			return Redirect::back()->withInput()->withErrors($benevole->validationMessages());
		}
	}


	/**
	 * Efface la ressource de la bd.
	 *
	 * @param  int  $id l'id du benevole à effacer
	 * @return Response
	 */
	public function destroy($id)
	{
        try{
		    $benevole = Benevole::findOrFail($id);
		    $benevole->delete();
		 } catch(ModelNotFoundException $e) {
            App::abort(404);
        }
		return Redirect::action('BenevolesController@index');
	
	}


}
