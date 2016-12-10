<?php
/**
 * Un organisme est un titre ayant des informations donné à un groupe de contacts et
 * qui aidera les utilisateurs du site à trouver un numéro de téléphone important.
 * 
 * Exemples des organismes: 
 * - Urgence
 * - Pizzeria
 * - Entretien
 * 
 * 
 * @author ettdro
 * @version 1
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    public $table = "contacts";

    protected $guarded = array('id');

    protected $fillable = ['prenom', 'nom', 'telephone', 'role'];

    public function organisme()
    {
    	return $this->belongsTo('App\Models\Organisme');
    }
}
