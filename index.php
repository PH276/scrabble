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

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- Bootstrap -->
    <link href="css/bootstrap.css" rel="stylesheet">

    <link rel="stylesheet" href="css/style.css">

    <title>Scrabble</title>
</head>
<body>
    <!-- <div id="session">
</div> -->
<?php

// echo '<pre>';
// print_r ($_SESSION);
// echo '</pre>';

?>
<main class="container-fluid">
    <div class="row">
        <div class="col-md-2 col-md-offset-5">

            <button class="btn btn-warning" type="button" id="newPartie">Nouvelle partie</button>
            <p id='msg'></p>
        </div>
    </div>
    <div class="row" id="scrabble">
        <div class="col-md-6 col-md-offset-1" id="table">

            <!-- plateau de jeu -->
            <table id="plateau">
                <tr>
                    <th></th>
                    <?php for ($i = 0 ; $i < 15 ; $i++) : ?>
                        <th><?= $i+1 ?></th>
                    <?php endfor; ?>
                </tr>
                <?php for ($i = 0 ; $i < 15 ; $i++) : ?>
                    <tr>
                        <th><?= chr($i+65) ?></th>
                        <?php for ($j = 0 ; $j < 15 ; $j++) : ?>
                            <?php $position = chr($i+65).($j+1);
                            $isLettrePlacee =  isset($_SESSION['jeu'][$position]);
                            $lettrePlacee = ($isLettrePlacee)?$_SESSION['jeu'][$position]:'';
                            $caseLettre = ($isLettrePlacee)?' lettre':' case-valeur';
                            ?>
                            <?php //$position = chr($i+65).($j+1); ?>
                            <?php if ($i%7 == 0 && $j%7 == 0) : ?>
                                <?php if ($i!=7 || $j!=7) : ?>
                                    <td id="<?= $position ?>" class="position case mot-triple<?= $caseLettre ?>"><?= $lettrePlacee ?></td>
                                <?php else : ?>
                                    <td id="<?= $position ?>" class="position case case-centre<?= $caseLettre ?>"><?= $lettrePlacee ?></td>
                                <?php endif; ?>
                            <?php elseif (($i==$j && (($i>0 && $i<5)
                            || ($i>9 && $i<14)))
                            || ($i==14-$j && (($i>0 && $i<5)
                            || ($i>9 && $i<14)))) : ?>
                            <td id="<?= $position ?>" class="position case mot-double<?= $caseLettre ?>"><?= $lettrePlacee ?></td>
                        <?php elseif (($i%7 == 0 && $j == 3)
                        || ($i == 3 && $j%7 == 0)
                        || ($i%7 == 0 && $j == 11)
                        || ($i == 11 && $j%7 == 0)
                        || (($i-2)%4 == 0 && ($j-2)%4 == 0 && $i<7 && $j<7)
                        || ((12-$i)%4 == 0 && ($j-2)%4 == 0 && $i>7 && $j<7)
                        || (($i-2)%4 == 0 && (12-$j)%4 == 0 && $i<7 && $j>7)
                        || ((12-$i)%4 == 0 && (12-$j)%4 == 0 && $i>7 && $j>7)) : ?>
                        <td id="<?= $position ?>" class="position case lettre-double<?= $caseLettre ?>"><?= $lettrePlacee ?></td>
                    <?php elseif (($i-1)%4 == 0 && ($j-1)%4 == 0) : ?>
                        <td id="<?= $position ?>" class="position case lettre-triple<?= $caseLettre ?>"><?= $lettrePlacee ?></td>
                    <?php else : ?>
                        <td id="<?= $position ?>" class="position case autre-case<?= $caseLettre ?>"><?= $lettrePlacee ?></td>
                    <?php endif; ?>
                <?php endfor; ?>
            </tr>
        <?php endfor; ?>
    </table>
</div><!-- <div class="col-md-6" id="table"> -->
    <!-- <div class="col-md-1">AAA
</div> -->
<div class="col-md-5 row" id="ligne-reserve">

    <div id="A">
        <?php for($i = 0 ; $i < 9 ; $i++) : ?>
            <div class="lettres-reserve case lettre">A</div>
            <?php if (($i+1)%3 == 0) : ?>
                <div class="clear"></div>
            <?php endif; ?>
        <?php endfor; ?>
    </div>

    <div id="B">
        <?php for($i = 0 ; $i < 2 ; $i++) : ?>
            <div class="lettres-reserve case lettre">B</div>
        <?php endfor; ?>

    </div>

    <div id="C">
        <?php for($i = 0 ; $i < 2 ; $i++) : ?>
            <div class="lettres-reserve case lettre">C</div>
        <?php endfor; ?>
    </div>

    <div id="D">
        <?php for($i = 0 ; $i < 3 ; $i++) : ?>
            <div class="lettres-reserve case lettre">D</div>
            <div class="clear"></div>
        <?php endfor; ?>
    </div>

    <div id="E">
        <?php for($i = 0 ; $i < 15 ; $i++) : ?>
            <div class="lettres-reserve case lettre">E</div>
            <?php if (($i+1)%5 == 0 && $i != 8) : ?>
                <div class="clear"></div>
            <?php endif; ?>
        <?php endfor; ?>
    </div>

    <div id="F">
        <?php for($i = 0 ; $i < 2 ; $i++) : ?>
            <div class="lettres-reserve case lettre">F</div>
            <div class="clear"></div>
        <?php endfor; ?>
    </div>

    <div id="G">
        <?php for($i = 0 ; $i < 2 ; $i++) : ?>
            <div class="lettres-reserve case lettre">G</div>
            <div class="clear"></div>
        <?php endfor; ?>
    </div>

    <div id="H">
        <?php for($i = 0 ; $i < 2 ; $i++) : ?>
            <div class="lettres-reserve case lettre">H</div>
            <div class="clear"></div>
        <?php endfor; ?>
    </div>

    <div id="I">
        <?php for($i = 0 ; $i < 8 ; $i++) : ?>
            <div class="lettres-reserve case lettre">I</div>
            <?php if (($i+1)%4 == 0 && $i != 8) : ?>
                <div class="clear"></div>
            <?php endif; ?>
        <?php endfor; ?>
    </div>

    <div id="J">
        <div class="lettres-reserve case lettre">J</div>
        <div class="clear"></div>
    </div>

    <div id="K">
        <div class="lettres-reserve case lettre">K</div>
        <div class="clear"></div>
    </div>

    <div id="L">
        <?php for($i = 0 ; $i < 5 ; $i++) : ?>
            <div class="lettres-reserve case lettre">L</div>
            <?php if (($i+1)%3 == 0 && $i != 8) : ?>
                <div class="clear"></div>
            <?php endif; ?>
        <?php endfor; ?>
    </div>

    <div id="M">
        <?php for($i = 0 ; $i < 3 ; $i++) : ?>
            <div class="lettres-reserve case lettre">M</div>
            <div class="clear"></div>
        <?php endfor; ?>
    </div>

    <div id="N">
        <?php for($i = 0 ; $i < 6 ; $i++) : ?>
            <div class="lettres-reserve case lettre">N</div>
            <?php if (($i+1)%2 == 0 && $i != 8) : ?>
                <div class="clear"></div>
            <?php endif; ?>
        <?php endfor; ?>
    </div>

    <div id="O">
        <?php for($i = 0 ; $i < 6 ; $i++) : ?>
            <div class="lettres-reserve case lettre">O</div>
            <?php if (($i+1)%2 == 0 && $i != 8) : ?>
                <div class="clear"></div>
            <?php endif; ?>
        <?php endfor; ?>
    </div>

    <div id="P">
        <?php for($i = 0 ; $i < 2 ; $i++) : ?>
            <div class="lettres-reserve case lettre">P</div>
            <div class="clear"></div>
        <?php endfor; ?>
    </div>

    <div id="Q">
        <div class="lettres-reserve case lettre">Q</div>
        <div class="clear"></div>
    </div>

    <div id="R">
        <?php for($i = 0 ; $i < 6 ; $i++) : ?>
            <div class="lettres-reserve case lettre">R</div>
            <?php if (($i+1)%2 == 0 && $i != 8) : ?>
                <div class="clear"></div>
            <?php endif; ?>
        <?php endfor; ?>
    </div>

    <div id="S">
        <?php for($i = 0 ; $i < 6 ; $i++) : ?>
            <div class="lettres-reserve case lettre">S</div>
            <?php if (($i+1)%2 == 0 && $i != 8) : ?>
                <div class="clear"></div>
            <?php endif; ?>
        <?php endfor; ?>
    </div>

    <div id="T">
        <?php for($i = 0 ; $i < 6 ; $i++) : ?>
            <div class="lettres-reserve case lettre">T</div>
            <?php if (($i+1)%3 == 0 && $i != 8) : ?>
                <div class="clear"></div>
            <?php endif; ?>
        <?php endfor; ?>
    </div>

    <div id="U">
        <?php for($i = 0 ; $i < 6 ; $i++) : ?>
            <div class="lettres-reserve case lettre">U</div>
            <?php if (($i+1)%3 == 0 && $i != 8) : ?>
                <div class="clear"></div>
            <?php endif; ?>
        <?php endfor; ?>
    </div>

    <div id="V">
        <?php for($i = 0 ; $i < 2 ; $i++) : ?>
            <div class="lettres-reserve case lettre">V</div>
            <div class="clear"></div>
        <?php endfor; ?>
    </div>

    <div id="W">
        <div class="lettres-reserve case lettre">W</div>
        <div class="clear"></div>
    </div>

    <div id="X">
        <div class="lettres-reserve case lettre">X</div>
        <div class="clear"></div>
    </div>

    <div id="Y">
        <div class="lettres-reserve case lettre">Y</div>
        <div class="clear"></div>
    </div>

    <div id="Z">
        <div class="lettres-reserve case lettre">Z</div>
        <div class="clear"></div>
    </div>

    <div id="_">
        <?php for($i = 0 ; $i < 2 ; $i++) : ?>
            <div class="lettres-reserve case lettre">_</div>
            <div class="clear"></div>
        <?php endfor; ?>
    </div>

</div><!-- fin col-md-6 -->
</div><!-- fin row plteaux jeux et réserve des lettres -->
<div class="row">
    <div class="col-md-6"><!-- affichage des lettres piochées -->
        <!-- affichage des lettres tirées -->
        <?php include ('inc/tirage.inc.php'); ?>
        <table>
            <tr id="tirage">
                <?= $rep['tirage'];  ?>
            </tr>
        </table>

    </div>

    <div class="col-md-6" id="boutonsTirage"><!-- boutons de pioche -->
        <div class="col-md-3 col-md-offset-3">
            <button class="btn btn-primary" type="button" id="NouveauTirage">Nouvelles Lettres</button>
        </div>
        <div class="col-md-2 col-md-offset-2">
            <button class="btn btn-primary" type="button" id="vider">Vider</button>
        </div>

    </div>

</div>
</main>

<script type="text/javascript" src="js/jquery-3.2.1.js"></script>
<script type="text/javascript" src="js/js.js"></script>
</body>
</html>
