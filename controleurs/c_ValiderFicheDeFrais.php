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
        include'vues/v_ValiderFicheDeFrais.php';

        break;
    case 'CorrigerNbJustificatifs' :
        $lesMois = $pdo->getMoisFicheDeFrais();
        // Afin de sélectionner par défaut le dernier mois dans la zone de liste
        // on demande toutes les clés, et on prend la première,
        // les mois étant triés décroissants
        $lesCles = array_keys($lesMois);
        $moisASelectionner = $lesCles[0];
        include 'vues/v_SelectMois.php';
        $lesVisiteur = $pdo->getVisiteurFromMois($mois);
        $selectedValue = $lesVisiteur[0];
        include 'vues/v_SelectVisiteur.php';
        $nbJust = filter_input(INPUT_POST, 'nbJust', FILTER_DEFAULT);
        $pdo->majNbJustificatifs($idvisi, $mois, $nbJust);
        $infoFicheDeFrais = $pdo->getLesInfosFicheFrais($idvisi, $mois);
        $infoFraisForfait = $pdo->getLesFraisForfait($idvisi, $mois);
        $infoFraisHorsForfait = $pdo->getLesFraisHorsForfait($idvisi, $mois);
        include'vues/v_ValiderFicheDeFrais.php';
        ?>
        <script>alert("<?php echo htmlspecialchars('Votre fiche de frais a bien été corrigée ! ', ENT_QUOTES); ?>")</script>
        <?php
        break;
    case 'CorrigerFraisForfait':
        $lesMois = $pdo->getMoisFicheDeFrais();
        $lesCles = array_keys($lesMois);
        $moisASelectionner = $lesCles[0];
        include 'vues/v_SelectMois.php';
        $lesVisiteur = $pdo->getVisiteurFromMois($mois);
        $selectedValue = $lesVisiteur[0];
        include 'vues/v_SelectVisiteur.php';
        $lesFrais = filter_input(INPUT_POST, 'lesFrais', FILTER_DEFAULT, FILTER_FORCE_ARRAY);
        var_dump($lesFrais);
        if (lesQteFraisValides($lesFrais)) {
            $pdo->majFraisForfait($idvisi, $mois, $lesFrais);
            ?>
            <script>alert("<?php echo htmlspecialchars('Votre fiche de frais a bien été corrigée ! ', ENT_QUOTES); ?>")</script>
            <?php
        } else {
            ajouterErreur('Les valeurs des frais doivent être numériques');
            include 'vues/v_erreurs.php';
        }
        $infoFicheDeFrais = $pdo->getLesInfosFicheFrais($idvisi, $mois);
        $infoFraisForfait = $pdo->getLesFraisForfait($idvisi, $mois);
        $infoFraisHorsForfait = $pdo->getLesFraisHorsForfait($idvisi, $mois);
        include'vues/v_ValiderFicheDeFrais.php';
        break;
    case 'CorrigerElemHorsForfait' :
        $lesMois = $pdo->getMoisFicheDeFrais();
        $lesCles = array_keys($lesMois);
        $moisASelectionner = $lesCles[0];
        include 'vues/v_SelectMois.php';
        $lesVisiteur = $pdo->getVisiteurFromMois($mois);
        $selectedValue = $lesVisiteur[0];
        include 'vues/v_SelectVisiteur.php';
        $lesHorsForfait = filter_input(INPUT_POST, 'lesLibelles', FILTER_DEFAULT);
        var_dump($lesHorsForfait);
        /*$pdo->majFraisHorsForfait($idvisi, $mois, $lesHorsForfait);*/
        $infoFicheDeFrais = $pdo->getLesInfosFicheFrais($idvisi, $mois);
        $infoFraisForfait = $pdo->getLesFraisForfait($idvisi, $mois);
        $infoFraisHorsForfait = $pdo->getLesFraisHorsForfait($idvisi, $mois);
        include'vues/v_ValiderFicheDeFrais.php';
        break;
}
