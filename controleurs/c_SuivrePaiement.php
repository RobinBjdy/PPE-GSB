<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_STRING);
$idVisiteur = filter_input(INPUT_POST, 'lstVisiteur', FILTER_SANITIZE_STRING);
$montants = 0;
$date = date('Ym');
switch ($action) {
    case 'selectionnerVisiteur' :
        if (empty($pdo->getVisiteurFromMoisVA($date))) {
            ?></br><?php ajouterErreur("Aucun visiteur n'a de fiche de frais ce mois ci");
            include 'vues/v_erreurs.php';
            include 'vues/v_SelectVisiteurSP.php';
        } else {
            $_SESSION['date'] = $date;
            $lesVisiteur = $pdo->getVisiteurFromMoisVA($date);
            $selectedValue = $lesVisiteur[0];
            include 'vues/v_SelectVisiteurSP.php';
        }
        break;
    case 'FicheFraisSP':
        $leVisiteur = filter_input(INPUT_POST, 'lstVisiteur', FILTER_SANITIZE_STRING);
        $lesVisiteur = $pdo->getVisiteurFromMoisVA($_SESSION['date']);
        $selectedValue = $leVisiteur;
        include 'vues/v_SelectVisiteurSP.php';
        //Recupère le nom du visiteur selectionné
        $nomVis = (filter_input(INPUT_POST, 'lstVisiteur', FILTER_SANITIZE_STRING));
        trim($nomVis);
        //Avoir l'id du visiteur en fonction de son nom-prenom
        $idVis = $pdo->getIdFromNomVisiteur($nomVis);
        $_SESSION['visiteur'] = $idVis['id'];
        //Selection de toutes les infos concernant le visiteur selectionné
        $infoFicheDeFrais = $pdo->getLesInfosFicheFrais($_SESSION['visiteur'], $_SESSION['date']);
        $infoFraisForfait = $pdo->getLesFraisForfait($_SESSION['visiteur'], $_SESSION['date']);
        $infoFraisHorsForfait = $pdo->getLesFraisHorsForfait($_SESSION['visiteur'], $_SESSION['date']);
        include'vues/v_FicheFraisSP.php';
        $_SESSION['montant'] = $montants;
        break;
    case 'Valider' :
        $pdo->validerFicheDeFraisVA($_SESSION['visiteur'], $_SESSION['date'], $_SESSION['montant']);
        ?>
        <div class = "alert alert-success" role = "alert">
            <p>Votre fiche de frais a bien été mise en paiement ! <a href = "index.php?uc=SuivrePaiement&action=selectionnerVisiteur">Cliquez ici</a>
                pour revenir à la selection.</p>
        </div>
    <?php
}