/******************************************************************************
 * Fichier: evenements_index.js
 *
 * Description: Script qui gère le tri des événements par sport
 * Est inclus dans /evenements/index.blade.php.
 *
 * Créé le: 161129
 * Modifié le: 161129
 * Par: ZeLarpMaster
 ******************************************************************************/

var liste_evenements = new Vue({
	el: "#liste_evenements",
	data: {
		liste_evenements: [],
		sortKey: "nom_sport",
		inverse: 1
	},
	methods: {
		toggleInverse: function () {
			this.inverse = -this.inverse;
		}
	},
	computed: {
		filteredData: function () {
			var sortKey = this.sortKey;
			var data = this.liste_evenements;
			var invert = this.inverse;
			if (sortKey) {
				data.sort(function (a, b) {
					a = a[sortKey];
					b = b[sortKey];
					return (a === b ? 0 : a > b ? 1 : -1) * invert;
				});
			}
			return data;
		}
	}
});

$.ajax({
	method: "GET",
	url: "/get_liste_evenements"
}).done(function( evenements ) {
	liste_evenements.liste_evenements = evenements;
});

function confirmDelete() {
	return confirm('Êtes-vous certain?');
}
