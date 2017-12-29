<?php
$lignePosition = ord(substr($positionMot, 0, 1));
$colonnePosition = substr($positionMot, 1);

for ($i = 0 ; $i < strlen($motRretenu) ; $i++){
    if ($sensMot == 'H'){
        $positionLettre = chr($lignePosition).($colonnePosition + $i);
    }else {
        $positionLettre = chr($lignePosition + $i).($colonnePosition);
    }
    $req = $pdo -> prepare ("INSERT INTO jeu (position, lettre) VALUES (:position, :lettre)");
    $req -> execute(array(
        'position' => $positionLettre,
        'lettre' => substr($motRretenu, $i, 1)
    ));
}
