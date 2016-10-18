$(function () {
    $('.dropdown li').click(function(){
        var region_id = $(this).val();
        var region = $(this).text();
        $(this).parents().find('.btn').html(region + '<span class="caret"></span>');
        $.ajax({
            method: "GET",
            url: "/test",
            data: { region_id: region_id }
        })
            .done(function( participants ) {
                var tableau = creationTableau(participants, region);
                $('#listeParticipants').html(tableau);
            });
    });
});

function creationTableau(participants, region)
{
    var tableau = document.createElement('table');
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
        if ( ! participant.equipe){

            var ligne = document.createElement('tr');
            var element = document.createElement('td');
            var participation = document.createElement('td');
            var checkbox = document.createElement('input');

            element.innerHTML = participant.nom + ", " + participant.prenom;
            ligne.appendChild(element);

            checkbox.type = 'checkbox';
            participation.appendChild(checkbox)
            ligne.appendChild(participation);

            contenuTableau.appendChild(ligne);
        }
    })

    tableau.appendChild(contenuTableau);

    return tableau;
}