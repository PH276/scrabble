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
                            <?php if (($i==$j || $i==14-$j) && $i>0 && $i<14 )  : ?>
                                <td class="mot-double"></td>
                            <?php elseif (in_array($i, $motTriple) && in_array($j, $motTriple))  : ?>
                                <td class="mot-triple"></td>
                            <?php elseif (in_array($i, $lettreTriple) && in_array($j, $lettreTriple))  : ?>
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
