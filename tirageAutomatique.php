<?php
// require_once ('inc/init.inc.php');

$tirage = (isset($_SESSION['tirage']))?$_SESSION['tirage']:'';
if (strlen($tirage) < 7){
    $piocheNonMelangee = '';
    foreach ($_SESSION['lettres'] as $key => $nbLettres) {
        $piocheNonMelangee .= str_repeat ($key, $nbLettres);
    }

    $piocheMelangee = str_shuffle($piocheNonMelangee);
    $nouveauTirage = substr($piocheMelangee, 0, 7 - strlen($tirage));

    for ($i = 0 ; $i < strlen($nouveauTirage) ; $i++){
        $nouvelleLettreTiree = substr($nouveauTirage, $i, 1);
        --$_SESSION['lettres'][$nouvelleLettreTiree];

        // enregistrement en BDD du nombre de lettres restantes pour la lettre choisie
        $req = $pdo -> prepare("UPDATE lettres SET nombreRestant = nombreRestant - 1 WHERE lettre = :nouvelleLettreTiree");
        $req -> bindParam(':nouvelleLettreTiree', $nouvelleLettreTiree, PDO::PARAM_STR);
        $req -> execute();
        $rep[$nouvelleLettreTiree] = $_SESSION['lettres'][$nouvelleLettreTiree];
    }
    $tirage .= $nouveauTirage;

    $_SESSION['tirage'] = $tirage;
    $_SESSION['joueurs'][0]['tirage'] = $tirage;
    $_SESSION['joueurs'][1]['tirage'] = $tirage;

    // enregistrement du tirage en base de données
    $req = $pdo -> prepare("UPDATE infos SET info=:info WHERE info_type='tirage'");
    $req -> bindParam(':info', $tirage, PDO::PARAM_STR);
    $req -> execute();

    $req = $pdo -> query("UPDATE joueurs SET tirage=$tirage");

}

// include ('inc/tirage.inc.php');
$rep['tirage'] = '';

$lettreTirees = $tirage;
 // onclick="ecouteurChoix(this)"
for ($i = 0 ; $i < strlen($lettreTirees) ; $i++) {
    if ((substr($lettreTirees, $i, 1) == '_')) {
        $rep['tirage'] .= '<td class="choix case blanc lettre">' .  substr($lettreTirees, $i, 1) . '</td>';
    } else {
        $rep['tirage'] .= '<td class="choix case lettre">' . substr($lettreTirees, $i, 1) . '</td>';
    }
}
