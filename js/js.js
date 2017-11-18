$(document).ready(function() {
    // choix d'une lettre de réserve
    $('.reserve').on('click', function(e){
        frm = $('#form-lettre-choisie')[0];
        console.log(frm.lettreChoisie.value);
        frm.lettreChoisie.value = e.currentTarget.childNodes[0].data;
        frm.submit();
    });

    // positionner une lettre lettre choisie du tirage
    var lettreChoisie = '';
    var positionChoisie = '';
    // choix d'une lettre
    $('.choix').on('click', function(e){
        lettreChoisie = e.currentTarget.childNodes[0].data;
        // choix de la position où placer la lettre choisie
        $('.position').on('click', function(e){
            positionChoisie = e.currentTarget.id;
            console.log(positionChoisie);
            console.log(lettreChoisie);
            $('#'+positionChoisie).addClass('lettre');
            $('#'+positionChoisie).append(lettreChoisie);
            lettreChoisie = '';
            $('.position').off('click');
        });
    });

});

// ================ ajax ===============================
function ajax(para, fich_php, reponseAttendue, position){
    // para : parametres à envoyer à la requête
    // fich_php : fichier auquel envoyer la requête
    // reponseAttendue : reponse attendue (true ou false)
    var r = new XMLHttpRequest();
    r.open("POST", fich_php, true);
    r.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    r.send(para);
    r.onreadystatechange = function(){
        // console.log(r.responseText);
        if (reponseAttendue){

            if (r.readyState == 4 && r.status == 200){
                // console.log(r.responseText);
                var obj = JSON.parse(r.responseText);
                // console.log(obj['montableau']);

                document.getElementById(position).innerHTML = obj;
            }
        }
    };
}

$('#newPartie').on('click', function(){
    ajax('', 'newPartieAjax.php', true, 'tirage');

    // var p = document.getElementById("personne");
    //
    // var personne = p.value;
    // // console.log(personne);
    //
    // var parameters = "personne=" + personne;
    // ajax(parameters);
});


// ================ fin ajax ===============================
