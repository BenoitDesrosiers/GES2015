<?php

namespace App\Http\Controllers;
use View;
use App\Http\Controllers\BaseController;

/**
 * Le controller pour la page 'About'.
 * 
 * @author IMFUZZ
 * @version 0.1
 */
class AboutController extends BaseController {
    /**
     * Page 'About' qui affiche la liste des personnes 
     * qui ont participé à la conception du système.
     *  
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $liste_etudiants = array(
            2014 => array(
                array(
                    "François Allard",
                    "À conçu la base du système!"
                )
                ),
            2015 => array(
                array(
                    "Daniel-Junior Dubé",
                    "À été ben sympathique.."
                ),
                array(
                    "Benoit Desrosiers",
                    "Est ben épuisé des corrections"
                )
                )
            );
        return View::make('about', compact('liste_etudiants'));
    }
}
