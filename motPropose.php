<?php
require_once ('inc/init.inc.php');
// enregistrement d'un mot proposé par le joueur 1
debug($_POST);
if (isset ($_POST['points']) && isset($_POST['mot']) && isset($_POST['position']) && isset($_POST['sens'])){
    if ($_SESSION['joueur']['id'] == 1){

        $req = $pdo -> prepare("UPDATE resultats SET resultat_joueur1 = :points, mot_joueur1 = :mot  WHERE id_partie = '1' AND tour = :tour");
        $req -> bindParam (':points', $_POST['points'], PDO::PARAM_INT);
        $req -> bindParam (':mot', $_POST['mot'], PDO::PARAM_STR);
        $req -> bindParam (':tour', $_SESSION['tour'], PDO::PARAM_INT);
        $req -> execute();

        $_SESSION['joueurs'][0]['joue'] = true;

        if ($_SESSION['joueurs'][1]['joue']){
            ++$_SESSION['tour'];
            $_SESSION['joueurs'][0]['joue'] = false;
            $_SESSION['joueurs'][1]['joue'] = false;
            $req = $pdo -> prepare ("INSERT INTO resultats ( id_partie, tour) VALUES ('1', :tour)");
            $req -> bindParam (':tour', $_SESSION['tour'], PDO::PARAM_INT);
            $req -> execute();
        }

    }
    // enregistrement d'un mot proposé par le joueur 2
    if ($_SESSION['joueur']['id'] == 2){
        $req = $pdo -> prepare("UPDATE resultats SET resultat_joueur2 = :points, mot_joueur2 = :mot  WHERE id_partie = '1' AND tour = :tour");
        $req -> bindParam (':points', $_POST['points'], PDO::PARAM_INT);
        $req -> bindParam (':mot', $_POST['mot'], PDO::PARAM_STR);
        $req -> bindParam (':tour', $_SESSION['tour'], PDO::PARAM_INT);
        $req -> execute();

        $_SESSION['joueurs'][1]['joue'] = true;

        if ($_SESSION['joueurs'][0]['joue']){
            ++$_SESSION['tour'];
            $_SESSION['joueurs'][0]['joue'] = false;
            $_SESSION['joueurs'][1]['joue'] = false;
            $req = $pdo -> prepare ("INSERT INTO resultats ( id_partie, tour) VALUES ('1', :tour)");
            $req -> bindParam (':tour', $_SESSION['tour'], PDO::PARAM_INT);
            $req -> execute();
        }
    }

    //Résultats
    $req = $pdo -> query("SELECT * FROM resultats WHERE id_partie = 1 AND mot_joueur1 <> '' AND mot_joueur2 <> ''");
    $resultats = $req -> fetchAll(PDO::FETCH_ASSOC);
}
header('location:index.php');
