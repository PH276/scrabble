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
	// $req -> execute();
}

// verification d'un mot proposé
// function verifMot($motpropose, $position, $sens, $tirage, $pdo){
//
// 	for ($i = 0 ; $i < strlen($motpropose) ; $i++){
// 		$lettreMot = substring($motpropose, $i, 1);
// 		if
// 		$req = $pdo->query("SELECT lettre FROM jeu WHERE position=$lettreMot");
// 		$lettreJeu = $req->fetch();
// 			if ($lettreMot == $lettreJeu['lettre'] && ){
//
// 			}else {
// 				$lettreTirage
// 			}
//
// 	}
// }
