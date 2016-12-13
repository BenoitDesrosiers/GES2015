/**
 * Created by Simon on 2016-12-09.
 */


/**
* Script actif en tout temps sur la page. Cette fonction est activée par le bouton d'ajout
* de disponibilité. Il s'agit d'un clone de la première entrée de disponiblité
*/
function ajouterDisponibilite() {
    var boutonRetirer = '<td class="imageRetirer"><button class="btn btn-default btn-mini glyphicon glyphicon-minus"' +
        'type = "button" onclick="retirerDisponibilite(this)"></button></td>';

    //Nb de 'rowDisponibilite' dans la page
    var last_id = $('tr.rowDisponibilite').length;


    $('tr.rowDisponibilite:last').after($('tr.rowDisponibilite:first').clone());

    //Numérotation des noms des forms ajoutés
    $('td.dataJour:last input').attr('name', 'jour[' + (last_id + 1) + ']');
    $('td.dataMois:last input').attr('name', 'mois[' + (last_id + 1) + ']');
    $('td.dataAnnee:last input').attr('name', 'annee[' + (last_id + 1) + ']');
    $('td.dataDebut:last select').attr('name', 'debut[' + (last_id + 1) + ']');
    $('td.dataFin:last select').attr('name', 'fin[' + (last_id + 1) + ']');
    $('td.dataCommentaire:last input').attr('name', 'commentaire[' + (last_id + 1) + ']');

    $('tr.rowDisponibilite:last').append(boutonRetirer);

    $('td.dataJour:last input').each(function () {
        this.value = '';
    });
    $('td.dataMois:last input').each(function () {
        this.value = '';
    });
    $('td.dataAnnee:last input').each(function () {
        this.value = '';
    });
    $('td.dataDebut.last input').each(function () {
        this.value = '';
    });
    $('td.dataFin.last input').each(function () {
        this.value = '';
    });
    $('td.dataCommentaire.last input').each(function () {
        this.value = '';
    });
}

/**
 * Fonction effaçant la disponibilité dont le bouton "retirer" a été effacé
 * @param Le bouton ayant été appuyé
 */
function retirerDisponibilite(disponibilite) {
    var count = 1;
    var rowSelectionnee = disponibilite.parentNode.parentNode.rowIndex;
    document.getElementById("tableDisponibilite").deleteRow(rowSelectionnee);
    $('td.dataJour input').each(function () {
        this.name = 'jour[' + count + ']';
        count = count + 1;
    });
    $('td.dataMois input').each(function () {
        this.name = 'mois[' + count + ']';
        count = count + 1;
    });
    $('td.dataAnnee input').each(function () {
        this.name = 'annee[' + count + ']';
        count = count + 1;
    });
    count = 1;
    $('td.dataDebut select').each(function () {
        this.name = 'debut[' + count + ']';
        count = count + 1;
    });
    count = 1;
    $('td.dataFin select').each(function () {
        this.name = 'fin[' + count + ']';
        count = count + 1;
    });
    count = 1;
    $('td.dataCommentaire input').each(function () {
        this.name = 'commentaire[' + count + ']';
        count = count + 1;
    });
}