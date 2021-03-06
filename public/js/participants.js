/*
 * Permet de changer la méthode d'entrée de la recherche selon le filtre choisi
 */
function changerEntreeRecherche(listeRecherches, valeurRecherche) {
	var valeurFiltre = $("option:selected", "#listeFiltres").val();
	if (!(valeurFiltre == 3)) {
		console.log(valeurFiltre);
		var champTexte = $("<input id='entreeRecherche' type='text' name='entreeRecherche' style='width:100%;'/>");
		champTexte.attr("value", valeurRecherche);
		$("#entreeRecherche").remove();
	    $("#recherche").prepend(champTexte);
	    
	} else if (valeurFiltre == 3) {
		
		var selecteur = $("<select id='entreeRecherche' name='entreeRecherche' style='width:100%;'/>");
		
		$("<option />", {value: "", text: "Toutes les régions"}).appendTo(selecteur);
		for(var valeur in listeRecherches) {
		    $("<option />", {value: listeRecherches[valeur], text: listeRecherches[valeur]}).appendTo(selecteur);
		}
		
		if (isInArray(valeurRecherche, listeRecherches)) {
			selecteur.val(valeurRecherche);		
		} else {
			selecteur.val();		
		}
		$("#entreeRecherche").remove();
	    $("#recherche").prepend(selecteur);
	}
}

/*
 * Valide si une valeur se trouve dans une liste
 */
function isInArray(value, array) {
	  return array.indexOf(value) > -1;
	}