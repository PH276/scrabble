<div id="lettres-reserve">
    <table id="reserve">

        <?php for ($i = 65 ; $i < 91 ; $i++) : ?>
            <tr>
                <td class="lettres"><?= chr($i) ?></td>
                <td>:</td>
                <td id="<?= chr($i) ?>"><?= $_SESSION['lettres'][chr($i)]['nb'] ?></td>
            </tr>
        <?php endfor; ?>
        <tr>
            <td class="lettres">_</td>
            <td>:</td>
            <td id="_"><?= $_SESSION['lettres']['_']['nb'] ?></td>
        </tr>
    </table>
    <span id="ferme-reserve" class="ferme">X</span>

</div>
