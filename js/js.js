$(document).ready(function() {

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
                $('#'+cle).html(obj[cle]);
                // document.getElementById(cle).innerHTML = obj[cle];
            }

            $('.choix').on('click', function(e){
                // console.log(e.currentTarget.innerHTML);
                $('#nouveauTirage').off('click');
                $('#vider').off('click');

                ecouteurChoix(e.currentTarget.innerHTML);
            });


        });
    }
    // ================ fin ajax ===============================

    var isLettreChoisie = false;
    // ================ function ecouteurChoix ===============================
    function ecouteurChoix(lettreChoisie){
        // console.log(lettreChoisie);

        // positionner une lettre lettre choisie du tirage
        // var positionChoisie = '';
        // choix d'une lettre
        motPropose = proposition.mot.value;
        // motPropose = $('#motPropose').html();
        // proposition = $('#proposition')[0];
        // console.log(proposition);
        // td = $('<td></td>');
        // td.html(lettreChoisie);
        // td.addClass('case lettre');
        // mot = $('#ligne-mot');
        // td.appendTo(mot);
        // console.log(td);
        //
        proposition.mot.value += lettreChoisie;
        // $('#motPropose').html(motPropose + lettreChoisie);
        // console.log(motPropose);
        // choix de la position où placer la lettre choisie
        // isLettreChoisie = false;
        parameters = "lettreChoisie="+lettreChoisie;
        parameters += "&motPropose="+motPropose;
        console.log('parameters='+parameters);
        ajax(parameters, 'lettrePourMotAjax.php', true);
        // lettreChoisie = '';!!!

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
    // ================ fin function ecouteurChoix ===============================

    // tirage automatique
    $('#nouveauTirage').on('click', function(e){
        ajax('', 'tirageAutomatiqueAjax.php', true);

        $('.choix').on('click', function(e){
            console.log(e);

            ecouteurChoix(e);
        });


    });


    // choix de renouveller le tirage
    $('#vider').on('click', function(e){
        ajax('', 'videTirageAjax.php', true);
        ajax('', 'tirageAutomatiqueAjax.php', true);

        $('.choix').on('click', function(e){
            console.log(e);

            ecouteurChoix(e);
        });

    });


    // choix d'une lettre du tirage pour composer un mot à proposer
    $('.choix').on('click', function(e){
        $('#nouveauTirage').off('click');
        $('#vider').off('click');


        ecouteurChoix(e.currentTarget.innerHTML);
    });


    // demande à voir les lettres restantes
    $('#bg').on('click', function(e){
        $('#lettres-reserve').show();
    });

    // demande à voir le score
    $('#bd').on('click', function(e){
        $('#scores').show();
    });

    // fermer la visibilité des lettres restantes
    $('#ferme-reserve').on('click', function(e){
        $('#lettres-reserve').hide();
    });

    // fermer la fenêtre d'affichage du score
    $('#ferme-score').on('click', function(e){
        $('#scores').hide();
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




// });
// choix d'une lettre de réserve
// $('.reserve').on('click', function(e){
//     lettreChoisie = e.currentTarget.childNodes[0].data;
//     var parameters = "lettreChoisie=" + lettreChoisie;
//     ajax(parameters, 'uneLettreTireeAjax.php', true);
// });
