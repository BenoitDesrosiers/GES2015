/******************************************************************************
 * Fichier: gerer-infos-disponibilites.js
 *
 * Description: Script qui gère l'ajout et le retrait de champs
 * pour les disponibilités d'un bénévole.
 *
 * Créé le: 161129
 * Modifié le: 161209
 * Par: Steve D.
******************************************************************************/

/**
 * Ajoute le 'listener' au premier champ de disponibilité.
 */
$(document).ready(function() {
	$('#conteneur-disponibilites').find('#disponibilite-disponibilite-1').on('input', gererEtatBoutonsAjout);
	gererEtatBoutonsAjout();
});

/**
 * Procédure qui retire de la page 'conteneur' et ses enfants.
 * @param conteneur L'élément à supprimer.
 */
function retirerConteneur(conteneur) {
	var nombreEnfants = $(conteneur).parent().children().length;

	if(nombreEnfants > 1) {
		$(conteneur).remove();
	} else {
		conteneur.find("input").each(function(index) {
			this.value = "";
		});
		conteneur.on('input', gererEtatBoutonsAjout);
	}
	//S'assurer que le bouton s'active.
	gererEtatBoutonsAjout();
}

/**
 * Procédure qui ajoute une disponibilité à la fin des autres
 * champs d'ajout d'une disponibilité.
 */
function ajouterDisponibilite() {
	var conteneur = $('#conteneur-disponibilites');
	var elementAAjouter =
		'<div class="form-group conteneur-disponibilite">' +
		'	<label for="disponibilite_disponibilite[]">Description de la disponibilité:</label>' +
		'	<input type="text" name="disponibilite_disponibilite[]" id="disponibilite-disponibilite-1" class="form-control" maxlength="255"/>' +
		
		'	<label for="disponibilite_annee[]">Année:</label>' +
		'	<input type="number" name="disponibilite_annee[]" id="disponibilite-annee-1" class="form-control" step="1" min="2016" max="9999"/>' +
		
		'	<label for="disponibilite_mois[]">Mois (en chiffre):</label>' +
		'	<input type="number" name="disponibilite_mois[]" id="disponibilite-mois-1" class="form-control" step="1" min="1" max="12"/>' +
		
		'	<label for="disponibilite_jour[]">Jour:</label>' +
		'	<input type="number" name="disponibilite_jour[]" id="disponibilite-jour-1" class="form-control" step="1" min="1" max="31"/>' +
		
        '   <label for="disponibilite_isAllDay[]">Toute la journée:</label>' +
		'   <input type="checkbox" name="disponibilite_isAllDay[]" id="disponibilite-isAllDay-1">' +
		'   <label for="isAllDay">Si coché, les heures et les minutes ne seront pas prises en compte.</label>' +
		
		'	<label for="disponibilite_debut_heure[]">Heure de début (format 24h):</label>' +
		'	<input type="number" name="disponibilite_debut_heure[]" id="disponibilite-debut-heure-1" class="form-control" step="1" min="0" max="23"/>' +
		
		'	<label for="disponibilite_debut_minute[]">Minute de début:</label>' +
		'	<input type="number" name="disponibilite_debut_minute[]" id="disponibilite-debut-minute-1" class="form-control" step="1" min="0" max="59"/>' +
		
		'	<label for="disponibilite_fin_heure[]">Heure de fin (format 24h):</label>' +
		'	<input type="number" name="disponibilite_fin_heure[]" id="disponibilite-fin-heure-1" class="form-control" step="1" min="0" max="23"/>' +
		
		'	<label for="disponibilite_fin_minute[]">Minute de fin:</label>' +
		'	<input type="number" name="disponibilite_fin_minute[]" id="disponibilite-fin-minute-1" class="form-control" step="1" min="0" max="59"/>' +
		
		'	<button onclick="retirerConteneur($(this).parent())" class="btn-danger" type="button" >Retirer</button>' +
		'</div>';
	
	var nouvelleDisponibiliteId = parseInt(
			conteneur.find('div:last .form-control')
				[0]
				.id
				.match(/\d+/)
				[0])
		+ 1;
	
	var elementAjoute = conteneur.append(elementAAjouter)
		.children().last();
	elementAjoute.find('input[name*="disponibilite_disponibilite"]')
		.attr('id', 'disponibilite-disponibilite-' + nouvelleDisponibiliteId)
		//Ajoute le 'listener' pour changer l'état du bouton d'ajout.
		.on('input', gererEtatBoutonsAjout);
	
	elementAjoute.find('input[name*="disponibilite_annee"]')
		.attr('id', 'disponibilite-annee-' + nouvelleDisponibiliteId)
		
	elementAjoute.find('input[name*="disponibilite_mois"]')
		.attr('id', 'disponibilite-mois-' + nouvelleDisponibiliteId)
		
	elementAjoute.find('input[name*="disponibilite_jour"]')
		.attr('id', 'disponibilite-jour-' + nouvelleDisponibiliteId)
		
	elementAjoute.find('input[name*="disponibilite_isAllDay"]')
		.attr('id', 'disponibilite-isAllDay-' + nouvelleDisponibiliteId)
		
	elementAjoute.find('input[name*="disponibilite_debut_heure"]')
		.attr('id', 'disponibilite-debut-heure-' + nouvelleDisponibiliteId)
		
	elementAjoute.find('input[name*="disponibilite_debut_minute"]')
		.attr('id', 'disponibilite-debut-minute-' + nouvelleDisponibiliteId)
		
	elementAjoute.find('input[name*="disponibilite_fin_heure"]')
		.attr('id', 'disponibilite-fin-heure-' + nouvelleDisponibiliteId)
		
	elementAjoute.find('input[name*="disponibilite_fin_minute"]')
		.attr('id', 'disponibilite-fin-minute-' + nouvelleDisponibiliteId)
		
	//S'assurer que le bouton se désactive.
	gererEtatBoutonsAjout();
}

/**
 * Procédure qui s'occupe d'activer ou désactiver le
 * bouton d'ajout d'une disponibilité selon si le contenu
 * du premier champ de description de disponibilité est vide (désactive)
 * ou non-vide (active).
 */
function gererEtatBoutonsAjout() {
	var premierEntreeDisponibilite= $('#conteneur-disponibilites')
		.children()
		.last()
		.find('input[name*="disponibilite_disponibilite"]')
		[0];
	if(premierEntreeDisponibilite.value != "") {
		$('#bouton-ajouter-disponibilite').removeAttr("disabled");
	} else {
		$('#bouton-ajouter-disponibilite').attr("disabled","disabled");
	}
}
