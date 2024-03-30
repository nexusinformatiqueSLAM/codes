<!DOCTYPE html>
<html>
<head>
    <title>Suivi de remboursement des Frais</title>
    <style>
        body {
            background-color: rgb(123, 170, 219, 255);
            color: white;
            font-family: Verdana;
        }

        h1 {
            font-size: 36px;
            font-style: italic;
            display: inline-block;
            margin: 0;
            padding: 10px;
        }

        img {
            display: inline-block;
            height: 50px;
            width: 50px;
            margin-left: 10px;
        }

        form {
            margin-top: 50px;
            margin-bottom: 50px;
        }

        label {
            display: block;
            margin-bottom: 10px;
        }

        input[type="text"],
        input[type="number"] {
            display: block;
            margin-bottom: 20px;
            padding: 5px;
            border-radius: 5px;
            border: none;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.3);
            width: 200px;
        }

        input[type="submit"] {
            background-color: #333;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.3);
            cursor: pointer;
        }

        table {
            margin-top: 50px;
            border-collapse: collapse;
            width: 100%;
        }

        th,
        td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid white; /* Changed from 0px to 1px */
        }

        th {
            color: white;
        }

        .maDiv {
            width: 100%;
            height: 50%;
            background-color: white;
            color: rgb(121, 153, 221);
        }
		.maDiv2 {
            width: 100%;
            height: 60%;
            background-color: rgb(226,238,254,255);
            color: rgb(121, 153, 221);
        }
    </style>
</head>
<body>
<?php
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $VIS_ID = $_GET["VIS_ID"];
    $FFR_ID = $_GET["FFR_ID"];
}
$cnxBDD = new mysqli("localhost", "root", "Iroise29", "nexusinformatique", 3306);
$sql = "SELECT VIS_ID, VIS_NOM, VIS_PRENOM, VIS_ADRESSE, VIS_CP, VIS_VILLE, VIS_DATE_EMBAUCHE FROM visiteur WHERE VIS_ID='$VIS_ID'"; // Changed 'ED' to '$VIS_ID'
$result = $cnxBDD->query($sql);

foreach($result as $ligne) {
    $VIS_ID = $ligne['VIS_ID'];
    $VIS_NOM = $ligne['VIS_NOM'];
    $VIS_PRENOM = $ligne['VIS_PRENOM'];
}

?>

<div class="maDiv">
    <h1><a href="http://lab.sio-estran.fr:18102/KERFOURN/depot/fichedefrais.php?VIS_ID=<?= $VIS_ID ?>">Suivi de remboursement des Frais </a><i class="fa-solid fa-hippo"></i></h1>
</div>
<div class="maDiv2">
	<h2>Fiche de frais : <?php echo $VIS_NOM; ?></h2>
</div>
<table>
    <thead>
    <tr>
        <th>Repas midi</th>
        <th>Nuitée</th>
        <th>Etape</th>
        <th>Km</th>
        <th>Situation</th>
        <th>Date opération</th> 
        <th>Remboursement</th>
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
	<td>
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

	<td>
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
	<td>
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
	<td>
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
	<td><?= $ETA ?></td>
	<td><?= $FFR_DATE_MODIF ?></td>
	<td><?= $FFR_MONTANT_VALIDE ?></td>
	</tr>
	<?php

    $cnxBDD->close();
    ?>
    </tbody>
</table>

</body>
</html>
