<?php

namespace App\Http\Controllers;
use View;
use App\Http\Controllers\BaseController;

/**
 * Le controller pour les rôles.
 * 
 * @author SteveL
 * @version 0.1
 */
class AboutController extends BaseController {
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $liste_etudiants = array(
            2014 => array(
            	array(
            			"Benoit Desrosiers",
               			"Prof du cours 420-CN2-DM, design original du projet"
         	    ),
            	array(
            			"Guillaume Boudreau, Jaymz Latour, Cédric Lemire, Anthony Martel, Philippe Paquette, Marc-Antoine Renaud",
           				"Étudiants du cours à l'automne 2014 ayant développé une copie du projet."
           		),
                array(
                    "François Allard",
                    "Conception de la version originale du projet qui a été conservé pour les années suivantes."
                )
            ),
            2015 => array(
                
                
                array(
                    "David Brousseau",
                    "Ajout des bénévoles, calendrier des disponibilités des bénévoles "
                ),
                array(
                    "Éric Desautels-Brochu",
                    "Ajout de la page permettant de changer le nom de l'évènement, ajout des codes pour les résultats d'épreuves"
                ),
            	array(
            		"Daniel-Junior Dubé",
            		"Ajout de la page des terrains, de l'association des terrains aux sports, de la page de login, et de la page 'à propos'"
            	),
                array(
                    "Alexandre Girardin",
                    "Ajout de filtre dans l'index des participants, association des points aux positions pour un sport"
                ),
                array(
                    "Sarah Laflamme",
                    "Ajout des arbitres, association des arbitres aux sports "
                ),
                array(
                    "Steve Lehoux",
                    "Ajout des rôles des accompagnateurs, ajouts des membres de délégations "
                ),
                array(
                    "Mathieux Moreau-Plante",
                    "Affichage des participants associés à un sport, inscription des participants aux épreuves"
                ),
           		array(
       				"Jérémy Pedneault",
           			"Tri sur la page index des participants, association des arbitres aux épreuves"
            	),
            	array(
           			"Simon Truchon-Brouillette",
       				"Ajout d'information aux participants, association des participants aux équipes "
          		),
                array(
                    "Benoit Desrosiers",
                    "Gestion du projet"
                )
            ),
            2016 => array(
				array(
					"Alexandre Caron",
					"Association d'un sport à un participant à partir d'un sport"
				),

				array(
					"Émilio Gonzalez",
					"Ajout de plusieurs téléphones et adresses pour les participants (fini le 161101)."
				),
				
				array(
					"Steve Duquet",
					"Association de sports à un bénévole à partir d'un bénévole."
				),
				
				array(
					"Charles Lemay",
					"Association des terrains aux épreuves."
				),
				
				array(
					"Pascal Belisle",
					"Afficher les participants par région dans AjtParticipant."
				),

                array(
                    "Guillaume Hamel-Gagné",
                    "Ajout d'un sexe aux épreuves. Ajout d'un filtre lors de l’ajout de participants 
                    à une épreuve selon le sexe de l’épreuve et des participants."
                ),
            )
        );

        return View::make('about', compact('liste_etudiants'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
