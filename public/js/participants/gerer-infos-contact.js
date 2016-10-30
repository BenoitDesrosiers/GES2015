/******************************************************************************
 * Fichier: gerer-infos-contact.js
 *
 * Description: Script qui gère l'ajout et le retrait de champs
 * pour les adresses et les téléphones d'un participant. Est inclus dans
 * /participants/create.blade.php.
 *
 * Créé le: 161027
 * Modifié le: 161027
 * Par: Res260
******************************************************************************/

/**
 * Ajoute le 'listener' au premier champ de téléphone.
 */
$(document).ready(function() {
	$('#conteneur-telephones').find('#telephone-numero-1').on('input', gererEtatBoutonAjouterTelephone);
});

/**
 * Procédure qui retire de la page 'conteneur' et ses enfants.
 * @param conteneur l'élément à supprimer.
 */
function retirerConteneur(conteneur) {
	$(conteneur).remove();
	//S'assurer que le bouton se ré-active.
	gererEtatBoutonAjouterTelephone();
}

/**
 * Procédure qui ajoute un téléphone à la fin des autres
 * champs d'ajout de téléphone.
 */
function ajouterTelephone() {
	var conteneur = $('#conteneur-telephones');
	var elementAAjouter =
					'<div class="form-group conteneur-telephone">' +
					'	<label for="">Numéro de téléphone:</label>' +
					'	<input type="text" name="telephone_numero[]" id="" class="form-control" />' +
					'	<label for="">Description du téléphone:</label>' +
					'	<input type="text" name="telephone_description[]" id="" class="form-control" />' +
					'	<button onclick="retirerConteneur($(this).parent())" class="btn-danger" type="button" >Retirer</button>' +
					'</div>';
	var nouveauTelephoneId = parseInt(
							 	conteneur.find('div:last .form-control')
								[0]
								.id
								.match(/\d+/)
								[0])
								+ 1;
	var elementAjoute = conteneur.append(elementAAjouter)
						.children().last();
	elementAjoute.find('input[name*="telephone_numero"]')
				 .attr('id', 'telephone-numero-' + nouveauTelephoneId)
				 //Ajoute le 'listener' pour changer l'état du bouton d'ajout.
				 .on('input', gererEtatBoutonAjouterTelephone);
	elementAjoute.find('input[name*="telephone_description"]')
				 .attr('id', 'telephone-description-' + nouveauTelephoneId);
	//S'assurer que le bouton se re-désactive.
	gererEtatBoutonAjouterTelephone();
}

/**
 * Procédure qui s'occupe d'activer ou désactiver le
 * bouton d'ajout de téléphone selon si le contenu
 * du dernier champ de # de téléphone est vide (désactive)
 * ou non-vide (active).
 */
function gererEtatBoutonAjouterTelephone() {
	var derniereEntreeNumero = $('#conteneur-telephones')
							.children()
							.last()
							.find('input[name*="telephone_numero"]')
							[0];
	if(derniereEntreeNumero.value != "") {
		$('#bouton-ajouter-telephone').removeAttr("disabled");
	} else {
		$('#bouton-ajouter-telephone').attr("disabled","disabled");
	}
}
