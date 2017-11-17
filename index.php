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
            <div class="col-md-6" id="table">

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
                                <?php if ($i%7 == 0 && $j%7 == 0) : ?>
                                    <?php if ($i!=7 || $j!=7) : ?>
                                        <td class="mot-triple"></td>
                                    <?php else : ?>
                                        <td class="mot-double"></td>
                                    <?php endif; ?>
                                <?php elseif (($i==$j && (($i>0 && $i<5)
                                || ($i>9 && $i<14)))
                                || ($i==14-$j && (($i>0 && $i<5)
                                || ($i>9 && $i<14)))) : ?>
                                <td class="mot-double"></td>
                            <?php elseif (($i%7 == 0 && $j == 3)
                            || ($i == 3 && $j%7 == 0)
                            || ($i%7 == 0 && $j == 11)
                            || ($i == 11 && $j%7 == 0)
                            || (($i-2)%4 == 0 && ($j-2)%4 == 0 && $i<7 && $j<7)
                            || ((12-$i)%4 == 0 && ($j-2)%4 == 0 && $i>7 && $j<7)
                            || (($i-2)%4 == 0 && (12-$j)%4 == 0 && $i<7 && $j>7)
                            || ((12-$i)%4 == 0 && (12-$j)%4 == 0 && $i>7 && $j>7)) : ?>
                            <td class="lettre-double"></td>
                        <?php elseif (($i-1)%4 == 0 && ($j-1)%4 == 0) : ?>
                            <td class="lettre-triple"></td>
                        <?php else : ?>
                            <td class="autre-case"></td>
                        <?php endif; ?>
                    <?php endfor; ?>
                </tr>
            <?php endfor; ?>
            <tr>
                <td class="espace"></td>
            </tr>
            <tr>
                <td></td>
                <td class="lettre-double"></td>
                <td class="def" colspan="6">lettre compte double</td>
                <td></td>
                <td class="lettre-triple"></td>
                <td class="def" colspan="6">lettre compte triple</td>
            </tr>
            <tr>
                <td class="espace"></td>
            </tr>
            <tr>
                <td></td>
                <td class="mot-double"></td>
                <td class="def" colspan="6">mot compte double</td>
                <td></td>
                <td class="mot-triple"></td>
                <td class="def" colspan="6">mot compte triple</td>
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
                    'TTT UUU V W Y ',
                    'TTT UUU V  X Z'
                );
                ?>
                <table id="lettres">
                    <?php foreach ($reserve as $ligne) : ?>
                        <?php if (strlen($ligne) == 0) : ?>
                            <tr>
                                <td class="espace"></td>
                            </tr>
                        <?php else : ?>
                            <tr>
                                <?php for ($i = 0 ; $i < strlen($ligne) ; $i++) : ?>
                                    <?php $lettre = substr($ligne, $i, 1); ?>
                                    <?php if ($lettre == ' ') : ?>
                                        <td class="espace"></td>
                                    <?php else : ?>
                                        <td class="lettre"><?= $lettre ?></td>
                                    <?php endif; ?>
                                <?php endfor; ?>
                            <?php if (strlen($ligne) == 14) : ?>
                                <td class="lettre"></td>
                            <?php endif; ?>
                        </tr>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </table>
            </div>
        </div><!-- fin row -->
        <div class="row">
            <table id="tirage">
                <tr>
                    <td class="lettre">?</td>
                    <td class="lettre">?</td>
                    <td class="lettre">?</td>
                    <td class="lettre">?</td>
                    <td class="lettre">?</td>
                    <td class="lettre">?</td>
                    <td class="lettre">?</td>
                </tr>
            </table>
        </div>
    </div>
</div>
</main>
</body>
</html>
