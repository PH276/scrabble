<?php
require_once ('inc/init.inc.php');

// MAJ du nombre de lettres restantes pour les lettres vidées
for ($i = 0 ; $i < strlen($_SESSION['tirage']) ; $i++){
    $lettre = substr($_SESSION['tirage'], $i, 1);
    ++$_SESSION['lettres'][$lettre];
    $req = $pdo -> prepare("UPDATE lettres SET nombreRestant=nombreRestant+1 WHERE lettre = :lettre");
    $req -> bindParam(':lettre', $lettre, PDO::PARAM_STR);
    $req -> execute();

    $rep[$lettre] = $_SESSION['lettres'][$lettre];
}

// mise à zéro du tirage
include_once('inc/videTirage.inc.php');
$_SESSION['tirage'] = '';

$rep['msg'] = '';
// $rep['tirage'] = '';

echo json_encode($rep);
