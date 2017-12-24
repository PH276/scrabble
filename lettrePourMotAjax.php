<?php
require_once ('inc/init.inc.php');
$lettreChoisie = $_POST['lettreChoisie'];
$motPropose = $_POST['motPropose'];
$rep['msg'] = '';

// retrait du tirage de la lettre ulisée
if ($_SESSION['joueur']['id'] == 0){
    $tirage = $_SESSION['tirage1'];
}else{
    $tirage = $_SESSION['tirage2'];
}

$i = strpos($tirage, $lettreChoisie);
$tirage = substr($tirage, 0, $i) . substr($tirage, $i+1);

if ($_SESSION['joueur']['id'] == 0){
    $_SESSION['tirage1'] = $tirage;
}else{
    $_SESSION['tirage2'] = $tirage;
}

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
