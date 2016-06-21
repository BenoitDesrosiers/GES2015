<?php
namespace App\Http\Controllers;

use App\Http\Controllers\BaseController;
use View;
use Redirect;
use Input;

use App\Models\Disponibilite;
use App\Models\Benevole;
use Request;
use Response;


use Illuminate\Database\Eloquent\ModelNotFoundException;

/**
 * Le controller pour les disponibilités
 * 
 * @author dada
 * @version 0.1
 */
class DisponibilitesController extends BaseController {
    /**
	 * Étant donnée que l'affichage se passe toute dans un calendrier, la fonction
     * index m'apparait inutile pour le moment, toute fois il y aurait possibilité
     * de vouloir afficher les disponibilités autre que dans un calendrier.
	 */
	public function index()
	{
        //Fonction index non-définie.
    }

    /**
	 * Étant donnée que gestion se passe toute dans un calendrier, la fonction
     * create m'apparait inutile pour le moment, toute fois il y aurait possibilité
     * de vouloir créer les disponibilités à l'aide d'un formulaire.
	 */
	public function create()
	{
        //Fonction index non-définie.
	}

    /**
	 * Enregistre dans la BD sur le serveur et retourne le message d'erreur
     * approprié si ça plante.
	 *
	 * @return Response
	 */
    public function store()
	{        
        if(Request::ajax()) {
            try {
                $input = Input::all();
			    $benevole = Benevole::findOrFail($input['benevole_id']);
		        $disponibilite = new Disponibilite;
                $disponibilite->benevole_id = $input['benevole_id'];
	            $disponibilite->title = $input['title'];
	            $disponibilite->start = strtotime($input['start']);
                $disponibilite->end = strtotime($input['end']);
                if($disponibilite->save()) {
		            $response = array(
                        'status' => 'success',
                        'msg' => 'La disponibilité a été enregistrée avec succès.',
                        'id' => $disponibilite->getId(),
                        'start' => strtotime($input['start']),
                        'end' => strtotime($input['end']),
                    );
                }
	        } catch(ModelNotFoundException $e) {
		        $response = array(
                    'status' => 'fail',
                    'msg' => 'Impossible de créer la disponibilité.',
                );                
	        }
            return $response;
	    } else {
		    return App::abort(404);
	    }
	}

    /**
	 * Affiche les disponibilités dans un calendrier.
	 *
	 * @param  int  $id l'id du bénévole pour lequel on veut afficher
     * les disponibilités.
	 * @return Response
	 */
    public function show($id) 		
    {
        try {
			$benevole = Benevole::findOrFail($id);
			$disponibilites = $benevole->disponibilites;
            $calendrier = \Calendar::addEvents($disponibilites)
                ->setOptions([
                    'editable' => false,
                    'eventLimit' => true
                ]);
		} catch(ModelNotFoundException $e) {
			App::abort(404);
		}
		return View::make('disponibilites.show', compact('benevole', 'calendrier'));
    }

    /**
     * Modifie les disponibilités du bénévole sélectionné.
	 *
	 * @param  int  $id l'id du bénévole pour lequel on veut modifier
     * les disponibilités.
	 * @return View
     */
    public function edit($id)
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
		return View::make('disponibilites.edit', compact('benevole', 'calendrier'));
    }

    /**
	 * update les disponibilités dans la base de données pour le bénévole sélectionné.
	 *
	 * @return Response
	 */
    public function update()
	{        
        if(Request::ajax()) {
            
            try {
                $input = Input::all();
		        $disponibilite = Disponibilite::findOrFail($input['id']);
                if (isset($input['benevole_id'])) {
		            $benevole = Benevole::findOrFail($input['benevole_id']); 
                    $disponibilite->benevole_id = $input['benevole_id'];     
		            }
                if (isset($input['title'])) {
	                $disponibilite->title = $input['title'];
                }
                if (isset($input['start'])) {
	                $disponibilite->start = strtotime($input['start']);
                }
                if (isset($input['end'])) {
                    $disponibilite->end = strtotime($input['end']);
                }
                if ($disponibilite->save()) {
		            $response = array(
                        'status' => 'success',
                        'msg' => 'La disponibilité a été modifiée avec succès.'
                    );
                }
            } catch(ModelNotFoundException $e) {
	            $response = array(
                    'status' => 'fail',
                    'msg' => 'Impossible de modifier la disponibilité.',
                );
            }
            return $response;
	    } else {
		    return App::abort(404);
	    }
	}

    /**
     * Efface les disponibilités du bénévole sélectionné.
     *
     * @return respond
     */
    public function destroy()
	{
        if(Request::ajax()) {
            try {
                $input = Input::all();
			    $disponibilite = Disponibilite::findOrFail($input['id']); 
                if($disponibilite->delete()) {
		            $response = array(
                        'status' => 'success',
                        'msg' => 'La disponibilité a été supprimée avec succès.',
                    );
                }
            } catch (ModelNotFoundException $e) {
			    $response = array(
                    'status' => 'fail',
                    'msg' => 'Impossible de supprimer la disponibilté',
                );
            }
            return $response;
	    } else {
		    return App::abort(404);
	    }
	}

    /**
	 * Retourne la string pour le callback du select
	 *
	 * @param  int  $id l'id du de la disponibilité
     * @param  calendar  $calendrier le calendrier à modifier
	 * @return string
	 */
    private function getSelectCallback($id, $calendrier) {
        return "function(start, end) {
            var title = prompt('Commentaire (optionnel) :');

            if (title === null) return;
            if (start._ambigTime) {
                var time = prompt('Heure début - (format HH:MM) :');
                if (time === null) return; //Appui sur annuler
                time = moment.duration(time);
                while (!moment.isDuration(time) || (moment.isDuration(time) && time._milliseconds <= 0)) {
                    time = prompt('Invalide - (format HH:MM) - Recommencer :');
                    if (time === null) return;
                    time = moment.duration(time);
                }
                start.time(time);
            }
            if (end._ambigTime) {
                var time = prompt('Heure fin - (format HH:MM) :');
                if (time === null) return;
                time = moment.duration(time);
                while (!moment.isDuration(time) || (moment.isDuration(time) && time._milliseconds <= start.time())) {
                    time = prompt('Invalide - (format HH:MM et FIN>DÉBUT) - Recommencer :');
                    if (time === null) return;
                    time = moment.duration(time);
                }
                end.date(end.date()-1);
                end.time(time);
            }
                                                       
            $.ajax({
                type: 'POST',
                url: '" . action('DisponibilitesController@store') . "',
                data: {  _token : $('meta[name=\"csrf-token\"]').attr('content'),                
                    benevole_id: " . $id . ",
                    title: title,
                    start: new Date(start),
                    end: new Date(end)
                },
                timeout: 10000,
                success: function(data){
                    if(data.status == \"fail\"){
                        alert(data.msg);
                    }else{
                        var eventData;
                        eventData = {
                            id: data.id,
                            title: title,
                            start: start,
                            end: end
                        };
                        $('#calendar-" . $calendrier->getId() ."').fullCalendar('renderEvent', eventData, true);
                        $('#calendar-" . $calendrier->getId() ."').fullCalendar('unselect');
                    };                    
	            },
                error: function(data){
                    alert(data.msg);
                }
            });

        }";
    }

    /**
	 * Retourne la string pour le callback du click
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
                url: '" . action('DisponibilitesController@destroy') . "',
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
                    alert(data.msg);
                }
            });
        }";
    }

    /**
	 * Retourne la string pour le callback du drop
	 *
	 * @param  calendar $calendrier le calendrier à modifier
	 * @return string
	 */
    private function getDropCallback($calendrier) {
        return "function(event, delta, revertFunc, jsEvent, ui, view) {
            $.ajax({
                type: 'POST',
                url: '" . action('DisponibilitesController@update') . "',
                data: {  _token : $('meta[name=\"csrf-token\"]').attr('content'),
                    id: event.id,
                    start: new Date(event.start),
                    end: new Date(event.end)
                },
                timeout: 10000,
                success: function(data){
                    if(data.status == \"fail\"){
                        alert(data.msg);
                    };
	            },
                error: function(data){
                    alert(data.msg);
                }
            });

        }";
     }

    /**
	 * Retourne la string pour le callback du resize
	 *
	 * @param  calendar $calendrier le calendrier à modifier
	 * @return string
	 */
    private function getEventResizeCallback($calendrier) {
        return "function(event, delta, revertFunc, jsEvent, ui, view) {
            $.ajax({
                type: 'POST',
                url: '" . action('DisponibilitesController@update') . "',
                data: {  _token : $('meta[name=\"csrf-token\"]').attr('content'),
                    id: event.id,
                    end: new Date(event.end)
                },
                timeout: 10000,
                success: function(data){
                    if(data.status == \"fail\"){
                        alert(data.msg);
                    };
	            },
                error: function(data){
                    alert(data.msg);
                }
            });

        }";
    }

}
