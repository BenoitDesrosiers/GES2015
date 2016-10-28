/**
 * Fonction executée après la chargement de la page.
 */
$(function () {
    var sportId = $('[name="sport"]').val();

    $('#region').change(function (event) {
        listerParticipants($(this).val(), sportId);
    });

    listerParticipants($('#region').val(), sportId);
});

/**
 * Liste les participants d'une région dans #listeParticipants.
 * @param regionId l'id de la région des participants
 * @param sportId l'id d'un sport
 */
function listerParticipants(regionId, sportId)
{
    $.ajax({
        method: "GET",
        url: "/tableau_participants",
        data: { region_id: regionId }
    })
        .done(function( participants ) {
            var tableau = creationTableau(participants, sportId);
            $('#listeParticipants').html(tableau);
        });
}

/**
 * Crée et retourne un tableau contenant les participants d'une région.
 * @param participants La liste des participants d'une région.
 * @param sportChoisiId l'id d'un sport
 * @returns {Element} tableau des participants
 */
function creationTableau(participants, sportChoisiId)
{
    var tableau = document.createElement('table');

    if (participants.length < 1){
        var message = document.createElement('h3');
        message.innerHTML = "Il n'y a aucun participant dans cette région."
        tableau.appendChild(message);

    }else{
        var contenuTableau = document.createElement('tbody');
        var entete = document.createElement('thead');
        var ligneTitre = document.createElement('tr');
        var titreNom = document.createElement('th');
        var titreParticipation = document.createElement('th');

        tableau.className = 'table table-striped table-hover';

        titreNom.innerHTML = 'Nom, Prénom';
        ligneTitre.appendChild(titreNom);

        titreParticipation.innerHTML = 'Participe';
        ligneTitre.appendChild((titreParticipation));

        entete.appendChild(ligneTitre);
        tableau.appendChild(entete);
        $.each(participants, function(index, participant){

            var ligne = document.createElement('tr');
            var element = document.createElement('td');
            var participation = document.createElement('td');
            var checkbox = document.createElement('input');
            checkbox.name = 'participation[' + participant.id + ']';

            element.innerHTML = participant.nom + ", " + participant.prenom;
            ligne.appendChild(element);
            checkbox.type = 'checkbox';

            $.each(participant.sports, function(index, sport){
                if (sport.id == sportChoisiId){
                    checkbox.checked = true;
                }
            })

            participation.appendChild(checkbox)
            ligne.appendChild(participation);

            contenuTableau.appendChild(ligne);
        })

        tableau.appendChild(contenuTableau);
    }

    return tableau;
}