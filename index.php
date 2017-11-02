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
                <div class="row">

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
            </table>

        </div><!-- fin row -->
        <div class="legende">
            <div class="row ligne-legende">
                <div class="col-md-6">
                    <p class="def">
                        <span class="cadre-noir def-lettre-double">M</span>
                        lettre compte double
                    </p>
                </div>
                <div class="col-md-6">
                    <p class="def">
                        <span class="cadre-noir def-lettre-triple">M</span>
                        lettre compte triple
                    </p>
                </div>
                <div class="col-md-6">
                    <p class="def">
                        <span class="cadre-noir def-mot-double">M</span>
                        mot compte double
                    </p>
                </div>
                <div class="col-md-6">
                    <p class="def">
                        <span class="cadre-noir def-mot-triple">M</span>
                        mot compte triple
                    </p>
                </div>
            </div><!-- fin row -->
        </div><!-- fin legende -->
    </div><!-- fin col-md-6 -->
    <div class="col-md-6">
        <div class="row">
            <div class="col-md-6">
                <table class="table lettres">
                    <?php for ($i = 0 ; $i < 13 ; $i++) : ?>
                        <tr>
                            <td class="bold"><?= chr($i+65) ?></td>
                            <td><?= $i ?> points, </td>
                            <td>reste </td>
                            <td><?= $i ?> </td>
                            <td>lettres</td>
                        </tr>
                    <?php endfor; ?>
                </table>
            </div>
            <div class="col-md-6">
                <table class="table lettres">
                    <?php for ($i = 13 ; $i < 26 ; $i++) : ?>
                        <tr>
                            <td class="bold"><?= chr($i+65) ?></td>
                            <td><?= $i ?> points, </td>
                            <td>reste </td>
                            <td><?= $i ?> </td>
                            <td>lettres</td>
                        </tr>
                    <?php endfor; ?>
                </table>
            </div>
        </div><!-- fin row -->
        <div class="row">
            <table id="tirage">
                <tr>
                    <td class="lettre">A</td>
                    <td class="lettre">A</td>
                    <td class="lettre">A</td>
                    <td class="lettre">A</td>
                    <td class="lettre">A</td>
                    <td class="lettre">A</td>
                    <td class="lettre">A</td>
                </tr>
            </table>
        </div>
    </div>
</div>
</main>
</body>
</html>
