<?php

// préparation à l'affichage des lettres piochées

$rep['tirage'] = '';
$lettreTirees = $_SESSION['tirage'];

for ($i = 0 ; $i < strlen($lettreTirees) ; $i++) {
    if ((substr($lettreTirees, $i, 1) == '_')) {
        $rep['tirage'] .= '<td class="choix case blanc lettre">'. substr($lettreTirees, $i, 1) . '</td>';
    } else {
        $rep['tirage'] .= '<td class="choix case lettre">' . substr($lettreTirees, $i, 1) . '</td>';
    }
}
