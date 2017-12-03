<?php

// Fonction pour afficher les debug (print_r())
function debug($tab){
	echo '<div style="color: white; padding: 20px; font-weight: bold; background:#' . rand(111111, 999999) . '">';

	$trace = debug_backtrace(); // Retourne les infos sur l'emplacement où est exécutée une fonction
	echo 'Le debug a été demandé dans le fichier : ' . $trace[0]['file'] . ' à la ligne : ' . $trace[0]['line'] . '<hr/>';

	echo '<pre>';
	print_r($tab);
	echo '</pre>';

	echo '</div>';
}

// paramètres de traitement d'une table en fonction de celle choisie

// fonction pour voir si un utilisateur est connecté:
function userConnecte(){
	if(isset($_SESSION['joueur'])){
		return TRUE;
	}
	else{
		return FALSE;
	}
}
// Cette fonction nous retourne TRUE si l'utilisateur est connecté et false, s'il ne l'est pas.

// Fonction pour voir si l'utilisateur est admin :
function userAdmin(){
	if(userConnecte() && $_SESSION['joueur']['statut'] == 1){
		return TRUE;
	}
	else{
		return FALSE;
	}
}
// Si l'utilisateur est connecté... et en plus si son statut c'est 1 alors il a les droits d'admin et pourra accéder au backoffice.
