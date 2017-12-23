$(document).ready(function() {
    $('#bg').on('click', function(e){
        $('#lettres-reserve').toggle('hidden');
    });

    $('#bd').on('click', function(e){
        $('#scores').toggle('hidden');
    });
});

// $(document).ready(function() {
    // $('.choix').on('click', function(e){
    //     // console.log(e.currentTarget.innerHTML);
    //
    //     ecouteurChoix(e.currentTarget.innerHTML);
    // });
// });
// choix d'une lettre de réserve
// $('.reserve').on('click', function(e){
//     lettreChoisie = e.currentTarget.childNodes[0].data;
//     var parameters = "lettreChoisie=" + lettreChoisie;
//     ajax(parameters, 'uneLettreTireeAjax.php', true);
// });


// ================ ajax ===============================
function ajax(para, fich_php, reponseAttendue){
    // para : parametres à envoyer à la requête
    // fich_php : fichier auquel envoyer la requête
    // reponseAttendue : reponse attendue (true ou false)
    // position : position où sera inséré du code html en fonction de la reponse
    $.ajax({
        method: "POST",
        url : fich_php,
        data: para
    }).done(function(responseText){
        // console.log(r.responseText);
        var obj = $.parseJSON(responseText);
        // console.log(obj);
        for (var cle in obj){
            document.getElementById(cle).innerHTML = obj[cle];
        }

        $('.choix').on('click', function(e){
            // console.log(e.currentTarget.innerHTML);

            ecouteurChoix(e.currentTarget.innerHTML);
        });


    });
}

// // nouvelle partie
// $('#newPartie').on('click', function(){
//     ajax('', 'newPartieAjax.php', false);
//     window.location.reload();
// });
//




var isLettreChoisie = false;
function ecouteurChoix(lettreChoisie){
    console.log(lettreChoisie);

    // positionner une lettre lettre choisie du tirage
    // var positionChoisie = '';
    // choix d'une lettre
    motPropose = $('#motPropose').html();
    // proposition = $('#proposition')[0];
    console.log(proposition);
    td = $('<td></td>');
    td.html(lettreChoisie);
    td.addClass('case lettre');
    mot = $('#ligne-mot');
    td.appendTo(mot);
    // console.log(td);
    //
    proposition.mot.value += lettreChoisie;
    // $('#motPropose').html(motPropose + lettreChoisie);
    // console.log(motPropose);
    // choix de la position où placer la lettre choisie
    // isLettreChoisie = false;
    parameters = "lettreChoisie="+lettreChoisie;
    parameters += "&motPropose="+motPropose;
    ajax(parameters, 'lettrePourMotAjax.php', true);
    // lettreChoisie = '';

    // $('.position').on('click', function(e){
    //     isLettreChoisie = false;
    //     positionChoisie = e.currentTarget.id;
    //     console.log(positionChoisie);
    //     console.log(lettreChoisie);
    //     $('#'+positionChoisie).removeClass('case-valeur')
    //     $('#'+positionChoisie).addClass('lettre');
    //     $('#'+positionChoisie).append(lettreChoisie);
    //     $('.position').off('click');
    //     parameters = "lettreChoisie="+lettreChoisie;
    //     parameters += "&positionChoisie="+positionChoisie;
    //     ajax(parameters, 'lettrePourMotAjax.php', true);
    //     lettreChoisie = '';
    //
    // });
}


// choix de renouveller le tirage
$('#vider').on('click', function(e){
    ajax('', 'videTirageAjax.php', true);
    ajax('', 'tirageAutomatiqueAjax.php', true);

    $('.choix').on('click', function(e){
        console.log(e);

        ecouteurChoix(e);
    });

});

// tirage automatique
$('#nouveauTirage').on('click', function(e){
    ajax('', 'tirageAutomatiqueAjax.php', true);

    $('.choix').on('click', function(e){
        console.log(e);

        ecouteurChoix(e);
    });


});

// proposition d'un mot"
// $('#proposition').on('submit', function(e){
//     e.preventDefault();
//     proposition = $(this)[0].elements;
//     var parameters = $('#proposition').serialize();
//     console.log(parameters);
//
//     $.ajax({
//         type : "POST",
//         data : parameters,
//         url : "motPropose.php"
//     }).done(function(responseText){
//         // var obj = $.parseJSON(responseText);
//         $('#mot-propose').attr('disabled', true);
//         // $('#proposition').trigger('reset');
//     });



// ajax('', 'tirageAutomatiqueAjax.php', true);
// });




// ================ fin ajax ===============================

// });
