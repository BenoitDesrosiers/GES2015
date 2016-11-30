/**
 * Fonction executée après le chargement de la page.
 */
$(function () {
    $('#region').change(function (event) {
        console.log('hhi');
        listerDelegues($(this).val(), $('meta[name="csrf-token"]').attr('content'));
    });

    //listerDelegues($('#region').val(), $('meta[name="csrf-token"]').attr('content'));
    listerDelegues(1, $('meta[name="csrf-token"]').attr('content'));
});

$("body").bind("ajaxSend", function(elm, xhr, s){
    xhr.setRequestHeader('X-CSRF-Token', getCSRFTokenValue());
});

/**
 *
 * Liste des délégués dans une région.
 *
 * @param regionId
 * @param delegues
 *
 */
function listerDelegues(regionId, csrf) {
    console.log(csrf);
    $.ajax({
        method: "GET",
        url: "/tableau_delegues",
        data: {region_id: regionId}
    })
        .done(function (delegues) {
            var tableau = creerTableau(delegues, csrf);
            $('#listeDelegues').html(tableau);
        });
}

/**
 *
 * Créer et retourne un tableau contenant les délégués d'une région
 *
 * @param delegues
 *
 */
function creerTableau(delegues, crsf){
    var tableau = document.createElement('table');
    var token = crsf;
    if (delegues.length < 1){
        var texte = document.createElement('h3')
        texte.innerHTML = "Il n'y a pas de délégué dans cette région."
    }
    else{
        var bodyTableau = document.createElement('tbody');
        bodyTableau.className = 'table table-striped table hover';
        var entente = creerEntete();

        tableau.appendChild(entente);
        $.each(delegues, function (index, delegue) {


            var ligne = creerLigne(index, delegue, token);

            bodyTableau.appendChild(ligne);
        })
    }

    tableau.appendChild(bodyTableau)
    return tableau;
}

/**
 *
 * Créer l'entete du tableau des délégués.
 *
 * @return {Element} une entête de tableau html
 *
 */
function creerEntete()
{
    var ligneTitre = document.createElement('tr');
    var titreNom = document.createElement('th');
    var titreRegion = document.createElement('th');
    var titreRole = document.createElement('th');
    var titreAccreditation = document.createElement('th');
    var sansTitre = document.createElement('th');
    var entete = document.createElement('thead');

    titreNom.innerHTML = 'Nom';
    ligneTitre.appendChild(titreNom);

    titreRegion.innerHTML = 'Région';
    ligneTitre.appendChild(titreRegion);

    titreRole.innerHTML = 'Rôle';
    ligneTitre.appendChild(titreRole);

    titreAccreditation.innerHTML = 'Accréditation';
    ligneTitre.appendChild(titreAccreditation);

    ligneTitre.appendChild(sansTitre);
    ligneTitre.appendChild(sansTitre);

    entete.appendChild(ligneTitre);

    return entete;
}

/**
 *
 * Créer une ligne dans le tableau des délégués
 *
 * @param index --> l'index du délégués
 * @param delegues --> le délégués
 *
 * @return {Element} Une ligne du tableau en html
 *
 */
function creerLigne(index, delegue, csrf){

    var ligne = document.createElement('tr');
    var nomDelegue = document.createElement('td');
    var nomDelegueRef = document.createElement('a');
    var regionDelegue = document.createElement('td');
    var roleDelegue = document.createElement('td');
    var accreditationDelegue = document.createElement('td');
    var modifierDelegue = document.createElement('td');
    var effacerDelegue = document.createElement('td');

    // Nom

    nomDelegueRef.innerHTML = delegue.nom + ', ' + delegue.prenom;
    nomDelegueRef.setAttribute('href', 'delegues/' + delegue.id);
    nomDelegue.appendChild(nomDelegueRef);
    ligne.appendChild(nomDelegue);

    // Région

    //regionDelegue.innerHTML = "class='hidden-sm hidden-xs'><span data-toggle='tooltip' data-placement='bottom' title= delegue.region.nom > delegue.region.nom_court </span>";
    regionDelegue.innerHTML = delegue.region.nom_court;
    ligne.appendChild(regionDelegue);

    // Rôles

    if (delegue.roles.length >= 2){
        roleDelegue.innerHTML = "<button type='submit' class='btn btn-default btn-mini glyphicon glyphicon-plus' onClick='afficherRoles(this)'/>";
        ligne.appendChild(roleDelegue);
    }else if (delegue.roles.length == 1){
        roleDelegue.innerHTML = delegue.roles.nom;
        ligne.appendChild(roleDelegue);
    }else{
        ligne.appendChild(roleDelegue);
    }

    // Accréditation

    if (delegue.accreditation == 1){
        accreditationDelegue.innerHTML = "Oui";
        ligne.appendChild(accreditationDelegue)
    }
    else if(delegue.accreditation == 0){
        accreditationDelegue.innerHTML = "Non";
        ligne.appendChild(accreditationDelegue)
    }


    // Modifier

    modifierDelegue.innerHTML = "<a href='/delegues/" +  delegue.id +  "/edit' class='btn btn-info'>Modifier</a>"
    ligne.appendChild(modifierDelegue)

    // Effacer

    effacerDelegue.innerHTML = "<form method='POST' action='/delegues/" + delegue.id + "' accept-charset='UTF-8' onsubmit='return confirmDelete()'><input name='_method' type='hidden' value='DELETE'><input name='_token' type='hidden' value= " + csrf + " > <button type=submit href='/delegues/" + delegue.id + "' class='btdfn btn-danger btn-mini'>Effacer</button> </form>";
    ligne.appendChild(effacerDelegue)

    return ligne;

}


// 	Affiche ou masque les rôles d'un délégué donné
function afficherRoles(bouton) {
    rangee = bouton.parentNode.parentNode;
    if (rangee.classList.contains("actif")) {
        bouton.classList.remove("glyphicon-minus");
        bouton.classList.add("glyphicon-plus");
        rangee.classList.remove("actif");
    } else {
        bouton.classList.remove("glyphicon-plus");
        bouton.classList.add("glyphicon-minus");
        rangee.classList.add("actif");
    }
}

/**
 *
 * Fonction pour confirmer, car le data-confirm ne fonctionne pas
 *
 */
function confirmDelete() {
    return confirm('Êtes-vous certain?');
}

//$(function () {
//    $('[data-toggle="tooltip"]').tooltip()
//})
