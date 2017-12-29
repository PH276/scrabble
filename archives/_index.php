<?php
require_once ('inc/init.inc.php');

// A l'arrivée sur cette page, récupération des données de la BDD, en cas de session inexistante
// echo '<pre>';
// print_r ($_SESSION);
// echo '</pre>';

// if (empty($_SESSION)){

// récupération du tirage
$req = $pdo -> query("SELECT info FROM infos WHERE info_type='tirage'");
$tirage = $req->fetch(PDO::FETCH_ASSOC);
$_SESSION['tirage'] = $tirage['info'];

// récupération de la quantité des lettres restantes
$stockLettres = array();
$req = $pdo -> query("SELECT lettre, nombreRestant FROM lettres");
$lettres = $req -> fetchAll(PDO::FETCH_ASSOC);
foreach ($lettres as $lettre){
    $stockLettres[$lettre['lettre']] = $lettre['nombreRestant'];
}
$_SESSION['lettres'] = $stockLettres;

// récupération des lettres du jeu
$jeu = array();
$req = $pdo -> query("SELECT position, lettre FROM jeu");
$lettresJeu = $req -> fetchAll(PDO::FETCH_ASSOC);
foreach ($lettresJeu as $lettreJeu){
    $jeu[$lettreJeu['position']] = $lettreJeu['lettre'];
}
$_SESSION['jeu'] = $jeu;

// }

// =====================================================================

// echo '<pre>';
// print_r ($_SESSION);
// echo '</pre>';

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link rel="stylesheet" href="css/reset.css">

    <!-- Bootstrap -->
    <link href="css/bootstrap.css" rel="stylesheet">

    <link rel="stylesheet" href="css/style.css">

    <title>Scrabble</title>
</head>
<body>

<main class="container-fluid">

    <!-- plateu de jeu et lettres de réserve -->
    <div class="row">
        <div class="col-md-6" id="scrabble">

            <!-- lettres de réserve -->
            <div class="col-md-1" id="reserve">
                <table>

                    <?php for ($i = 65 ; $i < 91 ; $i++) : ?>
                        <tr>
                            <td class="lettres"><?= chr($i) ?></td>
                            <td>:</td>
                            <td id="<?= chr($i) ?>"><?= $_SESSION['lettres'][chr($i)] ?></td>
                        </tr>
                    <?php endfor; ?>
                    <tr>
                        <td class="lettres">_</td>
                        <td>:</td>
                        <td id="_"><?= $_SESSION['lettres']['_'] ?></td>
                    </tr>
                </table>
            </div>

            <!-- plateau de jeu -->
            <div class="col-md-8" id="table">

                <?php include('jeu.inc.php'); ?>
            </div>
        </div>

        <div class="col-md-6" id="scores">
            <!-- affichage d'éventuelle information en cours de jeu -->
            <!-- bouton de nouvelle partie -->
            <div class="row">
                <div class="col-md-5">
                    <p style="text-align:center" id='msg'></p>
                </div>
                <div class="col-md-2">
                    <h1>scrabble</h1>
                </div>
                <div class="col-md-5">
                    <button class="btn btn-warning center-block" type="button" id="newPartie">Nouvelle partie</button>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">


                    <h2>Propositions</h2>
                    <form class="form-inline">
                        <label>maman : </label>
                        <input class="form-control" type="text" name="mot1" value="" title="mot à proposer">
                        <input class="form-control" type="text" name="points1" value="" title="nombre de points">
                        <input class="form-control" type="text" name="position1" value="" title="position">
                        <input type="submit" class="btn btn-primary" name="" value="Valider">
                    </form>
                    <form class="form-inline">
                        <label>Pascal : </label>
                        <input class="form-control" type="text" name="mot1" value="" title="mot à proposer">
                        <input class="form-control" type="text" name="points1" value="" title="nombre de points">
                        <input class="form-control" type="text" name="position1" value="" title="position">
                        <input type="submit" class="btn btn-primary" name="" value="Valider">
                    </form>
                    <h2>Scores</h2>
                    <table>
                        <tr>
                            <th colspan="2">maman</th>
                            <th colspan="2">Pascal</th>
                        </tr>
                        <tr>
                            <td>test1</td>
                            <td>test1</td>
                            <td>test1</td>
                            <td>test1</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div><!-- fin div class="6" id="scores"> -->


        </div><!-- fin row plteaux jeux et réserve des lettres -->

        <!-- affichage des lettres piochées -->
        <div class="row">
            <div class="col-md-2 col-md-offset-2"><!-- affichage des lettres piochées -->
                <?php include ('inc/tirage.inc.php'); ?><!-- préparation à l'affichage des lettres piochées -->
                <table>
                    <tr id="tirage">
                        <?= $rep['tirage'];  ?>
                    </tr>
                </table>

            </div>

            <!-- boutons de pioche -->
            <!-- div class="col-md-6" id="boutonsTirage"> -->
            <div class="col-md-1">
                <button class="btn btn-primary" type="button" id="NouveauTirage">Nouvelles Lettres</button>
            </div>
            <div class="col-md-1">
                <button class="btn btn-primary" type="button" id="vider">Vider</button>
            </div>

        </div>

    </div><!-- fin de la ligne des lettres piochées -->
</main>

<script type="text/javascript" src="js/jquery-3.2.1.js"></script>
<script type="text/javascript" src="js/js.js"></script>
</body>
</html>
