<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_STRING);
$idVisiteur = filter_input(INPUT_POST, 'lstVisiteur', FILTER_SANITIZE_STRING);
$montants = 0;
switch ($action) {
    case 'selectionnerVisiteur' :
        $date = date('Ym');
        $_SESSION['date'] = $date;
        $lesVisiteur = $pdo->getVisiteurFromMoisVA($date);
        $selectedValue = $lesVisiteur[0];
        include 'vues/v_SelectVisiteurSP.php';
        break;
    case 'FicheFraisSP':
        $leVisiteur = filter_input(INPUT_POST, 'lstVisiteur', FILTER_SANITIZE_STRING);
        $lesVisiteur = $pdo->getVisiteurFromMoisVA($_SESSION['date']);
        $selectedValue = $leVisiteur;
        include 'vues/v_SelectVisiteurSP.php';
        $nomVis = (filter_input(INPUT_POST, 'lstVisiteur', FILTER_SANITIZE_STRING));
        trim($nomVis);
        $idVis = $pdo->getIdFromNomVisiteur($nomVis);
        $_SESSION['visiteur'] = $idVis['id'];
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
        <p>Votre fiche de frais a bien été validée ! <a href = "index.php?uc=SuivrePaiement&action=selectionnerVisiteur">Cliquez ici</a>
        pour revenir à la page d'accueil.</p>
        </div>
        <?php
}