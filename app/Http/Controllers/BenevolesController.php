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
                    'selectable' => true,
                    'displayEventTime' => true,
                    'displayEventEnd' => true,
                    'dragOpacity' => '.50',
                    'lang' => 'fr'
                ]);
            $calendrier->setCallbacks([
                    'select' => $this->getSelectCallback($id, $calendrier),
                    'eventClick' => $this->getClickCallback($calendrier),
                    'eventDrop' => $this->getDropCallback($calendrier),
                    'eventResize' => $this->getEventResizeCallback($calendrier)
                ]); 

        } catch(ModelNotFoundException $e) {
            App::abort(404);
        }
		return View::make('benevoles.editDisponibilites', compact('benevole', 'calendrier'));
	}

    /**
	 * Enregistre dans la BD sur le serveur et affiche un message d'erreur si ça plante.
	 *
	 * @param  int  $id l'id du bénévole pour lequelle on veut éditer
     * ses disponibilités. 
	 * @return Response
	 */
    public function createDisponibilitesSave()
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
                    'id' => $disponibilite->getId()
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

    public function editDisponibilitesSave()
	{        
        
        if(Request::ajax()) {
            
            $input = Input::all();
            
		    $disponibilite = Disponibilite::findOrFail($input['id']);

            if (isset($input['benevole_id'])) {
		        try {
			        $benevole = Benevole::findOrFail($input['benevole_id']); 
                    $disponibilite->benevole_id = $input['benevole_id'];
		        } catch (ModelNotFoundException $e) {
			        $response = array(
                        'status' => 'fail',
                        'msg' => 'fail1',
                    );
                    return $response;
		        }
            }
            
            if (isset($input['title'])) {
	            $disponibilite->title = $input['title'];
            }

	        //$disponibilite->isAllDay = $input['isAllDay'];

            if (isset($input['start'])) {
	            $disponibilite->start = strtotime($input['start']);
            }
            
            if (isset($input['end'])) {
                $disponibilite->end = strtotime($input['end']);
            }
           
            if ($disponibilite->save()) {
		        $response = array(
                    'status' => 'success',
                    'msg' => 'Setting created successfully'
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

    /**
     * Efface la dispo
     *
     * @param int $id dispo
     * @return respond
     */
    public function destroyDisponibilites()
	{
        if(Request::ajax()) {
            $input = Input::all();
            //print_r($input);die;
		    try {
			    $disponibilite = Disponibilite::findOrFail($input['id']); 
		    } catch (ModelNotFoundException $e) {
			    $response = array(
                    'status' => 'fail',
                    'msg' => 'fail1',
                );
                return $response;
		    }
            if($disponibilite->delete()) {
		        $response = array(
                    'status' => 'success',
                    'msg' => 'delete successfully',
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
	 * Retourne la string pour le callback du Select
	 *
	 * @param  int  $id l'id du de la dispo et calendar $calendrier le calendrier à modifier
	 * @return string
	 */
    private function getSelectCallback($id, $calendrier) {
        return "function(start, end) {
            var title = prompt('Titre de l\'événement :');
                                                       
            $.ajax({
                type: 'POST',
                url: '" . action('BenevolesController@createDisponibilitesSave') . "',
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
                    }else{
                        var eventData;

                        if(title){
                            eventData = {
                                id: data.id,
                                title: title,
                                start: start,
                                end: end
                            };
                            $('#calendar-" . $calendrier->getId() ."').fullCalendar('renderEvent', eventData, true);
                        }
                        $('#calendar-" . $calendrier->getId() ."').fullCalendar('unselect'); 
                       
                    };
	            },
                error: function(data){
                    alert('Le serveur ne répond pas onselect.');
                }
            });

        }";
    }

    /**
	 * Retourne la string pour le callback du Click
	 *
	 * @param  calendar $calendrier le calendrier à modifier
	 * @return string
	 */
    private function getClickCallback($calendrier) {
        return "function(calEvent, jsEvent, view) {
            var r=confirm(\"Supprimer \" + calEvent.title + \" : \");
            if (r===true) {
                $('#calendar-" . $calendrier->getId() ."').fullCalendar('removeEvents', calEvent._id);
            }
            $.ajax({
                type: 'POST',
                url: '" . action('BenevolesController@destroyDisponibilites') . "',
                data: {  _token : $('meta[name=\"csrf-token\"]').attr('content'),
                    id: calEvent._id
                    },
                timeout: 10000,
                success: function(data){
                    if(data.status == \"fail\"){
                        alert(data.msg);
                    };
	            },
                error: function(data){
                    alert('Le serveur ne répond pas onclic.');
                }
            });
        }";
    }

    /**
	 * Retourne la string pour le callback du Drop
	 *
	 * @param  calendar $calendrier le calendrier à modifier
	 * @return string
	 */
    private function getDropCallback($calendrier) {
        return "function(event, delta, revertFunc, jsEvent, ui, view) {
            $.ajax({
                type: 'POST',
                url: '" . action('BenevolesController@editDisponibilitesSave') . "',
                data: {  _token : $('meta[name=\"csrf-token\"]').attr('content'),
                    id: event.id,
                    start: new Date(event.start),
                    end: new Date(event.end)
                },
                timeout: 10000,
                success: function(data){
                    if(data.status == \"fail\"){
                        alert(data.msg);
                    } else {
                        $('#calendar-" . $calendrier->getId() ."').fullCalendar('unselect'); 
                    }
	            },
                error: function(data){
                    alert('Le serveur ne répond pas on drop.');
                }
            });

        }";
     }

    /**
	 * Retourne la string pour le callback du Resize
	 *
	 * @param  calendar $calendrier le calendrier à modifier
	 * @return string
	 */
    private function getEventResizeCallback($calendrier) {
        return "function(event, delta, revertFunc, jsEvent, ui, view) {
            console.log(event);
            $.ajax({
                type: 'POST',
                url: '" . action('BenevolesController@editDisponibilitesSave') . "',
                data: {  _token : $('meta[name=\"csrf-token\"]').attr('content'),
                    id: event.id,
                    end: new Date(event.end)
                },
                timeout: 10000,
                success: function(data){
                    if(data.status == \"fail\"){
                        alert(data.msg);
                    } else {
                        $('#calendar-" . $calendrier->getId() ."').fullCalendar('unselect'); 
                    }
	            },
                error: function(data){
                    alert('Le serveur ne répond pas onresize.');
                }
            });

        }";
    }

}
