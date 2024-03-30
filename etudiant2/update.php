<?php

$servername = "localhost";
$username = "root";
$password = "Iroise29";
$database = "nexusinformatique";

$cnxBDD = new mysqli($servername, $username, $password, $database, 3306);

$sql = "SELECT FFR_ANNEE, FFR_MOIS, FFR_MONTANT_VALIDE, ETA_ID, VIS_ID FROM fiche_frais"; 
$result = $cnxBDD->query($sql);

foreach($result as $ligne) {
    $FFR_ANNEE = $ligne['FFR_ANNEE'];
    $FFR_MOIS = $ligne['FFR_MOIS'];
    $FFR_MONTANT_VALIDE = $ligne['FFR_MONTANT_VALIDE'];
    $ETA_ID = $ligne['ETA_ID'];
    $VIS_ID = $ligne['VIS_ID'];
}

$sql = "SELECT FOR_ID, FOR_LIB, FOR_MONTANT FROM frais_forfait WHERE FOR_ID='ETP'"; 
$result = $cnxBDD->query($sql);

foreach($result as $ligne) {
    $ETP = $ligne['FOR_MONTANT'];
    $ETP_ID = $ligne['FOR_ID'];
}

$sql = "SELECT FOR_ID, FOR_LIB, FOR_MONTANT FROM frais_forfait WHERE FOR_ID='KM'"; 
$result = $cnxBDD->query($sql);

foreach($result as $ligne) {
    $KM = $ligne['FOR_MONTANT'];
    $KM_ID = $ligne['FOR_ID'];
}

$sql = "SELECT FOR_ID, FOR_LIB, FOR_MONTANT FROM frais_forfait WHERE FOR_ID='NUI'"; 
$result = $cnxBDD->query($sql);

foreach($result as $ligne) {
    $NUI = $ligne['FOR_MONTANT'];
    $NUI_ID=$ligne['FOR_ID'];
}

$sql = "SELECT MAX(FFR_ID) AS max_id FROM ligne_frais_forfait"; 
$result = $cnxBDD->query($sql);
$row = $result->fetch_assoc();
$ID_FFR = $row['max_id'] + 1;

$sql = "SELECT FOR_ID, FOR_LIB, FOR_MONTANT FROM frais_forfait WHERE FOR_ID='REP'"; 
$result = $cnxBDD->query($sql);

foreach($result as $ligne) {
    $REP = $ligne['FOR_MONTANT'];
    $REP_ID=$ligne['FOR_ID'];
}

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $FFR_ID = $_GET["FFR_ID"];
    $repas = $_GET["repas"];
    $nuitees = $_GET["nuitees"];
    $etape = $_GET["etape"];
    $km = $_GET["km"];
    $VIS_ID = $_GET["VIS_ID"];
}

$date_modif = date("Y-m-d");

$total_etape = $etape* $ETP;
$total_repas = $repas * $REP;
$total_nuitees = $nuitees * $NUI;
$total_km = $km * $KM;
$total_montant_valide = $total_repas + $total_nuitees + $total_km + $total_etape;

$sql = "UPDATE ligne_frais_forfait SET LIG_QTE='$repas' WHERE FFR_ID='$FFR_ID' AND FOR_ID='REP'";
$result = $cnxBDD->query($sql);

$sql = "UPDATE ligne_frais_forfait SET LIG_QTE='$nuitees' WHERE FFR_ID='$FFR_ID' AND FOR_ID='NUI'";
$result = $cnxBDD->query($sql);

$sql = "UPDATE ligne_frais_forfait SET LIG_QTE='$etape' WHERE FFR_ID='$FFR_ID' AND FOR_ID='ETP'";
$result = $cnxBDD->query($sql);

$sql = "UPDATE ligne_frais_forfait SET LIG_QTE='$km' WHERE FFR_ID='$FFR_ID' AND FOR_ID='KM'";
$result = $cnxBDD->query($sql);

$sql = "UPDATE fiche_frais SET FFR_MONTANT_VALIDE='$total_montant_valide', FFR_NB_JUSTIFICATIFS='$etape' WHERE FFR_ID='$FFR_ID'";
$result = $cnxBDD->query($sql);



$cnxBDD->close();

header("location: http://lab.sio-estran.fr:18102/KERFOURN/depot/gestionupdate.php?FFR_ID=$FFR_ID&VIS_ID=$VIS_ID");
exit();
?>
