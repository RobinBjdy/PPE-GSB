<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_STRING);
$idVisiteur = filter_input(INPUT_POST, 'lstVisiteur', FILTER_SANITIZE_STRING);
switch ($action) {
    case 'selectionnerMois' :
        $lesMois = $pdo->getMoisFicheDeFrais();
        // Afin de sélectionner par défaut le dernier mois dans la zone de liste
        // on demande toutes les clés, et on prend la première,
        // les mois étant triés décroissants
        $lesCles = array_keys($lesMois);
        $moisASelectionner = $lesCles[0];
        include 'vues/v_SelectMois.php';
        break;
    case 'selectionnerVisiteur' :
        $leMois = filter_input(INPUT_POST, 'lstMois', FILTER_SANITIZE_STRING);
        $lesMois = $pdo->getMoisFicheDeFrais();
        $moisASelectionner = $leMois;
        include 'vues/v_SelectMois.php';
        $date = str_replace('/', '', filter_input(INPUT_POST, 'lstMois', FILTER_SANITIZE_STRING));
        trim($date);
        $_SESSION['date'] = $date;
        $lesVisiteur = $pdo->getVisiteurFromMois($date);
        $selectedValue = $lesVisiteur[0];
        include 'vues/v_SelectVisiteur.php';
        break;
    case 'ValiderFicheDeFrais':
        $leMois = filter_input(INPUT_POST, 'lstMois', FILTER_SANITIZE_STRING);
        $lesMois = $pdo->getMoisFicheDeFrais();
        $moisASelectionner = $leMois;
        include 'vues/v_SelectMois.php';
        include 'vues/v_SelectVisiteur.php';
        $infoFicheDeFrais = $pdo->getLesInfosFicheFrais($idVisiteur, $_SESSION['date']);
        $infoFraisForfait = $pdo->getLesFraisForfait($idVisiteur, $_SESSION['date']);
        $infoFraisHorsForfait = $pdo->getLesFraisHorsForfait($idVisiteur, $_SESSION['date']);
        include'vues/v_ValiderrFicheDeFrais.php';
}