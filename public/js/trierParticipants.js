/**
 * Créé par Nicolas Bisson le 2016-11-02.
 */

/**
 * Lance la fonction pour afficher tous les participants au chargement de la page.
 */
$(document).ready(function () {
    listerParticipants(participants);
});

/**
 * Fonction qui mets les participants de la région choisie dans une liste pour l'affichage.
 */
$('#region_id').change(function() {
    var participants_region = [];
    regionId = $('#region_id');

    if (regionId.val() == 0) {
        participants_region = participants;
    } else {
        for (id in participants) {
            if (participants[id]["participant_region_id"] == regionId.val()) {
                participants_region.push(participants[id]);
            }
        }
    }

    listerParticipants(participants_region);
});

/**
 * Crée la table qui sert à lister les participants.
 * Affiche les participants dans cette table.
 *
 * @param participants_region : Array des participants de la région sélectionnée.
 */
function listerParticipants(participants_region) {

    if (true) {
        detruireTable("1");
    }

    var corps = document.getElementsByTagName('tbody')[0];
    var table = document.createElement('table');
    var corpsTable = document.createElement('tbody');

    table.className = 'table table-striped table-hover';
    table.id = "1";

    if (participants_region.length < 1) {
        var texte = document.createElement('h4');
        texte.innerHTML = "Il n'y a pas de participant inscrit pour cette région.";
        corpsTable.appendChild(texte)
    } else {
        var titre = document.createElement('tr');
        var colonneCheckbox = document.createElement('th');
        var titreNumero = document.createElement('th');
        var titreParticipant = document.createElement('th');
        var titreRegion = document.createElement('th');

        titreNumero.innerHTML = 'Numéro';
        titreParticipant.innerHTML = 'Participant';
        titreRegion.innerHTML = 'Région';
        colonneCheckbox.innerHTML += '&nbsp;';

        titre.appendChild(colonneCheckbox);
        titre.appendChild(titreNumero);
        titre.appendChild(titreParticipant);
        titre.appendChild(titreRegion);

        corpsTable.appendChild(titre);

        for (participant in participants_region) {
            var ligneParticipant = document.createElement('tr');
            var headerCheckbox = document.createElement('th');
            var checkbox = document.createElement('input');
            checkbox.name = 'participants[' + participants_region[participant]["participant_id"] + ']';
            checkbox.setAttribute('id', participants_region[participant]["participant_id"]);
            checkbox.type = 'checkbox';

            if (participants_region[participant]['is_checked']) {
                checkbox.setAttribute('checked', 'checked');
            }

            headerCheckbox.appendChild(checkbox);
            ligneParticipant.appendChild(headerCheckbox);

            var numeroParticipant = document.createElement('th');
            numeroParticipant.innerHTML = participants_region[participant]['numero'];
            ligneParticipant.appendChild(numeroParticipant);

            var nomParticipant = document.createElement('th');
            nomParticipant.innerHTML = participants_region[participant]['nom'];
            ligneParticipant.appendChild(nomParticipant);

            var regionParticipant = document.createElement('th');
            regionParticipant.innerHTML = participants_region[participant]['region'];
            ligneParticipant.appendChild(regionParticipant);

            corpsTable.appendChild(ligneParticipant);
        }
    }

    table.appendChild(corpsTable);
    corps.appendChild(table);
}

/**
 * Détruit la table existant.
 *
 * @param tableId : String de l'id de la table à détruire.
 */
function detruireTable(tableId) {
    var table = document.getElementById(tableId);
    if (table) {
        table.parentNode.removeChild(table);
    }

}