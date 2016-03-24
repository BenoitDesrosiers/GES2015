<?php

namespace App\Http\Callbacks;

class DisponibilitesCallback extends Callback{

    /**
     * Retourne la string pour le callback du select
     *
     * @param  int  $id l'id du de la disponibilité
     * @param  calendar  $calendrier le calendrier à modifier
     * @return string
     */
    public function getSelectCallback() {
	    return "function(start, end) {
		    $('#create-title').val('');
		    $('#create-allDay').prop('checked', false);
            $('#create-start').prop('disabled', false);
            $('#create-end').prop('disabled', false);
		    $('#create-start').val(start.format('YYYY-MM-DD hh:mm:ss'));

		    if (end._ambigTime) {
			    end.subtract(1, 'days');
		    }

		    $('#create-end').val(end.format('YYYY-MM-DD hh:mm:ss'));
		    $('#create').modal('show');
	    }";
	    // DEPRECATED
        /*return "function(start, end) {
            var title = prompt('Commentaire (optionnel) :');

            if (title === null) return;
            if (start._ambigTime) {
                var time = prompt('Heure début - (format HH:MM) :');
                if (time === null) return; //Appui sur annuler
                time = moment.duration(time);
                while (!moment.isDuration(time) || (moment.isDuration(time) && time._milliseconds < 0)) {
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
                while (!moment.isDuration(time) || (moment.isDuration(time) && (time._milliseconds <= start.time() || time._milliseconds > 86400000))) {
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

        }";*/
    }

    /**
     * Retourne la string pour le callback du click
     *
     * @param  calendar $calendrier le calendrier à modifier
     * @return string
     */
    public function getClickCallback() {
        return "function(calEvent, jsEvent, view) {
        	$('#delete-title').text('Supprimer '+calEvent.title+'?');
		    $('#delete').attr('data-id', calEvent._id);
            $('#delete').modal('show');
        }";
	    // DEPRECATED
        /*return "function(calEvent, jsEvent, view) {
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
        }";*/
    }

    /**
     * Retourne la string pour le callback du drop
     *
     * @param  calendar $calendrier le calendrier à modifier
     * @return string
     */
    public function getDropCallback() {
        return "function(event, delta, revertFunc, jsEvent, ui, view) {
            $.ajax({
                type: 'POST',
                url: '" . action('DisponibilitesController@update') . "',
                data: {  _token : $('meta[name=\"csrf-token\"]').attr('content'),
                    id: event.id,
                    allDay: event.allDay,
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
    public function getEventResizeCallback() {
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

