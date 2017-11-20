// ================ ajax ===============================
function ajax(para, fich_php, reponseAttendue){
    // para : parametres à envoyer à la requête
    // fich_php : fichier auquel envoyer la requête
    // reponseAttendue : reponse attendue (true ou false)
    // position : position où sera inséré du code html en fonction de la reponse

    var r = new XMLHttpRequest();
    // r.open("GET", fich_php, true);
    r.open("POST", fich_php, true);
    r.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    r.send(para);
    r.onreadystatechange = function(){
        // console.log(r.responseText);
        if (reponseAttendue){

            if (r.readyState == 4 && r.status == 200){
                // console.log(r.responseText);
                var obj = JSON.parse(r.responseText);
                // console.log(obj);
                for (var cle in obj){
                    document.getElementById(cle).innerHTML = obj[cle];
                }
            }
        }
    };
}


function ecouteurChoix(e){

    // positionner une lettre lettre choisie du tirage
    var lettreChoisie = '';
    var positionChoisie = '';
    // choix d'une lettre
    lettreChoisie = e.innerHTML;
    console.log(lettreChoisie);
    // choix de la position où placer la lettre choisie
    $('.position').on('click', function(e){
        positionChoisie = e.currentTarget.id;
        console.log(positionChoisie);
        console.log(lettreChoisie);
        $('#'+positionChoisie).addClass('lettre');
        $('#'+positionChoisie).append(lettreChoisie);
        $('.position').off('click');
        parameters = "lettreChoisie="+lettreChoisie;
        parameters += "&positionChoisie="+positionChoisie;
        ajax(parameters, 'lettrePourMotAjax.php', true);
        lettreChoisie = '';

    });
}

// $(document).ready(function() {

// nouvelle partie
$('#newPartie').on('click', function(){
    ajax('', 'newPartieAjax.php', false);
    window.location.reload();
});

// choix d'une lettre de réserve
$('.reserve').on('click', function(e){
    lettreChoisie = e.currentTarget.childNodes[0].data;
    var parameters = "lettreChoisie=" + lettreChoisie;
    ajax(parameters, 'uneLettreTireeAjax.php', true);
});

// choix d'une lettre de réserve
$('#vider').on('click', function(e){
    ajax('', 'videTirageAjax.php', true);
});

// ================ fin ajax ===============================

// });
