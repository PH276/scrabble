<?php
require_once('inc/init.inc.php');
$lettreChoisie = $_POST['lettreChoisie'];
$motPropose = $_POST['motPropose'];
$rep['msg'] = '';

// retrait du tirage de la lettre ulisée
if ($_SESSION['joueur']['id'] == 1){
    $tirage = $_SESSION['joueurs'][0]['tirage'];
}else{
    $tirage = $_SESSION['joueurs'][1]['tirage'];
}

$i = strpos($tirage, $lettreChoisie);
$tirage = substr($tirage, 0, $i) . substr($tirage, $i+1);

$idJoueur = $_SESSION['joueur']['id'];
$_SESSION['joueurs'][$idJoueur-1]['tirage'] = $tirage;
$pdo->query("UPDATE joueurs SET tirage = '$tirage' WHERE id='$idJoueur'");

$rep['tirage'] = '';

for ($i = 0 ; $i < strlen($tirage) ; $i++) {
    $lettre = substr($tirage, $i, 1);
    $pts = $_SESSION['lettres'][$lettre]['pts'];
    if ($lettre == '_') {
        $rep['tirage'] .= "<td class='choix case blanc lettre'>$lettre</td>";
    } else {
        // $rep['tirage'] .= "<td class='choix case lettre'>".$lettre."</td>";
        $rep['tirage'] .= "<td class='choix case lettre'>$lettre<span>$pts</span></td>";
    }
}

$motPropose .= $lettreChoisie;
$rep['ligne-mot'] = '';
for ($i = 0 ; $i < strlen($motPropose) ; $i++) {
    $lettre = substr($motPropose, $i, 1);
    $pts = $_SESSION['lettres'][$lettre]['pts'];
    // if ((substr($motPropose, $i, 1) == '_')) {
    //     $rep['ligne-mot'] .= '<td class="choix case blanc lettre">' .  substr($motPropose, $i, 1) . '</td>';
    // } else {
        // $rep['ligne-mot'] .= "<td class='case lettre'>".$lettre."</td>";
        $rep['ligne-mot'] .= "<td class='case lettre'>$lettre<span>$pts</span></td>";
    // }
}

echo json_encode($rep);
