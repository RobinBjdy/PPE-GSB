<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_STRING);
$idVisiteur = filter_input(INPUT_POST, 'lstVisiteur', FILTER_SANITIZE_STRING);
$montants = 0;
$pdo->ClotureFiche();
switch ($action) {
    case 'selectionnerMois' :
        if (empty($pdo->getMoisFicheDeFrais())) {
            ?></br><?php
            ajouterErreur("Aucune fiche de frais n'est à valider");
            include 'vues/v_erreurs.php';
            include 'vues/v_SelectMois.php';
        } else {
            $lesMois = $pdo->getMoisFicheDeFrais();
            // Afin de sélectionner par défaut le dernier mois dans la zone de liste
            // on demande toutes les clés, et on prend la première,
            // les mois étant triés décroissants
            $lesCles = array_keys($lesMois);
            $moisASelectionne = $lesCles[0];
            include 'vues/v_SelectMois.php';
        }
        break;
    case 'selectionnerVisiteur' :
        $leMois = filter_input(INPUT_POST, 'lstMois', FILTER_SANITIZE_STRING);
        $lesMois = $pdo->getMoisFicheDeFrais();
        $moisASelectionne = $leMois;
        include 'vues/v_SelectMois.php';
        //La variable $date prendra la valeur du mois selectionné
        $date = str_replace('/', '', filter_input(INPUT_POST, 'lstMois', FILTER_SANITIZE_STRING));
        trim($date);
        $_SESSION['date'] = $date;
        //Selection des visiteur en fonction du mois
        $lesVisiteur = $pdo->getVisiteurFromMois($date);
        $selectedValue = $lesVisiteur[0];
        include 'vues/v_SelectVisiteur.php';
        break;
    case 'ValiderFicheDeFrais':
        $lesMois = $pdo->getMoisFicheDeFrais();
        $moisASelectionne = $_SESSION['date'];
        include 'vues/v_SelectMois.php';
        $leVisiteur = filter_input(INPUT_POST, 'lstVisiteur', FILTER_SANITIZE_STRING);
        $lesVisiteur = $pdo->getVisiteurFromMois($_SESSION['date']);
        $selectedValue = $leVisiteur;
        include 'vues/v_SelectVisiteur.php';
        //Recupère le nom du visiteur selectionné
        $nomVis = (filter_input(INPUT_POST, 'lstVisiteur', FILTER_SANITIZE_STRING));
        trim($nomVis);
        $_SESSION['nomVisiteur'] = $nomVis;
        //Avoir l'id du visiteur en fonction de son nom-prenom
        $idVis = $pdo->getIdFromNomVisiteur($nomVis);
        $_SESSION['visiteur'] = $idVis['id'];
        //Selection de toutes les infos concernant le visiteur selectionné
        $infoFicheDeFrais = $pdo->getLesInfosFicheFrais($_SESSION['visiteur'], $_SESSION['date']);
        $infoFraisForfait = $pdo->getLesFraisForfait($_SESSION['visiteur'], $_SESSION['date']);
        $infoFraisHorsForfait = $pdo->getLesFraisHorsForfait($_SESSION['visiteur'], $_SESSION['date']);
        include'vues/v_ValiderFicheDeFrais.php';
        $_SESSION['montant'] = $montants;
        break;
    case 'CorrigerNbJustificatifs' :
        $lesMois = $pdo->getMoisFicheDeFrais();
        $moisASelectionne = $_SESSION['date'];
        include 'vues/v_SelectMois.php';
        $lesVisiteur = $pdo->getVisiteurFromMois($_SESSION['date']);
        $selectedValue = $_SESSION['nomVisiteur'];
        include 'vues/v_SelectVisiteur.php';
        //La variable $nbJust prendra la valeur du nombre de justificatif indiqué
        $nbJust = filter_input(INPUT_POST, 'nbJust', FILTER_DEFAULT);
        //Test de la valeur si elle est un entier positif
        if (estEntierPositif($nbJust)) {
            $pdo->majNbJustificatifs($_SESSION['visiteur'], $_SESSION['date'], $nbJust);
            ?>
            <script>alert("<?php echo htmlspecialchars('Votre fiche de frais a bien été corrigée ! ', ENT_QUOTES); ?>")</script>
            <?php
        } else {
            ajouterErreur('Les valeurs des frais doivent être numériques');
            include 'vues/v_erreurs.php';
        }
        $infoFicheDeFrais = $pdo->getLesInfosFicheFrais($_SESSION['visiteur'], $_SESSION['date']);
        $infoFraisForfait = $pdo->getLesFraisForfait($_SESSION['visiteur'], $_SESSION['date']);
        $infoFraisHorsForfait = $pdo->getLesFraisHorsForfait($_SESSION['visiteur'], $_SESSION['date']);
        include'vues/v_ValiderFicheDeFrais.php';

        break;
    case 'CorrigerFraisForfait':
        $lesMois = $pdo->getMoisFicheDeFrais();
        $moisASelectionne = $_SESSION['date'];
        include 'vues/v_SelectMois.php';
        $lesVisiteur = $pdo->getVisiteurFromMois($_SESSION['date']);
        $selectedValue = $_SESSION['nomVisiteur'];
        include 'vues/v_SelectVisiteur.php';
        //La variable $lesFrais sera un tableau avec les valeurs des différents frais indiqués
        $lesFrais = filter_input(INPUT_POST, 'lesFrais', FILTER_DEFAULT, FILTER_FORCE_ARRAY);
        //Test si les quantités sont valides
        if (lesQteFraisValides($lesFrais)) {
            $pdo->majFraisForfait($_SESSION['visiteur'], $_SESSION['date'], $lesFrais);
            ?>
            <script>alert("<?php echo htmlspecialchars('Votre fiche de frais a bien été corrigée ! ', ENT_QUOTES); ?>")</script>
            <?php
        } else {
            ajouterErreur('Les valeurs des frais doivent être numériques');
            include 'vues/v_erreurs.php';
        }
        $infoFicheDeFrais = $pdo->getLesInfosFicheFrais($_SESSION['visiteur'], $_SESSION['date']);
        $infoFraisForfait = $pdo->getLesFraisForfait($_SESSION['visiteur'], $_SESSION['date']);
        $infoFraisHorsForfait = $pdo->getLesFraisHorsForfait($_SESSION['visiteur'], $_SESSION['date']);
        include'vues/v_ValiderFicheDeFrais.php';
        break;
    case 'CorrigerElemHorsForfait' :
        $lesMois = $pdo->getMoisFicheDeFrais();
        $moisASelectionne = $_SESSION['date'];
        include 'vues/v_SelectMois.php';
        $lesVisiteur = $pdo->getVisiteurFromMois($_SESSION['date']);
        $selectedValue = $_SESSION['nomVisiteur'];
        include 'vues/v_SelectVisiteur.php';
        //La variable $lesHorsForfaitDate sera un tableau avec les valeurs des différentes dates indiquées
        $lesHorsForfaitDate = (filter_input(INPUT_POST, 'lesDates', FILTER_DEFAULT, FILTER_FORCE_ARRAY));
        //La variable $lesHorsForfaitLibelle sera un tableau avec les valeurs des différents libelles indiqués
        $lesHorsForfaitLibelle = (filter_input(INPUT_POST, 'lesLibelles', FILTER_DEFAULT, FILTER_FORCE_ARRAY));
        //La variable $lesHorsForfaitMontant sera un tableau avec les valeurs des différents montants indiqués
        $lesHorsForfaitMontant = (filter_input(INPUT_POST, 'lesMontants', FILTER_DEFAULT, FILTER_FORCE_ARRAY));
        //Début des tests
        foreach ($lesHorsForfaitDate as $uneDate) {
            dateAnglaisVersFrancais($uneDate);
            foreach ($lesHorsForfaitLibelle as $unLibelle) {
                foreach ($lesHorsForfaitMontant as $unMontant) {
                    //Test si la date n'est pas n'est pas dépassée de plus d'un an et si le libelle et le montant ne sont pas nuls
                    if (estDateDepassee($uneDate) || ($unLibelle == '') || ($unMontant == '')) {
                        ajouterErreur('Une information est mauvaise. Rappel: date de moins de 1 ans, libelle et montant non null');
                        include 'vues/v_erreurs.php';
                        break 3;
                    } else {
                        $pdo->majFraisHorsForfait($_SESSION['visiteur'], $_SESSION['date'], $lesHorsForfaitLibelle, $lesHorsForfaitMontant, $lesHorsForfaitDate);
                        ?>
                        <script>alert("<?php echo htmlspecialchars('Votre fiche de frais a bien été corrigée ! ', ENT_QUOTES); ?>")</script>
                        <?php
                        break 3;
                    }
                }
            }
        }
        $infoFicheDeFrais = $pdo->getLesInfosFicheFrais($_SESSION['visiteur'], $_SESSION['date']);
        $infoFraisForfait = $pdo->getLesFraisForfait($_SESSION['visiteur'], $_SESSION['date']);
        $infoFraisHorsForfait = $pdo->getLesFraisHorsForfait($_SESSION['visiteur'], $_SESSION['date']);
        include'vues/v_ValiderFicheDeFrais.php';
        break;
    case 'supprimerFrais':
        //Recupère les valeurs concernant le visiteur passées dans l'url
        $unIdFrais = filter_input(INPUT_GET, 'idFrais', FILTER_SANITIZE_NUMBER_INT);
        $ceMois = filter_input(INPUT_GET, 'mois', FILTER_SANITIZE_STRING);
        $idVisiteur = filter_input(INPUT_GET, 'idVisiteur', FILTER_SANITIZE_STRING);
        ?></br>
        <div class="alert alert-info" role="alert">
            <p><h4>Voulez vous modifier ou supprimer le frais?<br></h4>
            <a href="index.php?uc=ValiderFicheDeFrais&action=supprimer&idFrais=<?php echo $unIdFrais ?>">Supprimer</a> 
            ou <a href="index.php?uc=ValiderFicheDeFrais&action=reporter&idFrais=<?php echo $unIdFrais ?>&mois=<?php echo $ceMois ?>&id=<?php echo $idVisiteur ?>">Reporter</a></p>
        </div>
        <?php
        break;
    case 'supprimer':
        //Recupère l'id concernant le visiteur passé dans l'url
        $idFrais = filter_input(INPUT_GET, 'idFrais', FILTER_SANITIZE_NUMBER_INT);
        $pdo->refuserFraisHorsForfait($idFrais);
        ?>
        <div class="alert alert-info" role="alert">
            <p>Ce frais hors forfait a bien été supprimé! <a href = "index.php?uc=ValiderFicheDeFrais&action=selectionnerMois">Cliquez ici</a>
                pour revenir à la selection.</p>
        </div>
        <?php
        break;

    case 'reporter':
        //Recupère les valeurs concernant le visiteur passées dans l'url
        $idFrais = filter_input(INPUT_GET, 'idFrais', FILTER_SANITIZE_NUMBER_INT);
        $mois = filter_input(INPUT_GET, 'mois', FILTER_SANITIZE_STRING);
        $moisSuivant = $pdo->getMoisSuivant($mois);
        $idVisiteur = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_STRING);
        //Test si un fiche de frais existe déjà pour ce mois ou non et sinon créer une nouvelle fiche
        if ($pdo->estPremierFraisMois($idVisiteur, $moisSuivant)) {
            $pdo->creeNouvellesLignesFrais($idVisiteur, $moisSuivant);
        }
        $moisAReporter = $pdo->reporterFraisHorsForfait($idFrais, $mois);
        ?>
        <div class="alert alert-info" role="alert">
            <p>Ce frais hors forfait a bien été reporté au mois suivant! <a href = "index.php?uc=ValiderFicheDeFrais&action=selectionnerMois">Cliquez ici</a>
                pour revenir à la selection.</p>
        </div>
        <?php
        break;
    case 'Valider' :
        $pdo->validerFicheDeFrais($_SESSION['visiteur'], $_SESSION['date'], $_SESSION['montant']);
        ?> </br>
        <div class = "alert alert-success" role = "alert">
            <p>Votre fiche de frais a bien été validée ! <a href = "index.php?uc=ValiderFicheDeFrais&action=selectionnerMois">Cliquez ici</a>
                pour revenir à la selection.</p>
        </div>
    <?php
}
    