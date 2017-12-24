<div id="scores">

    <h2>Résultats</h2>
    <?php
    // $_SESSION['total_joueur1'] = 0;
    // $_SESSION['total_joueur2'] = 0;
    $total_joueur1 = 0;
    $total_joueur2 = 0;
    ?>
    <table>
        <thead>
            <tr>
                <th colspan="3" class="col-droite">
                    <?= (isset($_SESSION['joueurs'][0]['prenom']))?$_SESSION['joueurs'][0]['prenom']:'Joueur 1' ?>
                </th>
                <th colspan="3">
                    <?= (isset($_SESSION['joueurs'][1]['prenom']))?$_SESSION['joueurs'][1]['prenom']:'Joueur 2' ?>
                </th>
            </tr>
            <tr>
                <td>mot</td>
                <td>points</td>
                <td>total</td>
                <td>mot</td>
                <td>points</td>
                <td>total</td>
            </tr>
        </thead>

        <tbody>
            <?php foreach ($resultats as $resultat) : ?>
                <tr>
                    <?php
                    $motRetenu = ($resultat['resultat_joueur1'] >= $resultat['resultat_joueur2']);
                    ?>

                    <td class="mot"><span class="<?= ($motRetenu)?"mot-retenu":"" ?>"><?= $resultat['mot_joueur1'] ?></span></td>
                    <td><?= $resultat['resultat_joueur1'] ?></td>
                    <?php $total_joueur1 += $resultat['resultat_joueur1'] ?>
                    <td><?= $total_joueur1 ?></td>
                    <td class="mot"><span class="<?= ($motRetenu)?"":"mot-retenu" ?>"><?= $resultat['mot_joueur2'] ?></span></td>
                    <td><?= $resultat['resultat_joueur2'] ?></td>
                    <?php $total_joueur2 += $resultat['resultat_joueur2'] ?>
                    <td><?= $total_joueur2 ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <span id="ferme-score" class="ferme">X</span>

</div>
