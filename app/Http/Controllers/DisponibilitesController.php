<?php
namespace App\Http\Controllers;

use App\Http\Controllers\BaseController;
use View;
use Redirect;
use Input;
use DateTime;

use App\Models\Disponibilite;
use App\Models\Benevole;
use Request;
use Response;


use Illuminate\Database\Eloquent\ModelNotFoundException;

/**
 * Le controller pour les disponibilités
 *
 * @author dada
 * @author Steve D.
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
		//Fonction index non-d<C3><A9>finie.
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
	 * Enregistre les disponibilités dans la BD ou retourne un message d'erreur.
	 * @param $benevole Benevole Le bénévole crée.
	 * @return Response
	 */
	public static function store($benevole)
	{
		try {
			$input = Input::all();
			$disponibilites = DisponibilitesController::construireListeDisponibilites($input);
		
			//Sauvegarde toutes les disponibilités. Si erreur, retourne un message d'erreur.
			foreach($disponibilites as $disponibilite) {
				// sauvegarderDisponibilite() retourne true s'il n'y a pas
				// de disponibilité ou si l'insertion s'est bien passée.
				if(!DisponibilitesController::sauvegarderDisponibilite($disponibilite, $benevole)) {
					return Redirect::back()->withInput()->withErrors($disponibilite->validationMessages());
				}
			}
		} catch(ModelNotFoundException $e) {
			$response = array(
					'status' => 'fail',
					'msg' => 'Impossible de créer la disponibilité.',);
		}

		//Ancien code difficile à utiliser par l'usager et qui fini par un bogue.
		/*if(Request::ajax()) {
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
		 }*/
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
					/* 'select' => $this->getSelectCallback($id, $calendrier),*/
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

	/**
	 * Retourne la liste des disponibilités selon $input.
	 *
	 * @param $input array Les valeurs entrées par l'utilisateur.
	 * @return $disponibilites array[Disponibilite] La liste des disponibilités entrés par l'utilisateur.
	 */
	public static function construireListeDisponibilites($input)
	{
		$disponibilites = [];
		$i = 0;
		// Tant qu'il y a des entrées de disponibilité à ajouter, on boucle et on ajoute à la liste.
		while ($i == count($disponibilites)) {
			array_push($disponibilites, DisponibilitesController::construireDisponibilite($input, $i));
			if(array_last($disponibilites)) {
				$i++;
			}
		}
		// Le dernier élément sera toujours null.
		array_pop($disponibilites);

		return $disponibilites;
	}

	/**
	 * Construit et retourne la disponibilité entrée par l'utilisateur.
	 * Si aucune disponibilité n'est spécifiée, retourne null.
	 *
	 * @param $input array Les valeurs entrées par l'utilisateur.
	 * @param $index int L'index à aller chercher.
	 * @return $return_value Disponibilite L'objet de disponibilité à ajouter, ou null.
	 */
	public static function construireDisponibilite($input, $index)
	{
		$disponibilite = New Disponibilite;
		 
		//On attribue d'abord le titre et la date pour les vérifier en premier.
		$title = isset($input['disponibilite_disponibilite'][$index])? $input['disponibilite_disponibilite'][$index]: null;
		$annee = isset($input['disponibilite_annee'][$index]) ? $input['disponibilite_annee'][$index] : null;
		$mois = isset($input['disponibilite_mois'][$index]) ? $input['disponibilite_mois'][$index] : null;
		$jour = isset($input['disponibilite_jour'][$index]) ? $input['disponibilite_jour'][$index] : null;
		 
		/*La partie toute la journée ne fait que boguer.
		//On vérifie si l'option «isAllDay» est cochée ou non.
		if(isset($input['disponibilite_isAllDay'][$index])) {
			$isAllDay = "1";	//Cochée
		} else {
			$isAllDay = "0";	//Non cochée
		}*/
		 
		//On vérifie si la date est correcte.
		if (checkdate((int)$mois, (int)$jour, (int)$annee)) {

			/*if ($isAllDay == 1) {
				//Heure de début et de fin de toute une journée.
				$heureDebut = "08";
				$minuteDebut = "00";
				$heureFin = "17";
				$minuteFin = "30";
				//Puisque ce n'est pas toute la journée, on prend les heures entrées.
			} else {*/
				$heureDebut = isset($input['disponibilite_debut_heure'][$index]) ? $input['disponibilite_debut_heure'][$index] : null;
				$minuteDebut = isset($input['disponibilite_debut_minute'][$index]) ? $input['disponibilite_debut_minute'][$index] : null;
				$heureFin = isset($input['disponibilite_fin_heure'][$index]) ? $input['disponibilite_fin_heure'][$index] : null;
				$minuteFin = isset($input['disponibilite_fin_minute'][$index]) ? $input['disponibilite_fin_minute'][$index] : null;
			/*}*/

			//Si ce n'est pas toute la journée, l'usager n'a peut-être rien entré,
			// on doit s'assurer d'avoir des heures à entrer.
			if(strval($heureDebut) != "" AND strval($minuteDebut) != "" AND strval($heureFin) != ""
					AND strval($minuteFin) != "") {
							
					$dateDebut = new DateTime($annee."-".$mois."-".$jour." ".$heureDebut.":".$minuteDebut.":00");
					$dateFin = new DateTime($annee."-".$mois."-".$jour." ".$heureFin.":".$minuteFin.":00");
					 
					//On vérifie que l'heure de début est plus petite que l'heure de fin.
					if ( (int)$heureDebut < (int)$heureFin OR
							((int)$heureDebut = (int)$heureFin AND (int)$minuteDebut < (int)$minuteFin) ) {
								//Une fois que tout est correct, on attribue les colonnes d'une disponibilité.
								$disponibilite->title = $title;
								/*$disponibilite->isAllDay = $isAllDay;*/
								$disponibilite->start=$dateDebut;
								$disponibilite->end=$dateFin;
								
					/*J'ai essayé un retour en arrière avec un message, mais ça ne fonctionne pas.*/
					/*Il part dans une boucle sans fin.*/
					} /*else {
						return Redirect::back()->withInput()
							->withErrors('Erreur dans la date de la disponibilité');
					}*/
			} /*else {
					return Redirect::back()->withInput()
						->withErrors('Erreur dans la date de la disponibilité');
					}*/
		} /*else {
				return Redirect::back()->withInput()
					->withErrors('Erreur dans la date de la disponibilité');*/
		 
		//Si le titre est null, c'est qu'il a eu une erreur, on envoie donc null plutôt qu'une disponibilité erronée.
		$return_value = $disponibilite->title ? $disponibilite : null;
		 
		return $return_value;
	}

	/**
	 * Sauvegarder $disponibilite de $benevole dans la BD.
	 *
	 * @param $disponibilite Disponibilite|void L'objet de disponibilité à sauvegarder.
	 * @param $benevole Benevole Le bénévole à qui la disponibilité appartient.
	 * @return bool True si la sauvegarde a fonctionné, false sinon.
	 */
	public static function sauvegarderDisponibilite($disponibilite, $benevole)
	{
		// Null si il la disponibilité n'a pas été spécifiée.
		if($disponibilite) {
			$disponibilite->benevole()->associate($benevole);
			if (!$disponibilite->save()) {
				return false;
			}
		}
		return true;
	}

}
