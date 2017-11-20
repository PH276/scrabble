<?php
session_start();
// session_destroy();
// $test = "ABCDEFG";
// $pos = strpos($test, 'D');
// echo  $pos.'<br>';
// $mot1 = substr($test, 0, $pos);
// $mot2 = substr($test, $pos+1);
// echo $mot1 . $mot2 . '<br>';
//connexion à la BDD
$pdo = new PDO("mysql:host=localhost;dbname=scrabble", 'root', '', array(
    PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING,
    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'
));

// A l'arrivée sur cette page, récupération des données de la BDD, en cas de session inexistante
// echo '<pre>';
// print_r ($_SESSION);
// echo '</pre>';

if (empty($_SESSION)){

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

}

// =====================================================================

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

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
            <div class="col-md-6" id="table">
                <p id='msg'></p>
                <!-- plateau de jeu -->
                <table>
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
                                $caseLettre = ($isLettrePlacee)?' lettre':'';
                                 ?>
                                <?php $position = chr($i+65).($j+1); ?>
                                <?php if ($i%7 == 0 && $j%7 == 0) : ?>
                                    <?php if ($i!=7 || $j!=7) : ?>
                                        <td id="<?= $position ?>" class="position case mot-triple<?= $caseLettre ?>"><?= $lettrePlacee ?></td>
                                    <?php else : ?>
                                        <td id="<?= $position ?>" class="position case mot-double<?= $caseLettre ?>"><?= $lettrePlacee ?></td>
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
        <!-- <tr>
        <td class="case"></td>
    </tr> -->
    <table id="legende">
        <tr>
            <td class="case lettre-double"></td>
            <td class="def" colspan="7">lettre compte double</td>
            <td></td>
            <td class="case lettre-triple"></td>
            <td class="def" colspan="7">lettre compte triple</td>
        </tr>
        <tr>
            <td class="case"></td>
        </tr>
        <tr>
            <td class="case mot-double"></td>
            <td class="def" colspan="7">mot compte double</td>
            <td></td>
            <td class="case mot-triple"></td>
            <td class="def" colspan="7">mot compte triple</td>
        </tr>
    </table>

</div><!-- fin col-md-6 -->
<div class="col-md-6">
    <div class="row">
        <div class="col-md-12">
            <?php $reserve = array (
                'AAA BB  D EEEEE',
                'AAA     D EEEEE',
                'AAA  CC D EEEEE',
                '',
                'F G H IIIIJ LLL',
                'F G H IIII K LL',
                '',
                'M NN OO P RR SS',
                'M NN OO P RR SS',
                'M NN OO  QRR SS',
                '',
                'TTT UUU V W Y _',
                'TTT UUU V  X Z_'
            );
            ?>
            <button type="button" id="newPartie">Nouvelle partie</button>
            <!-- <form method="post">
            <input type="submit" name="nouvellePartie" value="Nouvelle partie">
        </form> -->

        <table id="lettres">
            <?php foreach ($reserve as $ligne) : ?>
                <?php if (strlen($ligne) == 0) : ?>
                    <tr>
                        <td class="case"></td>
                    </tr>
                <?php else : ?>
                    <tr>
                        <?php for ($i = 0 ; $i < strlen($ligne) ; $i++) : ?>
                            <?php $lettre = substr($ligne, $i, 1); ?>
                            <?php if ($lettre == ' ') : ?>
                                <td class="case"></td>
                            <?php elseif ($lettre == '_') : ?>
                                <td class="reserve case lettre blanc"><?= $lettre ?></td>
                            <?php else : ?>
                                <td class="reserve case lettre"><?= $lettre ?></td>
                            <?php endif; ?>
                        <?php endfor; ?>
                    </tr>
                <?php endif; ?>
            <?php endforeach; ?>
        </table>
        <!-- <form method="post" action="" id="form-lettre-choisie">
        <input type="hidden" name="lettreChoisie" value ="">
    </form> -->
</div>
</div><!-- fin row -->

<!-- affichage des lettres tirées -->
<div class="row">
    <table id="afficheTirage">
        <tr id="tirage">
            <?php include ('inc/tirage.inc.php'); ?>
            <?= $rep['tirage'];  ?>
        </tr>
        <tr>
            <td class="case"></td>
        </tr>
        <tr>
            <td>
                <button type="button" id="vider">Vider</button>
            </td>
        </tr>
    </table>
</div>
</div>
</div>
</main>
<script type="text/javascript" src="js/jquery-3.2.1.js"></script>
<script type="text/javascript" src="js/js.js"></script>
</body>
</html>
