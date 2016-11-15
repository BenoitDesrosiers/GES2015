/**
 *  Par Dey-Dey
 *  Permet de gérer la table de choix des arbitres dans la page des épreuves
 *  Adapté par Jérémi Pedneault pour respecter les besoins du site.
 *  Généralisé par Francis Mathieu afin que le tableau puisse être réutilisé.
 */
/*
$('.ajouter').click(function(){
    $('.all').prop("checked",false);
    var items = $("#list1 input:checked:not('.all')");
    var n = items.length;
  	if (n > 0) {
      items.each(function(idx,item){
        var choice = $(item);
        choice.prop("checked",false);
        choice.parent().appendTo("#list2");
      });
  	}
    else {
  		alert("Choose an item from list 1");
    }
});
*/
/*
$('.retirer').click(function(){
    $('.all').prop("checked",false);
    var items = $("#list2 input:checked:not('.all')");
	items.each(function(idx,item){
      var choice = $(item);
      choice.prop("checked",false);
      choice.parent().appendTo("#list1");
    });
});
*/

/* transfère les éléments cochés dans la liste de droite */
function transfererDroite(){
    $('.all').prop("checked",false);
    var items = $("#list1 input:checked:not('.all')");
    var n = items.length;
  	if (n > 0) {
      items.each(function(idx,item){
        var choice = $(item);
        choice.prop("checked",false);
        choice.parent().appendTo("#list2");
      });
  	}
    else {
  		alert("Choisissez un arbitre parmis ceux disponibles");
    }	
};

/* transfère les éléments cochés dans la liste de gauche */
function transfererGauche(){
    $('.all').prop("checked",false);
    var items = $("#list2 input:checked:not('.all')");
    var n = items.length;
  	if (n > 0) {
      items.each(function(idx,item){
        var choice = $(item);
        choice.prop("checked",false);
        choice.parent().appendTo("#list1");
      });
  	}
    else {
  		alert("Choisissez un arbitre parmis ceux déjà assignés");
    }
};

/* toggle all checkboxes in group */
$('.all').click(function(e){
	e.stopPropagation();
	var $this = $(this);
    if($this.is(":checked")) {
    	$this.parents('.list-group').find("[type=checkbox]").prop("checked",true);
    }
    else {
    	$this.parents('.list-group').find("[type=checkbox]").prop("checked",false);
        $this.prop("checked",false);
    }
});

$('[type=checkbox]').click(function(e){
  e.stopPropagation();
});

/* toggle checkbox when list group item is clicked */
$('.list-group a').click(function(e){
  
    e.stopPropagation();
  
  	var $this = $(this).find("[type=checkbox]");
    if($this.is(":checked")) {
    	$this.prop("checked",false);
    }
    else {
    	$this.prop("checked",true);
    }
  
    if ($this.hasClass("all")) {
    	$this.trigger('click');
    }
});

/**
 * Ajoute les arbitres sélectionnés de droite dans un input masqué pour être soumis lors
 * de la création ou de la modification
 */
function changer_liste(){
	var enfants = document.getElementById("list2").children;
	var liste = [];
	var x = enfants.length-1;
	if (enfants.length > 1){
		for (var i = 1 ; i <= x ; i++){
			liste.push(enfants[i].name);
		};
	}else{
		liste.push(0)
	}
	document.getElementById("arbitresUtilises").value = liste;
};