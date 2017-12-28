<?php

// préparation à l'affichage des lettres piochées

$rep['tirage'] = '';
$lettreTirees = $_SESSION['tirage'];

for ($i = 0 ; $i < strlen($lettreTirees) ; $i++) {
    $lettre = substr($lettreTirees, $i, 1);
    $pts = $_SESSION['lettres'][$lettre]['pts'];
    if (($lettre == '_')) {
        $rep['tirage'] .= '<td class="choix case blanc lettre">'. $lettre . '</td>';
    } else {
        $rep['tirage'] .= "<td class='choix case lettre'>$lettre<span>$pts</span></td>";
    }
}
