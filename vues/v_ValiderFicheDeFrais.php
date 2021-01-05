
<form method="post" 
      action="index.php?uc=ValiderFicheDeFrais&action=CorrigerNbJustificatifs" 
      role="form">
    <div class="panel panel-info" style="border-color: #FF7302;">
        <div class="panel-heading" style="border-color: #FF7302; background-color: #FF7302; color: white;">Fiche</div>
        <table class="table table-bordered table-responsive">
            <tr>
                <th>Date de modification</th>
                <th>Nombre de justificatifs</th>
                <th>Montant</th>
                <th>IdEtat</th>
                <th>Libelle Etat</th>
            </tr>
            <?php
            foreach ($infoFicheDeFrais as $infoFiche) {
                $date = $infoFiche['dateModif'];

                foreach ($infoFraisHorsForfait as $frais) {
                    $montant = $frais['montant'];
                    $montants += $montant;
                }
                foreach ($infoFraisForfait as $frais) {
                    $idLibelle = $frais['idfrais'];
                    $fraiskm = $frais['fraiskm'];
                    if ($idLibelle !== 'KM') {
                        $montant = $frais['quantite'] * $frais['prix'];
                    } else {
                        $montant = $frais['quantite'] * $fraiskm;
                    }
                    $montants += $montant;
                }
                $nbJustificatifs = $infoFiche['nbJustificatifs'];
                $libelle = $infoFiche['libEtat'];
                $idEtat = $infoFiche['idEtat'];
                ?>
                <tr>
                    <td><?php echo $date ?></td>
                    <td><div class="form-group">
                            <input type="text" 
                                   name="nbJust"
                                   size="1" maxlength="5" 
                                   value="<?php echo $nbJustificatifs ?>">
                        </div></td>
                    <td><?php echo $montants ?></td>
                    <td><?php echo $idEtat ?></td>
                    <td><?php echo $libelle ?></td>
                </tr>
<?php } ?>
        </table>
    </div>
    <input id="nBJustif" type="submit" value="Corriger" class="btn btn-success" 
           role="button"> 
    <input id="annuler" type="reset" value="Réinitialiser" class="btn btn-warning" 
           role="button">
</form></br> </br>
<form method="post" 
      action="index.php?uc=ValiderFicheDeFrais&action=CorrigerFraisForfait" 
      role="form">
    <div class="panel panel-info" style="border-color: #FF7302;">
        <div class="panel-heading" style="border-color: #FF7302; background-color: #FF7302; color: white;">Eléments forfaitisés</div>
        <table class="table table-bordered table-responsive">
            <tr>
                <th>Libelle</th>
                <th>IDLibelle</th>
                <th>Quantités</th>
                <th>Prix</th>
            </tr>
            <?php
            foreach ($infoFraisForfait as $frais) {
                $idLibelle = $frais['idfrais'];
                $libelleFrais = $frais['libelle'];
                $quantite = $frais['quantite'];
                $prix = $frais['prix'];
                $fraiskm = $frais['fraiskm'];
                ?>
                <tr>
                    <td><?php echo $libelleFrais ?></td>
                    <td><?php echo $idLibelle ?></td>
                    <td><div class="form-group">
                            <input type="text" id="idFrais" 
                                   name="lesFrais[<?php echo $idLibelle ?>]"
                                   size="1" maxlength="5" 
                                   value="<?php echo $quantite ?>" 
                                   class="form-control">
                            <?php if ($idLibelle !== 'KM') { ?>
                                <td><?php echo $prix ?></td>
                            <?php } else { ?>
                                <td><?php echo $fraiskm ?></td>
    <?php } ?>
                        </div></td>
                </tr>

<?php } ?>
        </table>
    </div>
    <input id="okElemForf" type="submit" value="Corriger" class="btn btn-success" 
           role="button"> 
    <input id="annuler" type="reset" value="Réinitialiser" class="btn btn-warning" 
           role="button">
</form></br> </br>
<form method="post" 
      action="index.php?uc=ValiderFicheDeFrais&action=CorrigerElemHorsForfait" 
      role="form">
    <div class="panel panel-info" style="border-color: #FF7302;">
        <div class="panel-heading" style="border-color: #FF7302; background-color: #FF7302; color: white;">Eléments hors-forfait</div>
        <table class="table table-bordered table-responsive">
            <tr>
                <th>Date</th>
                <th>Libelle</th>
                <th>Montant</th>
                <th></th>
            </tr>
            <?php
            foreach ($infoFraisHorsForfait as $frais) {
                $date = $frais['date'];
                $datee = implode('-', array_reverse(explode('/', $date))); /* transforme une date fr en une date us -> 29/10/2020 en 2020-10-29 */
                $libellehorsFrais = $frais['libelle'];
                $montant = $frais['montant'];
                $id = $frais['id'];
                ?>
                <tr>
                    <td><div class="form-group">
                            <label for="date"></label>
                            <input type="date" 
                                   name="lesDates[<?php echo $id ?>]"
                                   size="10" maxlength="15" 
                                   value="<?php echo $datee ?>">
                        </div></td>
                    <td><div class="form-group">
                            <label for="libelle"></label>
                            <input type="text" 
                                   name="lesLibelles[<?php echo $id ?>]"
                                   size="15" maxlength="40" 
                                   value="<?php echo $libellehorsFrais ?>">
                        </div></td>
                    <td><div class="form-group">
                            <label for="montant"></label>
                            <input type="text" 
                                   name="lesMontants[<?php echo $id ?>]"
                                   size="10" maxlength="15" 
                                   value="<?php echo $montant ?>"> €
                        </div></td>
                    <td><input id="okElemHorsForf" name="corriger[<?php echo $id ?>]" type="submit" value="Corriger" class="btn btn-success" 
                               accept=""role="button"> 
                        <input id="annuler" type="reset" value="Réinitialiser" class="btn btn-warning"" 
                               accept=""role="button">
                        <a href="index.php?uc=ValiderFicheDeFrais&action=supprimerFrais&idFrais=<?php echo $id ?>&mois=<?php echo $frais['mois'] ?>&idVisiteur=<?php echo $_SESSION['visiteur'] ?> " 
                           type="reset" class="btn btn-danger" role="button"
                           onclick="return confirm('Voulez-vous vraiment supprimer ou reporter ce frais hors forfait?');">Supprimer</a>
                    </td>

                </tr>
<?php } ?>
        </table>
    </div>
</form>
<form method="post" 
      action="index.php?uc=ValiderFicheDeFrais&action=Valider" 
      role="form">
    <input id="okFicheFrais" type="submit" value="Valider" class="btn btn-success" 
           accept=""role="button" onclick="return confirm('Voulez-vous vraiment valider cette fiche de frais ?');"> 
</form></br></br>