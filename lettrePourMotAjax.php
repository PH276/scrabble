<?php
require_once ('inc/init.inc.php');
$lettreChoisie = $_POST['lettreChoisie'];
$motPropose = $_POST['motPropose'];
$rep['msg'] = '';

// retrait du tirage de la lettre ulisée
if ($_SESSION['joueur']['id'] == 0){
    $tirage = $_SESSION['joueurs'][0]['tirage'];
}else{
    $tirage = $_SESSION['joueurs'][1]['tirage'];
}

$i = strpos($tirage, $lettreChoisie);
$tirage = substr($tirage, 0, $i) . substr($tirage, $i+1);

$idJoueur = $_SESSION['joueur']['id'];
$_SESSION['joueurs'][$idJoueur]['tirage'] = $tirage;
$pdo->req("UPDATE joueurs SET tirage = '$tirage' WHERE id='$idJoueur'")

$rep['tirage'] = '';

for ($i = 0 ; $i < strlen($tirage) ; $i++) {
    if ((substr($tirage, $i, 1) == '_')) {
        $rep['tirage'] .= '<td class="choix case blanc lettre">' .  substr($tirage, $i, 1) . '</td>';
    } else {
        $rep['tirage'] .= '<td class="choix case lettre">' . substr($tirage, $i, 1) . '</td>';
    }
}

// $motPropose .= $lettreChoisie;
// $rep['ligne-mot'] = '';
// for ($i = 0 ; $i < strlen($motPropose) ; $i++) {
//     if ((substr($motPropose, $i, 1) == '_')) {
//         $rep['ligne-mot'] .= '<td class="choix case blanc lettre">' .  substr($motPropose, $i, 1) . '</td>';
//     } else {
//         $rep['ligne-mot'] .= '<td class="choix case lettre">' . substr($motPropose, $i, 1) . '</td>';
//     }
// }

echo json_encode($rep);
