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
    case 'selectionnerMois' :
        $lesMois = $pdo->getMoisFicheDeFraisVA();
        // Afin de sélectionner par défaut le dernier mois dans la zone de liste
        // on demande toutes les clés, et on prend la première,
        // les mois étant triés décroissants
        $lesCles = array_keys($lesMois);
        $moisASelectionne = $lesCles[0];
        include 'vues/v_SelectMoisSP.php';
        break;
    case 'selectionnerVisiteur' :
        $leMois = filter_input(INPUT_POST, 'lstMois', FILTER_SANITIZE_STRING);
        $lesMois = $pdo->getMoisFicheDeFraisVA();
        $moisASelectionne = $leMois;
        include 'vues/v_SelectMoisSP.php';
        $date = str_replace('/', '', filter_input(INPUT_POST, 'lstMois', FILTER_SANITIZE_STRING));
        trim($date);
        $_SESSION['date'] = $date;
        $lesVisiteur = $pdo->getVisiteurFromMoisVA($date);
        $selectedValue = $lesVisiteur[0];
        include 'vues/v_SelectVisiteurSP.php';
        break;
    case 'FicheFraisSP':
        $lesMois = $pdo->getMoisFicheDeFraisVA();
        $moisASelectionne = $_SESSION['date'];
        include 'vues/v_SelectMoisSP.php';
        $leVisiteur = filter_input(INPUT_POST, 'lstVisiteur', FILTER_SANITIZE_STRING);
        $lesVisiteur = $pdo->getVisiteurFromMoisVA($_SESSION['date']);
        $selectedValue = $leVisiteur;
        include 'vues/v_SelectVisiteurSP.php';
        $nomVis = (filter_input(INPUT_POST, 'lstVisiteur', FILTER_SANITIZE_STRING));
        trim($nomVis);
        $idVis = $pdo ->getIdFromNomVisiteur($nomVis);
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
        <script>alert("<?php echo htmlspecialchars('Votre fiche de frais a bien été mise en paiement ! ', ENT_QUOTES); ?>")</script>
        <?php
}