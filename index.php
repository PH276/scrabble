<?php
require_once ('inc/init.inc.php');
if (!userConnecte()) {
    header('location:connexion.php#prenom');
}
// debug($_SESSION);

// initialisation  comme quoi les 2 joueurs n'ont pas joué dans le tour en cours
$_SESSION['unJoueurEnAttente'] = false;

// cas d'une demande de nouvelle partie
// if (isset($_POST['newPartie'])){
//     header('newPartie.php');
// }


// if (empty($_SESSION)){

// récupération du tirage

// récupération du tirage de la BD en cas de nouvelle session
// if (!isset($_SESSION['tirage'])){
$req = $pdo -> query("SELECT info FROM infos WHERE info_type='tirage'");
$tirage = $req->fetch(PDO::FETCH_ASSOC);
$_SESSION['tirage'] = $tirage['info'];
// }

// récupération de la quantité des lettres restantes en cas de nouvelle session
// if (!isset($_SESSION['lettres'])){
$stockLettres = array();
$req = $pdo -> query("SELECT lettre, nombreRestant FROM lettres");
$lettres = $req -> fetchAll(PDO::FETCH_ASSOC);
foreach ($lettres as $lettre){
    $stockLettres[$lettre['lettre']] = $lettre['nombreRestant'];
}
$_SESSION['lettres'] = $stockLettres;
if (strlen($tirage['info']) < 7) {
    include('tirageAutomatique.php');
}
// }

// récupération des lettres du jeu en cas de nouvelle session
// if (!isset($_SESSION['jeu'])){
$jeu = array();
$req = $pdo -> query("SELECT position, lettre FROM jeu");
$lettresJeu = $req -> fetchAll(PDO::FETCH_ASSOC);
foreach ($lettresJeu as $lettreJeu){
    $jeu[$lettreJeu['position']] = $lettreJeu['lettre'];
}
$_SESSION['jeu'] = $jeu;
// }


// récupération de données des joueurs en cas de nouvelle session
// if (!isset($_SESSION['joueurs'])){
$req = $pdo -> query("SELECT prenom, tirage FROM joueurs ORDER BY id");
$joueurs = $req -> fetchAll(PDO::FETCH_ASSOC);
$_SESSION['joueurs'][0]['joue'] = false;
$_SESSION['joueurs'][1]['joue'] = false;
$_SESSION['joueurs'][0]['prenom'] = $joueurs[0]['prenom'];
$_SESSION['joueurs'][1]['prenom'] = $joueurs[1]['prenom'];
// }

//Résultats à afficher
$req = $pdo -> query("SELECT * FROM resultats WHERE id_partie = 1 AND mot_joueur1 <> '' AND mot_joueur2 <> ''");
$resultats = $req -> fetchAll(PDO::FETCH_ASSOC);

// enregistrement du tour en cours
$_SESSION['tour'] = $req->rowcount() + 1;

// $_SESSION['unJoueurEnAttente'] = true;


// récupération du tirage pour le joueur en jeu
$idJoueur = $_SESSION['joueur']['id'];
$tirage = $_SESSION['tirage'];
// if ($_SESSION['joueur']['id'] == 1){
$_SESSION['joueurs'][$idJoueur - 1]['tirage'] = $tirage;
$pdo->query("UPDATE joueurs SET tirage = '$tirage' WHERE id=$idJoueur");
// }else{
//     $_SESSION['joueurs'][1]['tirage'] = $_SESSION['tirage'];
//     $pdo->query("UPDATE joueurs SET tirage = '$tirage' WHERE id='2'");
// }

// }

// =====================================================================

// debug($_SESSION);

include('inc/head.inc.php');
?>
<main class="container-fluid">
    <?php include('inc/reserve.inc.php'); ?>
    <?php include('inc/score.inc.php'); ?>

    <div class="row">
        <div class="col-md-6">
            <p class="text-center" id='msg'></p>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4 text-center">
            <button type="button" id="bg" class="btn btn-info">Lettres restantes</button>
        </div>
        <div class="col-md-4">
            <h1><?= strtoupper('scrabble')  ?></h1>
        </div>
        <div class="col-md-4 text-center">
            <button type="button" id="bd" class="btn btn-info">Score</button>

        </div>
    </div>

    <!-- plateu de jeu et lettres de réserve -->
    <div class="row">
        <div class="col-md-6">
            <div class="row" id="scrabble">

                <!-- lettres de réserve -->

                <!-- plateau de jeu -->
                <div class="col-md-12" id="table">

                    <?php include('inc/jeu.inc.php'); ?>
                </div>
            </div>
        </div>

        <div class="col-md-4 col-md-offset-1">
            <div class="row">
                <div class="col-md-12">
                    <p class="text-center">tour : <?= $_SESSION['tour'] ?></p>
                </div>
            </div>
            <?php $idJoueurEnAttente = idJoueurEnAttente($pdo); ?>
            <?php if ($idJoueurEnAttente == 0 || $idJoueurEnAttente == $_SESSION['joueur']['id']) : ?>
                <?php include ('panneauSaisies.php'); ?>
            <?php else : ?>
                <div class="row">
                    <div id="attente">
                        <p>Tour en attente de <?= $_SESSION['joueurs'][$idJoueurEnAttente - 1]['prenom'] ?></p>
                    </div>
                </div>
            <?php endif; ?>
        </div><!-- fin div class="6" id="scores"> -->


    </div><!-- fin row principal -->


</main>

<script type="text/javascript" src="js/jquery-3.2.1.js"></script>
<script type="text/javascript" src="js/js.js"></script>
</body>
</html>
