<?php
require_once('inc/init.inc.php');
// récupération du tirage de la BD en cas de nouvelle session
$req = $pdo -> query("SELECT info FROM infos WHERE info_type='tirage'");
$tirage = $req->fetch(PDO::FETCH_ASSOC);
$_SESSION['tirage'] = $tirage['info'];

// récupération de la quantité des lettres restantes en cas de nouvelle session
$stockLettres = array();
$req = $pdo -> query("SELECT lettre, nombreRestant FROM lettres");
$lettres = $req -> fetchAll(PDO::FETCH_ASSOC);
foreach ($lettres as $lettre){
    $stockLettres[$lettre['lettre']] = $lettre['nombreRestant'];
}
$_SESSION['lettres'] = $stockLettres;

// récupération des lettres du jeu en cas de nouvelle session
$jeu = array();
$req = $pdo -> query("SELECT position, lettre FROM jeu");
$lettresJeu = $req -> fetchAll(PDO::FETCH_ASSOC);
foreach ($lettresJeu as $lettreJeu){
    $jeu[$lettreJeu['position']] = $lettreJeu['lettre'];
}
$_SESSION['jeu'] = $jeu;


// récupération de données des joueurs en cas de nouvelle session
$req = $pdo -> query("SELECT prenom FROM joueurs ORDER BY id");
$joueurs = $req -> fetchAll(PDO::FETCH_ASSOC);
$_SESSION['joueurs'][0]['joue'] = false;
$_SESSION['joueurs'][1]['joue'] = false;
$_SESSION['joueurs'][0]['prenom'] = $joueurs[0]['prenom'];
$_SESSION['joueurs'][1]['prenom'] = $joueurs[1]['prenom'];

//Résultats à afficher
$req = $pdo -> query("SELECT * FROM resultats WHERE id_partie = 1 AND mot_joueur1 <> '' AND mot_joueur2 <> ''");
$resultats = $req -> fetchAll(PDO::FETCH_ASSOC);

// enregistrement du tour en cours
$_SESSION['tour'] = $req->rowcount() + 1;

include('tirageAutomatique.php');
// echo '<pre>';
// print_r ($_SESSION);
// echo '</pre>';
// session_destroy();
// echo '<pre>';
// print_r ($_SESSION);
// echo '</pre>';


header('location: connexion.php');
