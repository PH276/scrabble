<?php
require_once ('inc/init.inc.php');
// enregistrement d'un mot proposé par le joueur 1
// debug($_POST);
if (isset ($_POST['points']) && isset($_POST['mot']) && isset($_POST['position']) && isset($_POST['sens'])){

    $idJoueur = $_SESSION['joueur']['id'];

    // enregistrement d'un mot proposé par le joueur 1
    if ($idJoueur == 1){
        $req = $pdo -> prepare("UPDATE resultats SET resultat_joueur1 = :points, mot_joueur1 = :mot, position_mot = :position, sens = :sens WHERE id_partie = '1' AND tour = :tour");
    }

    // enregistrement d'un mot proposé par le joueur 2
    if ($idJoueur == 2){
        $req = $pdo -> prepare("UPDATE resultats SET resultat_joueur2 = :points, mot_joueur2 = :mot, position_mot = :position, sens = :sens WHERE id_partie = '1' AND tour = :tour");
    }

    $req -> bindParam (':tour', $_SESSION['tour'], PDO::PARAM_INT);
    $req -> bindParam (':points', $_POST['points'], PDO::PARAM_INT);
    $req -> bindParam (':mot', $_POST['mot'], PDO::PARAM_STR);
    $req -> bindParam (':position', $_POST['position'], PDO::PARAM_STR);
    $req -> bindParam (':sens', $_POST['sens'], PDO::PARAM_STR);
    $req -> execute();

    //Résultats
    $req = $pdo -> query("SELECT * FROM resultats WHERE id_partie = 1 AND mot_joueur1 <> '' AND mot_joueur2 <> '' ORDER BY tour DESC LIMIT 0, 1");
    $resultats = $req -> fetch(PDO::FETCH_ASSOC);
    // debug($resultats);

    if ($resultats != false){
        $_SESSION['unJoueurEnAttente'] = false;
        // debug($resultats);
        extract($resultats);
        if ($idJoueur == 1){
            $positionMotJoueur1 = $_POST['position'];
            $positionMotJoueur2 = $position_mot;
            $sensMotJoueur1 = $_POST['sens'];
            $sensMotJoueur2 = $sens;
        }else {
            $positionMotJoueur1 = $position_mot;
            $positionMotJoueur2 = $_POST['position'];
            $sensMotJoueur1 = $sens;
            $sensMotJoueur2 = $_POST['sens'];
        }
        // debug($_SESSION);
        if ($_SESSION['tour'] == $tour){


            if ($resultat_joueur1 > $resultat_joueur2){
                $_SESSION['tirage'] = $_SESSION['joueurs'][0]['tirage'];
                $motRretenu = $mot_joueur1;
                $positionMot = $positionMotJoueur1;
                $sensMot = $sensMotJoueur1;
            }else {
                $_SESSION['tirage'] = $_SESSION['joueurs'][1]['tirage'];
                $motRretenu = $mot_joueur2;
                $positionMot = $positionMotJoueur2;
                $sensMot = $sensMotJoueur2;
            }

            include ('inc/positionnerMot.inc.php');

            $req = $pdo->prepare("UPDATE infos SET info = :tirage WHERE info_type = 'tirage'");
            $req->execute(array(
                ':tirage' => $_SESSION['tirage']
            ));

            ++$_SESSION['tour'];
            $_SESSION['joueurs'][0]['joue'] = false;
            $_SESSION['joueurs'][1]['joue'] = false;
            $req = $pdo -> prepare ("INSERT INTO resultats ( id_partie, tour) VALUES ('1', :tour)");
            $req -> bindParam (':tour', $_SESSION['tour'], PDO::PARAM_INT);
            $req -> execute();
            include('tirageAutomatique.php');

        }

    }
    else {
        $_SESSION['unJoueurEnAttente'] = true;
    }
}
// debug($_SESSION);
header('location:index.php');
