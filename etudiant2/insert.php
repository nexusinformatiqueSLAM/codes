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
    $month = $_GET["month"];
    $year = $_GET["year"];
    $repas = $_GET["repas"];
    $nuitees = $_GET["nuitees"];
    $etape = $_GET["etape"];
    $km = $_GET["km"];
    $VIS_ID = $_GET["VIS_ID"];
}

$date_modif = date("Y-m-d");

$total_etape = $etape * $ETP;
$total_repas = $repas * $REP;
$total_nuitees = $nuitees * $NUI;
$total_km = $km * $KM;
$total_montant_valide = $total_repas + $total_nuitees + $total_km + $total_etape;

$sql = "INSERT INTO ligne_frais_forfait (FFR_ID, FOR_ID, LIG_QTE) VALUES ('$ID_FFR', '$REP_ID','$repas')";
$result = $cnxBDD->query($sql);

$sql = "INSERT INTO ligne_frais_forfait (FFR_ID, FOR_ID, LIG_QTE) VALUES ('$ID_FFR', '$KM_ID','$km')";
$result = $cnxBDD->query($sql);

$sql = "INSERT INTO ligne_frais_forfait (FFR_ID, FOR_ID, LIG_QTE) VALUES ('$ID_FFR', '$NUI_ID','$nuitees')";
$result = $cnxBDD->query($sql);

$sql = "INSERT INTO ligne_frais_forfait (FFR_ID, FOR_ID, LIG_QTE) VALUES ('$ID_FFR', '$ETP_ID','$etape')";
$result = $cnxBDD->query($sql);

$sql = "INSERT INTO fiche_frais (FFR_ID, VIS_ID, ETA_ID, FFR_ANNEE, FFR_MOIS, FFR_MONTANT_VALIDE, FFR_NB_JUSTIFICATIFS, FFR_DATE_MODIF) VALUES ('$ID_FFR', '$VIS_ID','CR','$year', '$month', '$total_montant_valide', '$etape', '$date_modif')";
$result = $cnxBDD->query($sql);

$cnxBDD->close();

header("location: http://lab.sio-estran.fr:18102/KERFOURN/depot/gestionfraisforfait.php?VIS_ID=$VIS_ID");
exit();
?>
