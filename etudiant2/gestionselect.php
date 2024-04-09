<!DOCTYPE html>
<html>
<head>
    <title>Suivi de remboursement des Fraisss</title>
    <link rel="stylesheet" href="index.css">

</head>
<body class="gestionselect-body">
<?php
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $VIS_ID = $_GET["VIS_ID"];
    $FFR_ID = $_GET["FFR_ID"];
}
$cnxBDD = new mysqli("localhost", "root", "Iroise29", "nexusinformatique", 3306);
$sql = "SELECT VIS_ID, VIS_NOM, VIS_PRENOM, VIS_ADRESSE, VIS_CP, VIS_VILLE, VIS_DATE_EMBAUCHE FROM visiteur WHERE VIS_ID='$VIS_ID'";
$result = $cnxBDD->query($sql);

foreach($result as $ligne) {
    $VIS_ID = $ligne['VIS_ID'];
    $VIS_NOM = $ligne['VIS_NOM'];
    $VIS_PRENOM = $ligne['VIS_PRENOM'];
}

?>

<div class="gestionselect-Div">
    <h1 class="gestionselect-h1"><a href="http://lab.sio-estran.fr:18102/KERFOURN/depot/fichedefrais.php?VIS_ID=<?= $VIS_ID ?>">Suivi de remboursement des Frais </a><i class="fa-solid fa-hippo"></i></h1>
</div>
<div class="gestionselect-Div2">
	<h2>Fiche de frais : <?php echo $VIS_NOM; ?></h2>
</div>
<table class="gestionselect-table">
    <thead>
    <tr>
        <th class="gestionselect-th">Repas midi</th>
        <th class="gestionselect-th">Nuitée</th>
        <th class="gestionselect-th">Etape</th>
        <th class="gestionselect-th">Km</th>
        <th class="gestionselect-th">Situation</th>
        <th class="gestionselect-th">Date opération</th> 
        <th class="gestionselect-th">Remboursement</th>
    </tr>
    </thead>
    <tbody>
    <?php
    $cnxBDD = new mysqli("localhost", "root", "Iroise29", "nexusinformatique", 3306);
    $sql = "SELECT FFR_ID, FFR_ANNEE, FFR_MOIS, FFR_MONTANT_VALIDE, ETA_ID, VIS_ID, FFR_DATE_MODIF FROM fiche_frais WHERE FFR_ID='$FFR_ID' ORDER BY FFR_ANNEE, FFR_MOIS";
    $result = $cnxBDD->query($sql);

    foreach ($result as $ligne) {
        $FFR_ANNEE = $ligne['FFR_ANNEE'];
        $FFR_MOIS = $ligne['FFR_MOIS'];
        $FFR_MONTANT_VALIDE = $ligne['FFR_MONTANT_VALIDE'];
        $ETA_ID = $ligne['ETA_ID'];
        $VIS_ID = $ligne['VIS_ID'];
        $FFR_ID = $ligne['FFR_ID'];
		$FFR_DATE_MODIF = $ligne['FFR_DATE_MODIF'];
    }

	if ($ETA_ID== "CL" ){
		$ETA="Clôturé";
	} else {
		if ($ETA_ID== "CR"){
			$ETA="En cours";
		} else {
			$ETA="Remboursé";
		}
	}

    $sql = "SELECT FOR_ID, LIG_QTE FROM ligne_frais_forfait WHERE FFR_ID='$FFR_ID'";
    $result = $cnxBDD->query($sql);
	?>
	<tr>
	<td class="gestionselect-td">
	<?php
    foreach ($result as $ligne) {
        $FOR_ID = $ligne['FOR_ID'];
        $LIG_QTE = $ligne['LIG_QTE'];
        if ($FOR_ID == "REP") {
            echo "$LIG_QTE";
            break;
        }
    }
	?>
	</td>

	<td class="gestionselect-td">
	<?php
	foreach ($result as $ligne) {
        $FOR_ID = $ligne['FOR_ID'];
        $LIG_QTE = $ligne['LIG_QTE'];
        if ($FOR_ID == "NUI") {
            echo "$LIG_QTE";
            break;
        }
    }
	?>

	</td>
	<td class="gestionselect-td">
	<?php
	foreach ($result as $ligne) {
        $FOR_ID = $ligne['FOR_ID'];
        $LIG_QTE = $ligne['LIG_QTE'];
        if ($FOR_ID == "ETP") {
            echo "$LIG_QTE";
            break;
        }
    }
	?>

	</td>
	<td class="gestionselect-td">
	<?php
	foreach ($result as $ligne) {
        $FOR_ID = $ligne['FOR_ID'];
        $LIG_QTE = $ligne['LIG_QTE'];
        if ($FOR_ID == "KM") {
            echo "$LIG_QTE";
            break;
        }
    }
	?>

	</td>
	<td class="gestionselect-td"><?= $ETA ?></td>
	<td class="gestionselect-td"><?= $FFR_DATE_MODIF ?></td>
	<td class="gestionselect-td"><?= $FFR_MONTANT_VALIDE ?></td>
	</tr>
	<?php

    $cnxBDD->close();
    ?>
    </tbody>
</table>

</body>
</html>
