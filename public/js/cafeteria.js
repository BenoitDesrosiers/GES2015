/**
 * Fonction executée après le chargement de la page.
 */
$(function () {

    $("#ajouterResponsable").on("click", '.ajouterResponsable', function() {
	  ajouterRangee();
	});

	$("#responsables").on("click", '.retirerResponsable', function(event) {
	  retirerRangee(event.target);
	});

});

/**
 * Ajoute une rangée de responsable.
 */
function ajouterRangee()
{
	var rangee = this.creerRangee().outerHTML;
	document.getElementById('inputResponsables').insertAdjacentHTML('beforeend',rangee);
}

/**
 * Retirer une rangée de responsable. Si il s'agit de la dernière,
 * ça la vide au lieu de la retirer.
 * @param  button Le bouton appuyé ayant lancer la méthode. 
 */
function retirerRangee(button)
{
	if ($('#inputResponsables').children().length == 1) {
		
		$(button).parent().find('input').each(function(index){
			this.value = ""
		});
	
	} else {

		button.closest('.rangee').remove();
	}
		
}

/**
 * Crée une nouvelle rangée de responsable. Cela signifie un champ 
 * nom, un champ téléphone et un bouton pour retirer la rangée.
 * @return rangee Une rangee HTML.
 */
function creerRangee()
{
	var rangee = document.createElement('div');
	var conteneurNom = document.createElement('div');
	var conteneurTelephone = document.createElement('div');
	var nom = document.createElement('input');
	var telephone = document.createElement('input');
	var retirer = document.createElement('button');

	rangee.className = 'form-group row rangee';
	conteneurNom.className = 'col-xs-3';
	conteneurTelephone.className = 'col-xs-3';
	nom.className = 'form-control';
	telephone.className = 'form-control';
	retirer.className = 'btn btn-danger retirerResponsable';

	retirer.innerHTML = '-';
	retirer.type = 'button';

	// Compte le nombre de rangée de responsable.
	var id = document.querySelectorAll('#inputResponsables .rangee').length;

	nom.name = 'responsable['+ id + '][nom]';
	telephone.name = 'responsable['+ id + '][telephone]';

	nom.placeholder = 'Nom';
	telephone.placeholder = 'Téléphone';

	conteneurNom.appendChild(nom);
	conteneurTelephone.appendChild(telephone)

	rangee.appendChild(conteneurNom);
	rangee.appendChild(conteneurTelephone);
	rangee.appendChild(retirer);

	return rangee;
}