<?php
require_once ('inc/init.inc.php');
// debug($_SESSION);


if (isset($_POST['newPartie'])){
    header('finPartie.php');
}

// A l'arrivée sur cette page, récupération des données de la BDD, en cas de session inexistante
// echo '<pre>';
// print_r ($_SESSION);
// echo '</pre>';

// if (empty($_SESSION)){

// récupération du tirage

if (!isset($_SESSION['tirage'])){
    $req = $pdo -> query("SELECT info FROM infos WHERE info_type='tirage'");
    $tirage = $req->fetch(PDO::FETCH_ASSOC);
    $_SESSION['tirage'] = $tirage['info'];
}

// récupération de la quantité des lettres restantes
if (!isset($_SESSION['lettres'])){
    $stockLettres = array();
    $req = $pdo -> query("SELECT lettre, nombreRestant FROM lettres");
    $lettres = $req -> fetchAll(PDO::FETCH_ASSOC);
    foreach ($lettres as $lettre){
        $stockLettres[$lettre['lettre']] = $lettre['nombreRestant'];
    }
    $_SESSION['lettres'] = $stockLettres;
}

// récupération des lettres du jeu
if (!isset($_SESSION['jeu'])){
    $jeu = array();
    $req = $pdo -> query("SELECT position, lettre FROM jeu");
    $lettresJeu = $req -> fetchAll(PDO::FETCH_ASSOC);
    foreach ($lettresJeu as $lettreJeu){
        $jeu[$lettreJeu['position']] = $lettreJeu['lettre'];
    }
    $_SESSION['jeu'] = $jeu;
}

if (!isset($_SESSION['joueurs'])){
    $req = $pdo -> query("SELECT prenom FROM joueurs ORDER BY id");
    $joueurs = $req -> fetchAll(PDO::FETCH_ASSOC);
    $_SESSION['joueurs'][0]['joue'] = false;
    $_SESSION['joueurs'][1]['joue'] = false;
    $_SESSION['joueurs'][0]['prenom'] = $joueurs[0]['prenom'];
    $_SESSION['joueurs'][1]['prenom'] = $joueurs[1]['prenom'];
    # code...
}

//Résultats
$req = $pdo -> query("SELECT * FROM resultats WHERE id_partie = 1 AND mot_joueur1 <> '' AND mot_joueur2 <> ''");
$resultats = $req -> fetchAll(PDO::FETCH_ASSOC);

$_SESSION['tour'] = $req->rowcount() + 1;

// debug($_SESSION);

// }

// =====================================================================


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
        <div class="col-md-6">
            <div class="row" id="scrabble">

                <!-- lettres de réserve -->
                <div class="col-md-1">
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
                <div class="col-md-11" id="table">

                    <?php include('inc/jeu.inc.php'); ?>
                </div>
            </div>
        </div>

        <div class="col-md-6">


            <!-- affichage d'éventuelle information en cours de jeu -->
            <!-- bouton de nouvelle partie -->
            <!-- affichage des lettres piochées -->
            <div class="row">
                <form action="finPartie.php" method="post">
                    <input class="btn btn-warning center-block" type="submit" name="newPartie" value="Nouvelle partie">
                </form>
            </div>
            <div class="row" id="ligne-tirage">
                <div class="col-md-3">
                    <button class="btn btn-primary center-block" type="button" id="nouveauTirage">Nouvelles Lettres</button>
                </div>
                <div class="col-md-6"><!-- affichage des lettres piochées -->
                    <?php include ('inc/tirage.inc.php'); ?><!-- préparation à l'affichage des lettres piochées -->
                    <table>
                        <tr id="tirage">
                            <?= $rep['tirage'];  ?>
                        </tr>
                    </table>
                </div>

                <div class="col-md-3">
                    <button class="btn btn-primary" type="button" id="vider">Renouveler les lettres</button>
                </div>

            </div><!-- fin de la ligne des lettres piochées -->


            <div class="row">

                <div class="col-md-6">
                    <!-- formulaire pour la proposition d'un mot -->
                    <form class="form-horizontal" method="post" id="proposition" action="motPropose.php">

                        <h2>Réponse de <?= $_SESSION['joueur']['prenom'] ?></h2>
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
                                <label>Mot : </label><span id="motPropose"></span>

                                <input class="form-control mot" type="text" name="mot" required disabled value="">
                            </div>
                            <div class="form-group">
                                <label for="">Total des points  apportés par ce mot : </label>
                                <input class="form-control" type="number" name="points" value="" title="Entrer le nombre de points qu'il rapporte" required >
                            </div>
                            <div class="form-group">
                                <label for="">Position de la 1ère lettre du mot : </label>
                                <input class="form-control" type="text" name="position" value="" title="position de la première lettre du mot" required>
                            </div>
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
                            <div class="form-group">
                                <input type="submit" class="btn btn-primary center-block" value="Valider">
                            </div>
                        </fieldset>

                    </form>
                </div>
                <div class="col-md-6" >
                    <div id="scores">

                        <h2>Résultats</h2>
                        <?php $_SESSION['total_joueur1'] = 0 ?>
                        <?php $_SESSION['total_joueur2'] = 0 ?>
                        <table>
                            <thead>

                                <tr>
                                    <th colspan="3" class="col-droite"><?= $_SESSION['joueurs'][0]['prenom'] ?></th>
                                    <th colspan="3"><?= $_SESSION['joueurs'][1]['prenom'] ?></th>
                                </tr>
                                <tr>
                                    <td>mot</td>
                                    <td>points</td>
                                    <td>total</td>
                                    <td>mot</td>
                                    <td>points</td>
                                    <td>total</td>
                                </tr>
                            </thead>

                            <tbody>
                                <?php foreach ($resultats as $resultat) : ?>
                                    <tr>
                                        <?php
                                        $motRetenu = ($resultat['resultat_joueur1'] >= $resultat['resultat_joueur2']);
                                        ?>

                                        <td class="mot"><span class="<?= ($motRetenu)?"mot-retenu":"" ?>"><?= $resultat['mot_joueur1'] ?></span></td>
                                        <td><?= $resultat['resultat_joueur1'] ?></td>
                                        <?php $_SESSION['total_joueur1'] += $resultat['resultat_joueur1'] ?>
                                        <td><?= $_SESSION['total_joueur1'] ?></td>
                                        <td class="mot"><span class="<?= ($motRetenu)?"":"mot-retenu" ?>"><?= $resultat['mot_joueur2'] ?></span></td>
                                        <td><?= $resultat['resultat_joueur2'] ?></td>
                                        <?php $_SESSION['total_joueur2'] += $resultat['resultat_joueur2'] ?>
                                        <td><?= $_SESSION['total_joueur2'] ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div><!-- fin div class="6" id="scores"> -->


    </div><!-- fin row principal -->


</main>

<script type="text/javascript" src="js/jquery-3.2.1.js"></script>
<script type="text/javascript" src="js/js.js"></script>
</body>
</html>
