<?php
/**
 * Vue Accueil
 *
 * PHP Version 7
 *
 * @category  PPE
 * @package   GSB
 * @author    Réseau CERTA <contact@reseaucerta.org>
 * @author    José GIL <jgil@ac-nice.fr>
 * @copyright 2017 Réseau CERTA
 * @license   Réseau CERTA
 * @version   GIT: <0>
 * @link      http://www.reseaucerta.org Contexte « Laboratoire GSB »
 */
?>
<div id="accueil">
<?php if($_SESSION['type']=='visiteur'){ ?>
    <h2>
        Gestion des frais<small> - Visiteur : 
            <?php 
            echo $_SESSION['prenom'] . ' ' . $_SESSION['nom']
            ?></small>
    </h2>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">
                    <span class="glyphicon glyphicon-bookmark"></span>
                    Navigation
                </h3>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-xs-12 col-md-12">
                        <a href="index.php?uc=gererFrais&action=saisirFrais"
                           class="btn btn-success btn-lg" role="button">
                            <span class="glyphicon glyphicon-pencil"></span>
                            <br>Renseigner la fiche de frais</a>
                        <a href="index.php?uc=etatFrais&action=selectionnerMois"
                           class="btn btn-primary btn-lg" role="button">
                            <span class="glyphicon glyphicon-list-alt"></span>
                            <br>Afficher mes fiches de frais</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> <?php } else { ?>
<h2>
        Gestion des frais<small> - Comptable : 
            <?php 
            echo $_SESSION['prenom'] . ' ' . $_SESSION['nom']
            ?></small>
    </h2>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-primary"  style="border-color: #FF9902 !important;">
            <div class="panel-heading" style="background-color: #FF9902 !important; border-color: #FF9902 !important;">
                <h3 class="panel-title">
                    <span class="glyphicon glyphicon-bookmark"></span>
                    Navigation
                </h3>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-xs-12 col-md-12">
                        <a href="index.php?uc=ValiderFicheDeFrais&action=selectionnerMois"
                           class="btn btn-warning btn-lg" role="button">
                            <span class="fa fa-check"></span>
                            <br>Valider fiche de frais</a>
                        <a href="index.php?uc=SuivrePaiement&action=selectionnerVisiteur"
                           class="btn btn-info btn-lg" role="button">
                            <span class="fa fa-euro"></span>
                            <br>Suivre le paiement fiche de frais</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php } ?>

