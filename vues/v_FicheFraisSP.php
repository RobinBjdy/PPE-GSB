
<form method="post" 
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
                    <td><?php echo $nbJustificatifs ?></td>
                    <td><?php echo $montants ?></td>
                    <td><?php echo $idEtat ?></td>
                    <td><?php echo $libelle ?></td>
                </tr>
            <?php } ?>
        </table>
    </div>
    </br> </br>
<form method="post" 
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
                    <td><?php echo $quantite ?></td>
                    <td><?php echo $prix ?></td>
                </tr>

            <?php } ?>
        </table>
    </div>
    </br> </br>
<form method="post" 
      role="form">
<div class="panel panel-info">
    <div class="panel-heading">Eléments hors-forfait</div>
    <table class="table table-bordered table-responsive">
        <tr>
            <th>Date</th>
            <th>Libelle</th>
            <th>Montant</th>
        </tr>
        <?php
        foreach ($infoFraisHorsForfait as $frais) { 
            $date = $frais['date'];
            $datee = implode('-',array_reverse  (explode('/',$date))); /* transform une date fr en une date us -> 29/10/2020 en 2020-10-29*/
            $libellehorsFrais = $frais['libelle'];
            $montant = $frais['montant'];
            $id = $frais['id'];
            ?>
            <tr>
                <td><?php echo $datee ?></td>
                <td><?php echo $libellehorsFrais ?></td>
                <td><?php echo $montant ?> € </td>
            </tr>
        <?php } ?>
    </table>
</div>
</form>
<form method="post" 
      action="index.php?uc=SuivrePaiement&action=Valider" 
      role="form">
<input id="okFicheFrais" type="submit" value="Valider" class="btn btn-success" 
       accept=""role="button"> 
<input id="annuler" type="reset" value="Réinitialiser" class="btn btn-danger" 
       accept=""role="button">
</form></br></br>