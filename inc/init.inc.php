<?php
session_start();

$pdo = new PDO("mysql:host=localhost;dbname=scrabble", 'root', '', array(
    PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING,
    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'
));

require_once('inc/fonctions.inc.php');

if (!userConnecte()) {
    header('location:connexion.php');
}
