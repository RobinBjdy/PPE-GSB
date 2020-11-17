
<form method="post" 
      action="index.php?uc=ValiderFicheDeFrais&action=CorrigerNbJustificatifs" 
      role="form">
    <div class="panel panel-info">
        <div class="panel-heading">Fiche</div>
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
                
                $montants = 0;
                foreach ($infoFraisHorsForfait as $frais) {
                    $montant = $frais['montant'];
                    $montants += $montant;
                }
                foreach ($infoFraisForfait as $frais) {
                    $montant = $frais['quantite']*$frais['prix'];
                    $montants += $montant;
                }
                $nbJustificatifs = $infoFiche['nbJustificatifs'];
                $libelle = $infoFiche['libEtat'];
                $idEtat = $infoFiche['idEtat'];
                ?>
                <tr>
                    <td><?php echo $date ?></td>
                    <td><div class="form-group">
                            <label for="idFrais"></label>
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
    <input id="annuler" type="reset" value="Réinitialiser" class="btn btn-danger" 
           role="button">
</form></br> </br>
<form method="post" 
      action="index.php?uc=ValiderFicheDeFrais&action=CorrigerFraisForfait" 
      role="form">
    <div class="panel panel-info">
        <div class="panel-heading">Eléments forfaitisés</div>
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
                        </div></td>
                    <td><?php echo $prix ?></td>
                </tr>

            <?php } ?>
        </table>
    </div>
    <input id="okElemForf" type="submit" value="Corriger" class="btn btn-success" 
           role="button"> 
    <input id="annuler" type="reset" value="Réinitialiser" class="btn btn-danger" 
           role="button">
</form></br> </br>
<form method="post" 
      action="index.php?uc=ValiderFicheDeFrais&action=CorrigerElemHorsForfait" 
      role="form">
<div class="panel panel-info">
    <div class="panel-heading">Eléments hors-forfait</div>
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
                               value="<?php echo $date ?>">
                    </div></td>
                <td><div class="form-group">
                        <label for="libelle"></label>
                        <input type="text" 
                               name="lesLibelles[<?php echo $id ?>]"
                               size="10" maxlength="12" 
                               value="<?php echo $libellehorsFrais ?>">
                    </div></td>
                <td><div class="form-group">
                        <label for="montant"></label>
                        <input type="text" 
                               name="lesMontants[<?php echo $id ?>]"
                               size="10" maxlength="15" 
                               value="<?php echo $montant ?>">
                    </div></td>
                <td><input id="okElemHorsForf" type="submit" value="Corriger" class="btn btn-success" 
                           accept=""role="button"> 
                    <input id="annuler" type="reset" value="Réinitialiser" class="btn btn-danger" 
                           accept=""role="button">
                </td>

            </tr>
        <?php } ?>
    </table>
</div>
</form>
<input id="okFicheFrais" type="submit" value="Valider" class="btn btn-success" 
       accept=""role="button"> 
<input id="annuler" type="reset" value="Réinitialiser" class="btn btn-danger" 
       accept=""role="button">
</br></br>