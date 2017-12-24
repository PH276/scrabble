<table id="plateau">
    <thead>

        <tr>
            <th></th>
            <?php for ($i = 0 ; $i < 15 ; $i++) : ?>
                <th><?= $i+1 ?></th>
            <?php endfor; ?>
        </tr>
    </thead>
    <tbody>

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
    <th><?= chr($i+65) ?></th>
</tr>
<?php endfor; ?>
</tbody>
<tfoot>

    <tr>
        <th></th>
        <?php for ($i = 0 ; $i < 15 ; $i++) : ?>
            <th><?= $i+1 ?></th>
        <?php endfor; ?>
    </tr>
</tfoot>
</table>
