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

// mise à zéro du tirage
function videTirage($pdo){
	$req = $pdo -> query("UPDATE infos SET info='' WHERE info_type='tirage'");
	$req = $pdo -> query("UPDATE joueurs SET tirage=''");
	// $req -> execute();
}

function idJoueurEnAttente($pdo){
	$req = $pdo -> query("SELECT mot_joueur1, mot_joueur2 FROM resultats ORDER BY tour DESC LIMIT 0, 1");
	$derniersResultats = $req -> fetch(PDO::FETCH_ASSOC);
	extract($derniersResultats);
	if ($mot_joueur1 == '' && $mot_joueur2 != ''){
		return 1;
	} elseif ($mot_joueur1 != '' && $mot_joueur2 == ''){
		return 2;
	}

	return 0;

}
