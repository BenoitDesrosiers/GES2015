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
});