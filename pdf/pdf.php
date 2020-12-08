
<?php
// Connexion à la BDD
$bddname = 'gsb_frais';
$hostname = 'localhost';
$username = 'userGsb';
$password = 'secret';
$db = mysqli_connect($hostname, $username, $password, $bddname);
// Appel de la librairie FPDF
require("fpdf.php");

// Création de la class PDF
class PDF extends FPDF {

    // En-tête
    function Header() {// Positionnement à 1,5 cm du bas
        $this->SetY(50);
        // Logo
        $this->Image('../images/logo.jpg', 75, 6, 60);
        // Police Arial gras 15
        $this->SetFont('Arial', 'B', 15);
        // Décalage à droite
        $this->Cell(40);
        // Titre
        $this->Cell(110, 10, 'REMBOURSEMENT DE FRAIS ENGAGES', 1, 0, 'C');
        // Saut de ligne
        $this->Ln(20);
    }

// Pied de page
    function Footer() {
        // Positionnement à 1,5 cm du bas
        $this->SetY(-15);
        // Police Arial italique 8
        $this->SetFont('Arial', 'I', 8);
        // Numéro de page
        $this->Cell(0, 10, 'Page ' . $this->PageNo() . '/{nb}', 0, 0, 'C');
    }

}

// Instanciation de la classe dérivée
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Times', '', 12);

$unId = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_STRING);
$req = "SELECT id, CONCAT(nom, ' ', prenom)as nomvisiteur FROM visiteur WHERE id='$unId'";
$rep = mysqli_query($db, $req);
$row = mysqli_fetch_array($rep);
// Infos de la commande calées à gauche
$pdf->Text(10,78,'Visiteur : '.$row['id']);
$pdf->Text(10,83,'Nom : '.$row['nomvisiteur']);

// Position de l'entête à 10mm des infos (48 + 10)
$position_entete = 58;

function entete_table($position_entete){
    global $pdf;
    $pdf->SetDrawColor(183); // Couleur du fond
    $pdf->SetFillColor(221); // Couleur des filets
    $pdf->SetTextColor(0); // Couleur du texte
    $pdf->SetY($position_entete);
    $pdf->SetY(95);
    $pdf->SetX(15);
    $pdf->Cell(45,10,'Frais Forfaitaires',1,0,'L',1);
    $pdf->SetX(60); // 8 + 96
    $pdf->Cell(45,10,'Quantite',1,0,'C',1);
    $pdf->SetX(105); // 104 + 10
    $pdf->Cell(45,10,'Montant unitaire',1,0,'C',1);
    $pdf->SetX(150); // 104 + 10
    $pdf->Cell(45,10,'Total',1,0,'C',1);
    $pdf->Ln(); // Retour à la ligne
}
entete_table($position_entete);

// Liste des détails
$position_detail = 66; // Position à 8mm de l'entête

$req2 = "SELECT libelle, montant, quantite FROM fraisforfait inner join lignefraisforfait on lignefraisforfait.idfraisforfait = fraisforfait.id WHERE idvisiteur='$unId'";
$rep2 = mysqli_query($db, $req2);
while ($row2 = mysqli_fetch_array($rep2)) {
    $pdf->SetY($position_detail);
    $pdf->SetX(8);
    $pdf->MultiCell(158,8,utf8_decode($row2['libelle']),1,'L');
    $pdf->SetY($position_detail);
    $pdf->SetX(166);
    $pdf->MultiCell(10,8,$row2['quantite'],1,'C');
    $pdf->SetY($position_detail);
    $pdf->SetX(176);
    $pdf->MultiCell(24,8,$row2['montant'],1,'R');
    $position_detail += 8;
}
$pdf->Output();



?>
