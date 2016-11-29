/******************************************************************************
 * Fichier: evenements_create.js
 *
 * Description: Script qui gère le dropdown des sports et des épreuves
 * Est inclus dans /evenements/create.blade.php.
 *
 * Créé le: 161129
 * Modifié le: 161129
 * Par: ZeLarpMaster
 ******************************************************************************/

var liste_evenements = new Vue({
	el: "#creation_evenement",
	data: {
		sports_epreuves: {},
		sport_selectionne: "",
		epreuves_selectionnees: []
	}
});

$.ajax({
	method: "GET",
	url: "/get_liste_sports"
}).done(function( evenements ) {
	liste_evenements.liste_evenements = evenements;
});
