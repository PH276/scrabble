<div id="lettres-reserve">
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
