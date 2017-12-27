<?php
require_once('inc/init.inc.php');
// nouvelle partie
// debug($_SESSION);

// mise à zéro du tirage
videTirage($pdo);
$rep['msg'] = '';
unset($_SESSION['tirage']);


// MAJ pour le nombre de lettres restantes
$req = $pdo -> query("UPDATE lettres SET nombreRestant = nombre");
$_SESSION['lettres'] = array();

// initialisation de la session des lettres restantants
// $req = $pdo -> query("SELECT lettre, nombreRestant FROM lettres");
// $lettres = $req -> fetchAll(PDO::FETCH_ASSOC);

// foreach ($lettres as $lettre){
//     $_SESSION['lettres'][$lettre['lettre']] = $lettre['nombreRestant'];
// }

// initialisation de la session du jeu
$req = $pdo -> query("DELETE FROM jeu");
$_SESSION['jeu'] = array();

// $rep['tirage'] = '<td></td>';

// $_SESSION['tirage'] = '';
// $_SESSION['jeu'] = array();
// $_SESSION['joueurs'][0]['joue'] = false;
// $_SESSION['joueurs'][1]['joue'] = false;
// $_SESSION['tour_passe'] = false;


// Initialisation des résultats
$req = $pdo -> exec ("DELETE FROM resultats WHERE id_partie = '1'");
$req = $pdo -> exec ("INSERT INTO resultats ( id_partie, tour) VALUES ('1', '1')");
// $_SESSION['tour'] = 1;

$_SESSION = array();
session_destroy();
header('location: connexion.php#prenom');
