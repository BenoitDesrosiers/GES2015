/**
 * Created by Simon Gagné on 2016-11-22.
 */


/**
 * Script actif en tout temps sur la page. Cette fonction est activée par le bouton d'ajout
 * de téléphone. Il s'agit d'un clone de la première entrée de téléphone (vidée)
 */
function ajouterTelephone() {
    var boutonRetirer = '<td class="imageRetirer"><button class="btn btn-default btn-mini glyphicon glyphicon-minus"' +
        'type = "button" onclick="retirerTelephone(this)"></button></td>';

    //Nb de 'rowTelephone' dans la page
    var last_id = $('tr.rowTelephone').length;

    $('tr.rowTelephone:last').after($('tr.rowTelephone:first').clone());
    $('td.dataTelephone:last input').attr('name', 'telephone[' + (last_id + 1) + ']');
    $('td.dataDescTelephone:last input').attr('name', 'descriptionTelephone[' + (last_id + 1) + ']');
    $('tr.rowTelephone:last').append(boutonRetirer);
    $('td.dataTelephone:last input').each(function () {
        this.value = '';
    });
    $('td.dataDescTelephone:last input').each(function () {
        this.value = '';
    });
}

/**
 * Fonction effacant le numéro de téléphone dont le bouton "retirer" a été effacé
 * @param Le bouton ayant été appuyé
 */
function retirerTelephone(telephone) {
    var count = 1;
    var rowSelectionnee = telephone.parentNode.parentNode.rowIndex;
    document.getElementById("tableTelephone").deleteRow(rowSelectionnee);
    $('td.dataTelephone input').each(function () {
        this.name = 'telephone[' + count + ']';
        count = count + 1;
    });
    var count = 1;
    $('td.dataDescTelephone input').each(function () {
        this.name = 'descriptionTelephone[' + count + ']';
        count = count + 1;
    });
}


/**
 * Script actif en tout temps sur la page. Cette fonction est activée par le bouton d'ajout
 * d'adresse courriel. Il s'agit d'un clone de la première entrée des adresses courriel (vidée)
 */
function ajouterCourriel() {
    var boutonRetirer = '<td class="imageRetirer"><button class="btn btn-default btn-mini glyphicon glyphicon-minus"' +
        'type = "button" onclick="retirerCourriel(this)"></button></td>';

    //Nb de "rowCourriel" dans la page
    var last_id = $('tr.rowCourriel').length;

    $('tr.rowCourriel:last').after($('tr.rowCourriel:first').clone());
    $('td.dataCourriel:last input').attr('name', 'courriel[' + (last_id + 1) + ']');
    $('td.dataDescCourriel:last input').attr('name', 'descriptionCourriel[' + (last_id + 1) + ']');
    $('tr.rowCourriel:last').append(boutonRetirer);
    $('td.dataCourriel:last input').each(function () {
        this.value = '';
    });
    $('td.dataDescCourriel:last input').each(function () {
        this.value = '';
    });
}

/**
 * Fonction effacant l'adresse courriel dont le bouton "retirer" a été appuyé.
 * @param Le bouton ayant été appuyé
 */
function retirerCourriel(courriel) {
    var count = 1;
    var rowSelectionnee = courriel.parentNode.parentNode.rowIndex;
    document.getElementById("tableCourriel").deleteRow(rowSelectionnee);
    $('td.dataCourriel input').each(function () {
        this.name = 'courriel[' + count + ']';
        count = count + 1;
    });
    var count = 1;
    $('td.dataDescCourriel input').each(function () {
        this.name = 'descriptionCourriel[' + count + ']';
        count = count + 1;
    });
}
