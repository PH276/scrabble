$(document).ready(function() {
    // choix d'une lettre de réserve
    $('.reserve').on('click', function(e){
        frm = $('#form-lettre-choisie')[0];
        console.log(frm.lettreChoisie.value);
        frm.lettreChoisie.value = e.currentTarget.childNodes[0].data;
        frm.submit();
    });

    // choix d'une position pour une lettre
    var lettreChoisie = '';
    var positionChoisie = '';
    $('.choix').on('click', function(e){
        lettreChoisie = e.currentTarget.childNodes[0].data;
    });
    $('.position').on('click', function(e){
        positionChoisie = e.currentTarget.id;
        console.log(positionChoisie);
        console.log(lettreChoisie);
        $('#'+positionChoisie).addClass('lettre');
        $('#'+positionChoisie).append(lettreChoisie);
        lettreChoisie = '';
    });

});
