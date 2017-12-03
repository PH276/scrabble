<div class="row">
    <div class="col-md-3">
        <table>
            <?php for($i = 0 ; $i < 5 ; $i++) : ?>
                <?php if ($i%3==0) : ?><tr><?php endif; ?>

                    <td class="case lettre">A</td>
                    <?php if (($i+4)%3==0) : ?></tr><?php endif; ?>
                <?php endfor; ?>
            </table>
        </div>
        <div class="col-md-3">
            <table>
                <tr>
                    <?php for($j = 0 ; $j < 2 ; $j++) : ?>
                        <td class="case lettre">B</td>
                    <?php endfor; ?>
                    <td class="case"></td>
                </tr>
                <tr>
                    <td class="case"></td>
                </tr>
                <tr>
                    <td class="case"></td>
                    <?php for($j = 0 ; $j < 2 ; $j++) : ?>
                        <td class="case lettre">C</td>
                    <?php endfor; ?>
                </tr>
            </table>
        </div>
        <div class="col-md-1">
            <table>
                <?php for($i = 0 ; $i < 3 ; $i++) : ?>
                    <tr>
                        <td class="case lettre">D</td>
                    </tr>
                <?php endfor; ?>
            </table>

        </div>
        <div class="col-md-5">
            <table>
                <?php for($i = 0 ; $i < 15 ; $i++) : ?>
                    <?php if ($i%5==0) : ?><tr><?php endif; ?>

                        <td class="case lettre">E</td>
                        <?php if (($i+6)%5==0) : ?></tr><?php endif; ?>
                    <?php endfor; ?>
                </table>
            </div>
        </div>
