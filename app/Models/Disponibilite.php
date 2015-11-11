<?php
/**
 * La classe Disponibilité
 * 
 * 
 * @author dada
 * @version 0.1
 */

namespace App\Models;

class Disponibilite extends EloquentValidating implements \MaddHatter\LaravelFullcalendar\Event
{
    protected $guarded = array('id');

    public function benevoleId() {
	    return $this->belongsTo('Benevole');
    }

    public function validationRules() {
	    return [
		    'benevole_id' => 'required|int',
            'start' => 'required|date',
     		'end' => 'required|date',
		    ];
    }

    protected $dates = ['start', 'end'];

    /**
     * Get the event's id number
     *
     * @return int
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Get the event's title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Is it an all day event?
     *
     * @return bool
     */
    public function isAllDay()
    {
        return (bool)$this->all_day;
    }

    /**
     * Get the start time
     *
     * @return DateTime
     */
    public function getStart()
    {
        return $this->start;
    }

    /**
     * Get the end time
     *
     * @return DateTime
     */
    public function getEnd()
    {
        return $this->end;
    }
}
