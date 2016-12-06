/******************************************************************************
 * Fichier: evenements_create_edit.js
 *
 * Description: Script qui gère le dropdown des sports et des épreuves
 * Est inclus dans /evenements/create.blade.php et /evenements/edit.blade.php.
 *
 * Créé le: 161129
 * Modifié le: 161129
 * Par: ZeLarpMaster
 ******************************************************************************/

// Vue ayant effet sur la creation de l'événement
var vueEvenement = new Vue({
	el: "#vueEvenement",
	data: {
		sportsEpreuves: {},
		sportSelectionne: "",
		epreuveSelectionne: 0,
		epreuveParDefaut: 0
	},
	methods: {
		/**
		 * Définit l'épreuve et le sport sélectionnés par défaut
		 * @param {Number} epreuveId Le id de l'épreuve par défaut
		 * @returns null
		 */
		setEpreuveParDefaut: function (epreuveId) {
			for(var nomSport in this.sportsEpreuves) {
				var epreuves = this.sportsEpreuves[nomSport];
				for(var cleEpreuve in epreuves) {
					var epreuve = epreuves[cleEpreuve];
					if(epreuve.valeur == epreuveId) {
						this.sportSelectionne = nomSport;
						this.epreuveSelectionne = epreuve.valeur;
					}
				}
			}
		}
	},
	computed: {
		/**
		 * Retourne la liste d'épreuves disponibles selon le sport sélectionné
		 * @returns {Array} La liste d'épreuves
		 */
		listeEpreuves: function() {
			return this.sportsEpreuves[this.sportSelectionne];
		},
		/**
		 * Retourne une liste contenant le nom des sports existants
		 * @returns {Array} La liste de sports
		 */
		listeSports: function () {
			return Object.keys(this.sportsEpreuves);
		}
	}
});

// Requête AJAX pour obtenir la liste de sports et leurs épreuves
$.ajax({
	method: "GET",
	url: "/get_liste_sports"
}).done(function(sportsEpreuves) {
	vueEvenement.sportsEpreuves = sportsEpreuves;
	vueEvenement.sportSelectionne = vueEvenement.listeSports[0];
	vueEvenement.setEpreuveParDefaut(vueEvenement.epreuveParDefaut);
});
