/**
 * Fonction executée après le chargement de la page.
 */
$(function () {

    var rangeeVierge = document.getElementsByClassName('rangee')[0].outerHTML;
    $( "#responsables" ).on( "click", '.ajouterResponsable',function() {
	  ajouterRangee(rangeeVierge);
	});

	$( "#responsables" ).on( "click", '.retirerResponsable',function(event) {
	  console.log(event.target)
	  retirerRangee(event.target);
	});

});

function ajouterRangee(rangeeVierge)
{
	changerDernierBoutton();
	document.getElementById('responsables').insertAdjacentHTML('beforeend',rangeeVierge);
}

function retirerRangee(button)
{
	button.closest('.rangee').remove();
}

function changerDernierBoutton()
{
	var boutton = document.getElementsByClassName('dernierAjout')[0];
	boutton.innerHTML = '-';
	boutton.className = 'btn btn-danger retirerResponsable';
	
}