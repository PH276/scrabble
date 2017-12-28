<?php
// require_once ('inc/init.inc.php');

$tirage = (isset($_SESSION['tirage']))?$_SESSION['tirage']:'';
if (strlen($tirage) < 7){
    $piocheNonMelangee = '';
    foreach ($_SESSION['lettres'] as $key => $Lettres) {
        $piocheNonMelangee .= str_repeat ($key, $Lettres['nb']);
    }

    $piocheMelangee = str_shuffle($piocheNonMelangee);
    $nouveauTirage = substr($piocheMelangee, 0, 7 - strlen($tirage));

    for ($i = 0 ; $i < strlen($nouveauTirage) ; $i++){
        $nouvelleLettreTiree = substr($nouveauTirage, $i, 1);
        --$_SESSION['lettres'][$nouvelleLettreTiree]['nb'];

        // enregistrement en BDD du nombre de lettres restantes pour la lettre choisie
        $req = $pdo -> prepare("UPDATE lettres SET nombreRestant = nombreRestant - 1 WHERE lettre = :nouvelleLettreTiree");
        $req -> bindParam(':nouvelleLettreTiree', $nouvelleLettreTiree, PDO::PARAM_STR);
        $req -> execute();
        $rep[$nouvelleLettreTiree] = $_SESSION['lettres'][$nouvelleLettreTiree]['nb'];
    }
    $tirage .= $nouveauTirage;

    $_SESSION['tirage'] = $tirage;
    $_SESSION['joueurs'][0]['tirage'] = $tirage;
    $_SESSION['joueurs'][1]['tirage'] = $tirage;

    // enregistrement du tirage en base de données
    $req = $pdo -> prepare("UPDATE infos SET info=:info WHERE info_type='tirage'");
    $req -> bindParam(':info', $tirage, PDO::PARAM_STR);
    $req -> execute();

    $req = $pdo -> query("UPDATE joueurs SET tirage='$tirage'");
    $req -> execute();

}

// include ('inc/tirage.inc.php');
$rep['tirage'] = '';

$lettreTirees = $tirage;
 // onclick="ecouteurChoix(this)"
for ($i = 0 ; $i < strlen($lettreTirees) ; $i++) {
    $lettre = substr($lettreTirees, $i, 1);
    $pts = $_SESSION['lettres'][$lettre]['pts'];
    if (($lettre == '_')) {
        $rep['tirage'] .= "<td class='choix case blanc lettre'>$lettre</td>";
    } else {
        $rep['tirage'] .= "<td class='choix case lettre'>$lettre<span>$pts</span></td>";
    }
}
