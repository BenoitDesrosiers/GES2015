/**
 * Created by marcopolo on 2016-11-15.
 */
/**
 *
 * @author Marc P
 *
 * Script actif en tout temps sur la page. Cette fonction est activée lorsque le bouton d'ajout
 * pour les téléphones (avec le id --> add) est appuyé et clone l'ajout d'une entrée de téléphone
 */
$(document).ready(function() {
    var removeButton = "<button type = 'button' onclick='remove1(this)'>Enlever ce téléphone</button>";
    $('#add').click(function () {
        var last_id = $('div.telephone').length;
        $('div.telephone:last').after($('div.telephone:first').clone());
        $('div.telephone:last input').attr('name', 'telephone[' + (last_id + 1) + ']');
        $('div.telephone:last').append(removeButton);
        $('div.telephone:last input').each(function () {
            this.value = '';
        });
    });
});

/**
 *
 * @author Marc P
 *
 * Fonction effacant la div.telephone la plus proche. Permet d'effacer une entrée de téléphone
 * @param element --> le bouton ayant été appuyé.
 */
function remove1(element) {
    var count = 1;
    $(element).closest('div.telephone').remove();
    $('div.telephone input').each(function () {
        this.name = 'telephone[' + count + ']';
        count = count + 1;
    })
}



$(document).ready(function() {
    /**
     *
     * @author Marc P
     *
     * Script actif en tout temps sur la page. Cette fonction est activée lorsque le bouton d'ajout
     * pour les courriels (avec le id --> add2) est appuyé et clone l'ajout d'une entrée de courriel
     */
    var removeButton = "<button type = 'button' onclick='remove2(this)' class='remove2'>Enlever ce courriel</button>";
    $('#add2').click(function() {
        var last_id = $('div.courriel').length;
        $('div.courriel:last').after($('div.courriel:first').clone())
        $('div.courriel:last input').attr('name', 'courriel[' + (last_id + 1) + ']');
        $('div.courriel:last').append(removeButton);
        $('div.courriel:last input').each(function () {
            this.value = '';
        });
    });
});
/**
 *
 * @author Marc P
 *
 * Fonction effacant la div.courriel la plus proche. Permet d'effacer une entrée de courriel
 * @param element --> le bouton ayant été appuyé.
 */
function remove2(element) {
    var count =1;
    $(element).closest('div.courriel').remove();
    $('div.courriel input').each(function () {
        this.name = 'courriel[' + count + ']';
        count = count + 1;
    })
}