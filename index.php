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

$req = $pdo -> query("SELECT prenom FROM joueurs");
$joueurs = $req -> fetchAll(PDO::FETCH_ASSOC);
// foreach ($lettresJeu as $lettreJeu){
//     $jeu[$lettreJeu['position']] = $lettreJeu['lettre'];
// }
$_SESSION['joueurs'] = $joueurs;

// }

// =====================================================================

// debug($_SESSION);
include('inc/head.inc.php');
?>


<main class="container-fluid">

    <div class="row">
        <div class="col-md-5">
            <p style="text-align:center" id='msg'></p>
        </div>
        <div class="col-md-2">
            <h1><?= strtoupper('scrabble')  ?></h1>
        </div>
    </div>

    <!-- plateu de jeu et lettres de réserve -->
    <div class="row">
        <div class="col-md-6" id="scrabble">

            <!-- lettres de réserve -->
            <div class="col-md-2">
                <table id="reserve">

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
            <div class="col-md-10" id="table">

                <?php include('jeu.inc.php'); ?>
            </div>
        </div>

        <div class="col-md-5">


            <!-- affichage d'éventuelle information en cours de jeu -->
            <!-- bouton de nouvelle partie -->
            <!-- affichage des lettres piochées -->
            <div>
                <button class="btn btn-warning center-block" type="button" id="newPartie">Nouvelle partie</button>
            </div>
            <div class="row" id="ligneTirage">
                <div class="col-md-4">
                    <button class="btn btn-primary center-block" type="button" id="NouveauTirage">Nouvelles Lettres</button>
                </div>
                <div class="col-md-6"><!-- affichage des lettres piochées -->
                    <?php include ('inc/tirage.inc.php'); ?><!-- préparation à l'affichage des lettres piochées -->
                    <table>
                        <tr id="tirage">
                            <?= $rep['tirage'];  ?>
                        </tr>
                    </table>

                </div>

                <div class="col-md-2">
                    <button class="btn btn-primary" type="button" id="vider">Renouveler les lettres</button>
                </div>

            </div><!-- fin de la ligne des lettres piochées -->

            <div class="row">
                <div class="col-md-12" id="scores">

                    <h2>Résultats</h2>
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


<div class="row">
    <h2>Propositions</h2>

    <form class="form-inline">

            <div class="col-md-2">
                <input class="form-control mot" type="text" name="mot" maxlength="10" value="" placeholder="Entrer un mot à proposer">
            </div>
            <div class="col-md-3">
                <input class="form-control" type="text" name="points" value="" title="Entrer le nombre de points">
            </div>
            <div class="col-md-5">
                <input class="form-control" type="text" name="position" value="" placeholder="position de la première lettre du mot">
            </div>
            <div class="col-md-1">
                <input type="submit" class="btn btn-primary" name="" value="Valider">
            </div>

    </form>

</div>
</main>

<script type="text/javascript" src="js/jquery-3.2.1.js"></script>
<script type="text/javascript" src="js/js.js"></script>
</body>
</html>
