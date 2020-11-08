<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


$lesMois=$pdo->getMoisFicheDeFrais();
$clee=array_keys($lesMois);
$moisASelectionne = $clee[0];
$idVisiteur = filter_input(INPUT_POST, 'lstVisiteur', FILTER_SANITIZE_STRING);
$infoFicheDeFrais = $pdo->getLesInfosFicheFrais($idVisiteur, $_SESSION['date']);
$infoFraisForfait=$pdo->getLesFraisForfait($idVisiteur, $_SESSION['date']);
$infoFraisHorsForfait=$pdo->getLesFraisHorsForfait($idVisiteur, $_SESSION['date']);

require'vues/v_ValiderFicheDeFrais.php';