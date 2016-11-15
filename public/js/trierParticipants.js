/**
 * Créé par Nicolas Bisson le 2016-11-02.
 */

/**
 * Fonction qui mets les participants de la région choisie dans une liste pour l'affichage.
 */
$('#region_id').change(function() {
    var participants_region = [];
    regionId = $('#region_id');

    if (regionId.val() == 0) {
        participants_region.push(participants);
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
 */
function listerParticipants(participants_region) {
    var table = document.createElement('table');
    console.log("allo");
    if (participants_region.length < 1) {
        console.log("allo0");
        var texte = document.createElement('h4');
        texte.innerHTML = "Il n'y a pas de participant inscrit pour cette région.";
        table.appendChild(texte)
    } else {
        console.log("allo1");
        var corpsTable = document.createElement('tbody');
        var titre = document.createElement('tr');
        var titreNumero = document.createElement('th');
        var titreParticipant = document.createElement('th');
        var titreRegion = document.createElement('th');
        var colonneCheckbox = document.createElement('th');

        table.className = 'table table-striped table-hover';
        titreNumero.innerHTML = 'Numéro';
        titreParticipant.innerHTML = 'Participant';
        titreRegion.innerHTML = 'Région';
        colonneCheckbox.innerHTML = ' ';

        titre.appendChild(titreNumero);
        titre.appendChild(titreParticipant);
        titre.appendChild(titreRegion);
        titre.appendChild(colonneCheckbox);

        for (participant in participants_region) {
            var ligneParticipant = document.createElement('tr');
            var headerCheckbox = document.createElement('th');
            var checkbox = document.createElement('input');
            checkbox.name = 'participant[' + participants_region[participant]["participant_id"] + ']';
            checkbox.type = 'checkbox';

            headerCheckbox.appendChild(checkbox);
            ligneParticipant.appendChild(headerCheckbox);
            ligneParticipant.appendChild(checkbox);

            var numeroParticipant = document.createElement('th');
            numeroParticipant.innerHTML = participants_region[participant]['numero'];
            ligneParticipant.appendChild(numeroParticipant);

            var nomParticipant = document.createElement('th');
            nomParticipant.innerHTML = participants_region[participant]['nom'];
            ligneParticipant.appendChild(nomParticipant);

            var regionParticipant = document.createElement('th');
            regionParticipant.innerHTML = participants_region[participant]['region'];
            ligneParticipant.appendChild(regionParticipant);

            table.appendChild(corpsTable);
        }
    }

}