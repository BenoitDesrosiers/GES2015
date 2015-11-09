/*
 * La fonction changerValeurRecherche() est appeler lorsque la page est prête
 */
$(function() {
	changerEntreeRecherche();
});

/*
 *  La fonction changerValeurRecherche() est appeler lorsque le menu #listeFiltres
 *  change.
 */	
$("#listeFiltres").change(function() {
	changerEntreeRecherche();
});
	
/*
 * Permet de changer la méthode d'entrée de la recherche selon le filtre choisi
 */
function changerEntreeRecherche() {
	var valeurFiltre = $("option:selected", "#listeFiltres").val();
	var valeurRecherche = "<?php echo $valeurRecherche; ?>";
	console.log(valeurRecherche);
	
	if (!(valeurFiltre == 3 || valeurFiltre == 4)) {
		
		var champTexte = $("<input id='entreeRecherche' type='text' name='entreeRecherche' style='width:100%;'/>");

		$("#entreeRecherche").remove();
	    $("#recherche").prepend(champTexte);
	    
	} else if (valeurFiltre == 3) {
		
		var selecteur = $("<select id='entreeRecherche' name='entreeRecherche' style='width:100%;'/>");
		var donnee = getListeRegion();
		if (valeurRecherche == "") {
			valeurRecherche = "abt";
		}
		
		for(var valeur in donnee) {
		    $("<option />", {value: valeur, text: donnee[valeur]}).appendTo(selecteur);
		}
		
		selecteur.val();
		$("#entreeRecherche").remove();
	    $("#recherche").prepend(selecteur);
	    
	} else if (valeurFiltre == 4) {
		
		var selecteur = $("<select id='entreeRecherche' name='entreeRecherche' style='width:100%;'/>");
		var donnee = getChoixEquipe();
		if (valeurRecherche == "") {
			valeurRecherche = "non";
		}
		
		for(var valeur in donnee) {
		    $("<option />", {value: valeur, text: donnee[valeur]}).appendTo(selecteur);
		}
		
		selecteur.val();
		$("#entreeRecherche").remove();
	    $("#recherche").prepend(selecteur);
	    
	}
}

/*
 * Rempli le menu
 */
function getChoixEquipe() {
	var donnee = {
			"non":"Non",
			"oui":"Oui"
	};
	return donnee;
}

/*
 * Rempli le menu
 */
function getListeRegion() {
	var donnee = {
			"abt":"ABT",
			"bou":"BOU",
			"cap":"CAP",
			"cdq":"CDQ",
			"cha":"CHA",
			"ctn":"CTN",
			"edq":"EDQ",
			"lsl":"LSL",
			"lan":"LAN",
			"lau":"LAU",
			"lav":"LAV",
			"mau":"MAU",
			"mon":"MON",
			"out":"OUT",
			"riy":"RIY",
			"ris":"RIS",
			"slj":"SLJ",
			"suo":"SUO"
	};
	return donnee;
}