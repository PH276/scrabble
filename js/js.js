$(document).ready(function() {
    $('.lettre').on('click', function(e){
        frm = $('#form-lettre-choisie')[0];
        console.log(frm.lettreChoisie.value);
        frm.lettreChoisie.value = e.currentTarget.childNodes[0].data;
        frm.submit();
    });

    // $('.blanc').on('click', function(e){
    //     frm = $('#form-lettre-choisie')[0];
    //     console.log(frm.lettreChoisie.value);
    //     frm.lettreChoisie.value = '_';
    //     frm.submit();
    // });
});
