/**
 * Créé par Nicolas Bisson le 2016-11-02.
 */

/**
 * Fonction qui permet d'afficher uniquement les participants de la région choisie.
 *
 * @param {int} regionId - L'id de la région choisie.
 */
$('#region_id').change(function(regionId) {
    console.log(regionId.currentTarget.value);
    /**
     * if participant->region->id = regionid
     *      if participant.isEmpty
     *          print aucun participant
     *      else
     *          print participant
     * elseif regionid = 0
     *      print participant //tous les participants
     */
});