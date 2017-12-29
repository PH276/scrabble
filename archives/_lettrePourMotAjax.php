<?php
require_once ('inc/init.inc.php');
$lettreChoisie = $_POST['lettreChoisie'];
$positionChoisie = $_POST['positionChoisie'];
$rep['msg'] = '';

// retrait du tirage de la lettre ulisée
$tirage = $_SESSION['tirage'];
$i = strpos($tirage, $lettreChoisie);
$tirage = substr($tirage, 0, $i) . substr($tirage, $i+1);

$_SESSION['tirage'] = $tirage;
$_SESSION['jeu'][$positionChoisie] = $lettreChoisie;

// enregistrement en BD de la position de la lettre
$req = $pdo -> prepare("INSERT INTO jeu (position, lettre) VALUES (:positionChoisie, :lettreChoisie)");
$req -> bindParam(':positionChoisie', $positionChoisie, PDO::PARAM_STR);
$req -> bindParam(':lettreChoisie', $lettreChoisie, PDO::PARAM_STR);
$req -> execute();

// MAJ du tirage en base de données
$req = $pdo -> prepare("UPDATE infos SET info=:info WHERE info_type='tirage'");
$req -> bindParam(':info', $_SESSION['tirage'], PDO::PARAM_STR);
$req -> execute();

$rep['tirage'] = '';
$lettreTirees = $tirage;
// $lettreTirees = '';
for ($i = 0 ; $i < strlen($lettreTirees) ; $i++) {
    if ((substr($lettreTirees, $i, 1) == '_')) {
        $rep['tirage'] .= '<td onclick="ecouteurChoix(this)" class="choix case blanc lettre">' .  substr($lettreTirees, $i, 1) . '</td>';
    } else {
        $rep['tirage'] .= '<td onclick="ecouteurChoix(this)" class="choix case lettre">' . substr($lettreTirees, $i, 1) . '</td>';
    }
}

echo json_encode($rep);
