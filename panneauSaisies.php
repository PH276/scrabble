<div class="row" id="ligne-tirage">

    <div class="row">
        <div class="col-md-12"><!-- affichage des lettres piochées -->
            <?php include ('inc/tirage.inc.php'); ?><!-- préparation à l'affichage des lettres piochées -->
            <table>
                <tr id="tirage">
                    <?= $rep['tirage'];  ?>
                </tr>
            </table>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 text-center">
            <button class="btn btn-primary" type="button" id="vider">Renouveler les lettres</button>
        </div>

    </div>


</div><!-- fin de la ligne des lettres piochées -->


<div class="row">

    <div class="col-md-12">
        <!-- formulaire pour la proposition d'un mot -->
        <form method="post" id="proposition" action="motPropose.php">

            <h2>Mot proposé</h2>
            <?php $mot_en_attente = ($_SESSION['joueur']['id'] == 1 && $_SESSION['joueurs'][$_SESSION['joueur']['id'] - 1]['joue'])?
            ' disabled ':''; ?>
            <fieldset id="mot-propose">






                <!-- champ rempli automatiquement en sélectionnannant des lettres du tirages (et du jeu) -->

                <div class="form-group">
                    <label>Mot : </label><span id="motPropose"></span>
                    <table>
                        <tbody>
                            <tr id="ligne-mot">

                            </tr>
                        </tbody>
                    </table>

                    <input class="form-control mot" type="hidden" name="mot"  value="">
                </div>
                <div class="row">

                    <div class="form-group col-md-4">
                        <label for="">Points : </label>
                        <input class="form-control" type="number" name="points" value="" title="Entrer le nombre de points qu'il rapporte" required >
                    </div>
                    <div class="form-group col-md-4">
                        <label for="">Position : <span id="position"></span></label>
                        <input class="form-control" type="text" name="position" value="" title="position de la première lettre du mot" required>
                    </div>
                    <div class="form-group col-md-4">

                        <label for="">Sens : </label>
                        <div class="radio">
                            <label>
                                <input type="radio" name="sens" id="V" value="V" required>
                                Vertical
                            </label>
                        </div>
                        <div class="radio">
                            <label>
                                <input type="radio" name="sens" id="H" value="H">
                                Horizontal
                            </label>
                        </div>
                    </div>
                    <div class="form-group">
                        <input type="submit" class="btn btn-primary center-block" value="Valider">
                    </div>
                </div>
            </fieldset>

        </form>
    </div>
</div>
