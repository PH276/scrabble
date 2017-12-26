<?php
require_once ('inc/init.inc.php');
// debug($_SESSION);

// initialisation  comme quoi les 2 joueurs n'ont pas joué dans le tour en cours
$_SESSION['unJoueurEnAttente'] = false;

// cas d'une demande de nouvelle partie
if (isset($_POST['newPartie'])){
    header('newPartie.php');
}


// if (empty($_SESSION)){

// récupération du tirage

// récupération du tirage de la BD en cas de nouvelle session
if (!isset($_SESSION['tirage'])){
    $req = $pdo -> query("SELECT info FROM infos WHERE info_type='tirage'");
    $tirage = $req->fetch(PDO::FETCH_ASSOC);
    $_SESSION['tirage'] = $tirage['info'];
}

// récupération de la quantité des lettres restantes en cas de nouvelle session
if (!isset($_SESSION['lettres'])){
    $stockLettres = array();
    $req = $pdo -> query("SELECT lettre, nombreRestant FROM lettres");
    $lettres = $req -> fetchAll(PDO::FETCH_ASSOC);
    foreach ($lettres as $lettre){
        $stockLettres[$lettre['lettre']] = $lettre['nombreRestant'];
    }
    $_SESSION['lettres'] = $stockLettres;
}

// récupération des lettres du jeu en cas de nouvelle session
if (!isset($_SESSION['jeu'])){
    $jeu = array();
    $req = $pdo -> query("SELECT position, lettre FROM jeu");
    $lettresJeu = $req -> fetchAll(PDO::FETCH_ASSOC);
    foreach ($lettresJeu as $lettreJeu){
        $jeu[$lettreJeu['position']] = $lettreJeu['lettre'];
    }
    $_SESSION['jeu'] = $jeu;
}


// récupération de données des joueurs en cas de nouvelle session
if (!isset($_SESSION['joueurs'])){
    $req = $pdo -> query("SELECT prenom FROM joueurs ORDER BY id");
    $joueurs = $req -> fetchAll(PDO::FETCH_ASSOC);
    $_SESSION['joueurs'][0]['joue'] = false;
    $_SESSION['joueurs'][1]['joue'] = false;
    $_SESSION['joueurs'][0]['prenom'] = $joueurs[0]['prenom'];
    $_SESSION['joueurs'][1]['prenom'] = $joueurs[1]['prenom'];
}

//Résultats à afficher
$req = $pdo -> query("SELECT * FROM resultats WHERE id_partie = 1 AND mot_joueur1 <> '' AND mot_joueur2 <> ''");
$resultats = $req -> fetchAll(PDO::FETCH_ASSOC);

// enregistrement du tour en cours
$_SESSION['tour'] = $req->rowcount() + 1;

// $_SESSION['unJoueurEnAttente'] = true;


// récupération du tirage pour le joueur en jeu
if ($_SESSION['joueur']['id'] == 0){
    $_SESSION['tirage1'] = $_SESSION['tirage'];
}else{
    $_SESSION['tirage2'] = $_SESSION['tirage'];
}
// debug($_SESSION);

// }

// =====================================================================


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


            <!-- affichage d'éventuelle information en cours de jeu -->
            <!-- bouton de nouvelle partie -->
            <!-- affichage des lettres piochées -->
            <div class="row">
                <form action="finPartie.php" method="post">
                    <input class="btn btn-warning center-block" type="submit" name="newPartie" value="Nouvelle partie">
                </form>
            </div>
            <div class="row" id="ligne-tirage">
                <div class="row">

                    <div class="col-md-12"><!-- affichage des lettres piochées -->
                        <?php include ('inc/tirage.inc.php'); ?><!-- préparation à l'affichage des lettres piochées -->
                        <table>
                            <tr id="tirage">
                                <?= $rep['tirage'];  ?>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 text-center">
                        <button class="btn btn-primary" type="button" id="vider">Renouveler les lettres</button>
                    </div>

                </div>


            </div><!-- fin de la ligne des lettres piochées -->


            <div class="row">

                <div class="col-md-12">
                    <!-- formulaire pour la proposition d'un mot -->
                    <form method="post" id="proposition" action="motPropose.php">

                        <h2>Mot proposé</h2>
                        <?php $mot_en_attente = ($_SESSION['joueur']['id'] == 1 && $_SESSION['joueurs'][$_SESSION['joueur']['id'] - 1]['joue'])?
                        ' disabled ':''; ?>
                        <fieldset id="mot-propose">


                            <table>
                                <tbody>
                                    <tr id="ligne-mot">

                                    </tr>
                                </tbody>
                            </table>




                            <!-- champ rempli automatiquement en sélectionnannant des lettres du tirages (et du jeu) -->

                            <div class="form-group">
                                <!-- <label>Mot : </label><span id="motPropose"></span> -->

                                <input class="form-control mot" type="text" name="mot"  value="">
                            </div>
                            <div class="row">

                                <div class="form-group col-md-4">
                                    <label for="">Points : </label>
                                    <input class="form-control" type="number" name="points" value="" title="Entrer le nombre de points qu'il rapporte" required >
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="">Position : </label>
                                    <input class="form-control" type="text" name="position" value="" title="position de la première lettre du mot" required>
                                </div>
                                <div class="form-group col-md-4">

                                    <label for="">Sens : </label>
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="sens" id="V" value="V" required>
                                            Vertical
                                        </label>
                                    </div>
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="sens" id="H" value="H">
                                            Horizontal
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <input type="submit" class="btn btn-primary center-block" value="Valider">
                                </div>
                            </div>
                        </fieldset>

                    </form>
                </div>
            </div>
        </div><!-- fin div class="6" id="scores"> -->


    </div><!-- fin row principal -->


</main>

<script type="text/javascript" src="js/jquery-3.2.1.js"></script>
<script type="text/javascript" src="js/js.js"></script>
</body>
</html>
