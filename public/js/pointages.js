/**
 * 
 */
function genererTablePointages() {
	var valeurInitiale = $("#valeurInitiale").val();
	var decrement = $("#decrement").val();
	var valeur = valeurInitiale;
	var corpsTable = $("#tablePointages").children("tbody");
	if ($("#listeSports").val() != 0) {
		if (valeurInitiale % 1 === 0 && valeurInitiale > 0 && valeurInitiale <= 100 && decrement % 1 === 0 && decrement > 0 && decrement <= 100) {
			corpsTable.empty();
			while(valeur > 0) {
				ajouterValeur(valeur);
				valeur = valeur - decrement;
			}
			var position = corpsTable.children("tr").length+1;
			var champValeur = "<input name='valeur["+position+"] type='text' class='form-control' name='champValeur' value='0'/>";
			corpsTable.append("<tr class='col-md-12' style='height: 50px'>").children("tr:last").append("<td class='col-md-10'>"+position+"</td><td class='col-md-10'>"+champValeur+"</td>");
			
			$("#tableVide").addClass("hide");
			$("#tablePointages").removeClass("hide");
			vierge = false;
		}
	}
}

function ajouterValeur(valeur) {
	var corpsTable = $("#tablePointages").children("tbody");
	var position = corpsTable.children("tr").length+1;
	var champValeur = "<input name='valeur["+position+"] type='text' class='form-control' name='champValeur' value='"+valeur+"'/>";
	corpsTable.append("<tr class='col-md-12' style='height: 50px'>").children("tr:last").append("<td class='col-md-10'>"+position+"</td><td class='col-md-10'>"+champValeur+"</td>");
	vierge = false;
}

function ajouterRangee() {
	var corpsTable = $("#tablePointages").children("tbody");
	var position = corpsTable.children("tr").length+1;
	var champValeur = "<input name='valeur["+position+"] type='text' class='form-control' name='champValeur' value='0'/>";
	corpsTable.append("<tr class='col-md-12' style='height: 50px'>").children("tr:last").append("<td class='col-md-10'>"+position+"</td><td class='col-md-10'>"+champValeur+"</td>");
	vierge = false;
}

function retirerRangee() {
	if ($("#tablePointages").children("tbody").children("tr").length > 1){
		$("#tablePointages").children("tbody").children("tr:last").remove();
		vierge = false;
	}
}

function viderTablePointages() {
	var bodyTable = $("#tablePointages").children("tbody");
	bodyTable.empty();
	$("#tableVide").removeClass("hide");
	$("#tablePointages").addClass("hide");
	vierge = false;
}
