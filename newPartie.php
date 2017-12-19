<?php
require_once('inc/init.inc.php');

// session_destroy();
// nouvelle partie

// unset($_SESSION['lettres']);
// unset($_SESSION['tirage']);

// mise à zéro du tirage
// include('inc/videTirage.inc.php');
videTirage($pdo);
$rep['msg'] = '';

// MAJ de la BDD pour le nombre de lettres restantes
$req = $pdo -> query("UPDATE lettres SET nombreRestant = nombre");
$req -> execute();

// initialisation de la session des lettres restantants
$req = $pdo -> query("SELECT lettre, nombreRestant FROM lettres");
$lettres = $req -> fetchAll(PDO::FETCH_ASSOC);

foreach ($lettres as $lettre){
    $_SESSION['lettres'][$lettre['lettre']] = $lettre['nombreRestant'];
}

// initialisation de la session du jeu
$req = $pdo -> query("DELETE FROM jeu");
$req -> execute();

// $rep['tirage'] = '<td></td>';

$_SESSION['test'] = 'toto';
$_SESSION['tirage'] = '';
$_SESSION['jeu'] = array();
$_SESSION['joueurs'][0]['joue'] = false;
$_SESSION['joueurs'][1]['joue'] = false;
$_SESSION['tour_passe'] = false;
$_SESSION['tour'] = 1;


// Initialisation des résultats
$req = $pdo -> exec ("DELETE FROM resultats WHERE id_partie = '1'");
$req = $pdo -> exec ("INSERT INTO resultats ( id_partie, tour) VALUES ('1', '1')");
$_SESSION['tour'] = 1;

debug($_SESSION);
header('location: index.php');
