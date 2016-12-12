/**
 * Fonction executée après le chargement de la page.
 */
$(function () {


    $('#region').change(function (event) {
        listerParticipants($(this).val());
    });
    listerParticipants($('#region').val());
});

/**
 * Liste les participants d'une région dans #listeParticipants.
 * @param regionId l'id de la région des participants
 * @param sportId l'id d'un sport
 */
function listerParticipants(regionId)
{
    console.log(region);
    $.ajax({
        method: "GET",
        url: "/tableau_participants",
        data: { region_id: regionId }
    })
        .done(function( participants ) {
            var tableau = creationTableau(participants);
            $('#listeParticipants').html(tableau);
        });
}

/**
 * Crée et retourne un tableau contenant les participants d'une région.
 * @param participants La liste des participants d'une région.
 * @param sportChoisiId l'id d'un sport
 * @returns {Element} tableau des participants
 */
function creationTableau(participants)
{
    var tableau = document.createElement('table');

    if (participants.length < 1){
        var contenuTableau = document.createElement('h3');
        contenuTableau.innerHTML = "Il n'y a aucun participant dans cette région."

    }else{
        var contenuTableau = document.createElement('tbody');

        tableau.className = 'table table-striped table-hover';
        var entete = creationEntete();

        tableau.appendChild(entete);
        $.each(participants, function(index, participant){

            var ligne = creationLigne(index, participant);

            contenuTableau.appendChild(ligne);
        })
    }

    tableau.appendChild(contenuTableau);
    return tableau;
}

/**
 * Crée l'entête du tableau des participants.
 * @returns {Element} Une entête de tableau html.
 */
function creationEntete()
{
    var ligneTitre = document.createElement('tr');
    var titreNom = document.createElement('th');
    var titreParticipation = document.createElement('th');
    var entete = document.createElement('thead');

    titreNom.innerHTML = 'Nom, Prénom';
    ligneTitre.appendChild(titreNom);

    titreParticipation.innerHTML = 'Participe';
    ligneTitre.appendChild((titreParticipation));

    entete.appendChild(ligneTitre);

    return entete;
}

/**
 * Création d'une ligne dans le tableau des participants.
 * @param index L'index du participant
 * @param participant Le participant
 * @return {Element} Une ligne du tableau en html
 */
function creationLigne(index, participant)
{
    var ligne = document.createElement('tr');
    var element = document.createElement('td');
    var participation = document.createElement('td');
    var checkbox = document.createElement('input');
    checkbox.name = 'participation[' + participant.id + ']';
    checkbox.title = 'Le participe participe à ce sport';

    element.innerHTML = participant.nom + ", " + participant.prenom;
    ligne.appendChild(element);
    checkbox.type = 'checkbox';

    var sportId = $('input[name="sport"]').val();

    $.each(participant.sports, function(index, sport){
        if (sport.id == sportId){
            checkbox.checked = true;
        }
    })

    participation.appendChild(checkbox)
    ligne.appendChild(participation);

    return ligne;
}