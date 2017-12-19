<?php
require_once ('inc/init.inc.php');
$lettreChoisie = $_POST['lettreChoisie'];
$rep['msg'] = '';

if (strlen($_SESSION['tirage']) < 7){
    // $lettreChoisie = $_POST['lettreChoisie'];
    // $lettreChoisie = $_POST['lettreChoisie'];

    if ($_SESSION['lettres'][$lettreChoisie] > 0){
        --$_SESSION['lettres'][$lettreChoisie];

        $_SESSION['tirage'] .= $lettreChoisie;

        // enregistrement du tirage en base de données
        $req = $pdo -> prepare("UPDATE infos SET info=:info WHERE info_type='tirage'");
        $req -> bindParam(':info', $_SESSION['tirage'], PDO::PARAM_STR);
        $req -> execute();

        // enregistrement en BDD du nombre de lettres restantes pour la lettre choisie
        $req = $pdo -> prepare("UPDATE lettres SET nombreRestant = :nombreRestant WHERE lettre = :lettreChoisie");
        $req -> bindParam(':nombreRestant', $_SESSION['lettres'][$lettreChoisie], PDO::PARAM_INT);
        $req -> bindParam(':lettreChoisie', $lettreChoisie, PDO::PARAM_STR);
        $req -> execute();
    }
    else{
        $rep['msg'] = "Il n'y a plus de $lettreChoisie.<br>";
    }
}
else{
    $rep['msg'] = "Il y a déjà 7 lettres.<br>";
}

// include ('inc/tirage.inc.php');
$rep['tirage'] = '';
// $rep['tirage'] = '<td></td>';

$lettreTirees = $_SESSION['tirage'];
for ($i = 0 ; $i < strlen($lettreTirees) ; $i++) {
    if ((substr($lettreTirees, $i, 1) == '_')) {
        $rep['tirage'] .= '<td class="choix case blanc lettre">' .  substr($lettreTirees, $i, 1) . '</td>';
    } else {
        $rep['tirage'] .= '<td class="choix case lettre">' . substr($lettreTirees, $i, 1) . '</td>';
    }
}

echo json_encode($rep);
