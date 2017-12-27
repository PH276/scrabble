<?php
session_start();

$pdo = new PDO("mysql:host=localhost;dbname=scrabble", 'root', '', array(
    PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING,
    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'
));

$msg = "";

require_once('inc/fonctions.inc.php');
// debug($_SESSION);

$page = 'connexion';

// if (isset($_GET['action']) && $_GET['action']=='deconnexion'){
//     session_destroy();
//     header('location:index.php');
// }

// if (userAdmin()){
//     header('location:utilisateur.php');
// }
//
if (!empty($_POST)){

    // verification pseudo
    if (!empty($_POST['prenom']) && !empty($_POST['mdp'])){
        $resultat = $pdo->prepare("SELECT * FROM joueurs WHERE prenom = :prenom");
        $resultat->bindParam(':prenom', $_POST['prenom'], PDO::PARAM_STR);
        $resultat->execute();
        if ($resultat->rowCount() > 0){
            // nous aurions pu proposer 2 à 3 variantes de  son pseudo, en ayant vérifié qu'ils sont dispo
            $ligne_utilisateur = $resultat->fetch(PDO::FETCH_ASSOC);

            if ($ligne_utilisateur['mdp'] == $_POST['mdp']){ // tout est OK
                foreach($ligne_utilisateur as $key => $val){
                    if ($key != 'mdp' && $key != 'tirage'){
                        $_SESSION['joueur'][$key] = $val;
                    }
                }
                // $_SESSION['joueurs'][$ligne_utilisateur['id']-1]['prenom'] = $ligne_utilisateur['prenom'];
                // $_SESSION['tirage'] = '';
                // $_SESSION['jeu'] = array();
                // $_SESSION['joueurs'] = array();
                // $_SESSION['joueurs'][0]['joue'] = false;
                // $_SESSION['joueurs'][1]['joue'] = false;
                // $_SESSION['tour_passe'] = false;
                // $_SESSION['tour'] = 0;
                // print_r( $ligne_utilisateur);
                // debug($_SESSION);
                header("location:index.php");
            }
            else{
                $msg .= '<div class="erreur">mot de passe erroné.</div>';
            }
        }
        else{
            $msg .= '<div class="erreur">L\'prenom '.$_POST['prenom'].' n\'existe pas disponible, Veuillez en choisir un autre.</div>';
        }
    }
    else{
        $msg .=  '<div class="erreur">Veuillez renseigner un prenom et un mot de passe</div>';
    }
    // -----------------------------------------------------------
}

require_once ('inc/head.inc.php');
// require_once ('inc/nav.inc.php');
?>

<!--  contenu HTML  -->
<div class="container">
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <div id="connexion">
                <h1>Connexion</h1>

                <form method="post" action="">
                    <?= $msg; ?>

                    <div class="form-group">

                        <div class="form-group">
                            <label for="prenom">Prénom</label>
                            <input class="form-control" type="text" id="prenom" name="prenom" value="<?= (isset($_POST['prenom']))?$_POST['prenom']:'' ?>" >
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="mdp">Mot de passe</label>
                        <input class="form-control" type="password" id="mdp" name="mdp"  value="<?= (isset($mdp))?$mdp:'' ?>">
                    </div>

                    <input type="submit" class="btn btn-primary center-block" value="Se connecter">
                </form>
            </div><!-- fin <div id="connexion"> -->
            </div><!-- fin <div class="col-md-4 col-mad-offset-4"> -->
            </div><!-- fin <div class="row">         -->
            </div><!-- fin     <div class="container"> -->
