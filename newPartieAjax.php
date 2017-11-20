<?php
require_once ('inc/init.inc.php');
// nouvelle partie
// session_destroy();
// unset($_SESSION['lettres']);
// unset($_SESSION['tirage']);
// mise à zéro du tirage
include_once('inc/videTirage.inc.php');
$rep['msg'] = '';

// MAJ de la BDD pour le nombre de lettres restantes
$req = $pdo -> query("UPDATE lettres SET nombreRestant = nombre");
$req -> execute();

// initialisation de la session des lettres restantants
$req = $pdo -> query("SELECT lettre, nombreRestant FROM lettres");
$lettres = $req -> fetchAll(PDO::FETCH_ASSOC);

// initialisation de la session des lettres restantants
$req = $pdo -> query("DELETE FROM jeu");
$req -> execute();

foreach ($lettres as $lettre){
    $_SESSION['lettres'][$lettre['lettre']] = $lettre['nombreRestant'];
}

// $rep['tirage'] = '<td></td>';

$_SESSION['tirage'] = '';
$rep['tirage'] = '';
$_SESSION['jeu'] = array();

echo json_encode($rep);
