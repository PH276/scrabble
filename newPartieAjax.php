<?php
require_once ('inc/init.inc.php');
// nouvelle partie
// session_destroy();
// unset($_SESSION['lettres']);
// unset($_SESSION['tirage']);
// mise à zéro du tirage
include_once('inc/videTirage.inc.php');

// MAJ de la BDD pour le nombre de lettres restantes
$req = $pdo -> query("UPDATE lettres SET nombreRestant = nombre");
$req -> execute();

// initialisation de la session des lettres restantants
$req = $pdo -> query("SELECT lettre, nombreRestant FROM lettres");
$lettres = $req -> fetchAll(PDO::FETCH_ASSOC);

foreach ($lettres as $lettre){
    $_SESSION['lettres'][$lettre['lettre']] = $lettre['nombreRestant'];
}

$rep = '';
$rep .= '<tr>';
$rep .= '<td class="case"></td>';
$rep .= '<form method="post">';
$rep .= '    <td><input type="submit" name="vider" value="Vider"></td>';
$rep .= '</form>';
$rep .= '<tr>';

$_SESSION['tirage'] = '';

echo json_encode($rep);
