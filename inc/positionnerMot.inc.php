<?php
$lignePosition = ord(substr($positionMot, 0, 1));
$colonnePosition = substr($positionMot, 1);

// récupération du tirage au début du tourt en cours
$req = $pdo -> query("SELECT info FROM infos WHERE info_type='tirage'");
$tirage = $req->fetch(PDO::FETCH_ASSOC);
$_SESSION['tirage'] = $tirage['info'];
$tirage = $_SESSION['tirage'];

// boucle sur les lettres du mot retenu
for ($i = 0 ; $i < strlen($motRretenu) ; $i++){
    // position d'une lettre en fonction de  l'orientation dans laquelle le mot sera posé
    if ($sensMot == 'H'){
        $positionLettre = chr($lignePosition).($colonnePosition + $i);
    }else {
        $positionLettre = chr($lignePosition + $i).($colonnePosition);
    }

    // enregistrement de la lettre posée
    $req = $pdo -> prepare ("INSERT INTO jeu (position, lettre) VALUES (:position, :lettre)");
    $req -> execute(array(
        'position' => $positionLettre,
        'lettre' => substr($motRretenu, $i, 1)
    ));

    // retrait de la lettre posée du tirage
    $j = strpos($tirage, substr($motRretenu, $i, 1));
    $tirage = substr($tirage, 0, $j) . substr($tirage, $j+1);
}

// définition du tirage suite au mot retenu
$_SESSION['tirage'] = $tirage;
