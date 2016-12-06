/******************************************************************************
 * Fichier: evenements_index.js
 *
 * Description: Script qui gère le tri des événements par sport
 *
 * Créé le: 161129
 * Modifié le: 161129
 * Par: ZeLarpMaster
 ******************************************************************************/

// Vue ayant effet sur la liste d'événements
var vueListeEvenements = new Vue({
	el: "#liste_evenements",
	data: {
		listeEvenements: [],
		colonneTriee: "nom_sport",
		direction: 1
	},
	methods: {
		/**
		 * Méthode qui inverse l'état de `direction`
		 */
		toggleInverse: function () {
			this.direction = -this.direction;
		}
	},
	computed: {
		/**
		 * Trie selon la colonne `colonneTriee` dans la `direction`
		 * @returns {Array} La liste d'événements triée
		 */
		filteredData: function () {
			var colonneTriee = this.colonneTriee;
			var donnees = this.listeEvenements;
			var direction = this.direction;
			if (colonneTriee) {
				donnees.sort(function (a, b) {
					a = a[colonneTriee];
					b = b[colonneTriee];
					return (a === b ? 0 : a > b ? 1 : -1) * direction;
				});
			}
			return donnees;
		}
	}
});

// Requête AJAX qui obtient la liste d'événements
$.ajax({
	method: "GET",
	url: "/get_liste_evenements"
}).done(function(evenements) {
	vueListeEvenements.listeEvenements = evenements;
});

/**
 * Demande à l'utilisateur de confirmer la suppression d'un élément
 * @return {boolean} Si oui ou non la suppression a été confirmée
 */
function confirmDelete() {
	return confirm('Êtes-vous certain?');
}
