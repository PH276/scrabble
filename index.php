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
    <main class="container-fluid">
        <div class="row">
            <?php
            $motTriple = array(0, 7, 14);
            $lettreTriple = array(1, 5, 9, 13);

            ?>
            <table>
                <?php for ($i = 0 ; $i < 15 ; $i++) : ?>
                    <tr>
                        <?php for ($j = 0 ; $j < 15 ; $j++) : ?>
                            <?php if ($i%7 == 0 && $j%7 == 0) : ?>
                                <?php if ($i!=7 || $j!=7) : ?>
                                    <td class="mot-triple"></td>
                                <?php else : ?>
                                    <td class="mot-double"></td>
                                <?php endif; ?>
                            <?php elseif (($i==$j && (($i>0 && $i<5) || ($i>9 && $i<14))) ||
                            ($i==14-$j && (($i>0 && $i<5) || ($i>9 && $i<14)))) :  ?>
                            <td class="mot-double"></td>
                        <?php elseif (($i%7 == 0 && $j == 3)
                        || ($i == 3 && $j%7 == 0)
                        || ($i%7 == 0 && $j == 11)
                        || ($i == 11 && $j%7 == 0)
                        || (($i-2)%4 == 0 && ($j-2)%4 == 0 && $i<7 && $j<7)
                        || ((12-$i)%4 == 0 && ($j-2)%4 == 0 && $i>7 && $j<7)
                        || (($i-2)%4 == 0 && (12-$j)%4 == 0 && $i<7 && $j>7)
                        || ((12-$i)%4 == 0 && (12-$j)%4 == 0 && $i>7 && $j>7)
                        ) : ?>
                        <td class="lettre-double"></td>
                    <?php elseif (($i-1)%4 == 0 && ($j-1)%4 == 0) : ?>
                        <td class="lettre-triple"></td>
                    <?php else : ?>
                        <td></td>
                    <?php endif; ?>


                <?php endfor; ?>
            </tr>
        <?php endfor; ?>
    </table>
</div>
</main>
</body>
</html>
