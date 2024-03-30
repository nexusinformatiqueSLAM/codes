<!DOCTYPE html>
<html>
<head>
	<title>Modfication des Frais</title>
	<style>
		body {
			background-color: rgb(123,170,219,255);
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
		input[type="text"] {
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
		th, td {
			padding: 10px;
			text-align: left;
			border-bottom: 0px solid white;
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
	</style>
</head>
<body>
	<?php
	    if ($_SERVER["REQUEST_METHOD"] == "GET") {
			$FFR_ID = $_GET["FFR_ID"];
			$VIS_ID = $_GET["VIS_ID"];
		}
	
	?>

    <div class="maDiv">
        <h1><a href="http://lab.sio-estran.fr:18102/KERFOURN/depot/fichedefrais.php?VIS_ID=<?= $VIS_ID ?>">Modfication des Frais</a> <i class="fa-solid fa-hippo"></i></h1>
    </div>
    <?php


    $cnxBDD = new mysqli("localhost", "root", "Iroise29", "nexusinformatique", 3306);
    $sql = "SELECT FFR_ID, FOR_ID, LIG_QTE FROM ligne_frais_forfait WHERE FFR_ID=$FFR_ID";
    $result = $cnxBDD->query($sql);

    foreach ($result as $ligne) {
        $FOR_ID = $ligne['FOR_ID'];
        $LIG_QTE = $ligne['LIG_QTE'];
    }

    $cnxBDD = new mysqli("localhost", "root", "Iroise29", "nexusinformatique", 3306);
    $sql = "SELECT FFR_ID, VIS_ID, ETA_ID, FFR_ANNEE, FFR_MOIS, FFR_MONTANT_VALIDE, FFR_NB_JUSTIFICATIFS, FFR_DATE_MODIF FROM fiche_frais WHERE FFR_ID=$FFR_ID";
    $result = $cnxBDD->query($sql);

    foreach ($result as $ligne) {
        $FFR_ANNEE = $ligne['FFR_ANNEE'];
        $FFR_MOIS = $ligne['FFR_MOIS'];
        $FFR_MONTANT_VALIDE = $ligne['FFR_MONTANT_VALIDE'];
        $ETA_ID = $ligne['ETA_ID'];
        $VIS_ID = $ligne['VIS_ID'];
        $FFR_ID = $ligne['FFR_ID'];
    }
    ?>
    <form action="update.php" method="get">
        <input type="hidden" name="FFR_ID" value="<?php echo $FFR_ID; ?>">
        <legend><h2>Date de la fiche de frais <?php echo $FFR_MOIS; echo " "; echo $FFR_ANNEE;?></h2> </legend>
        <br />
        <fieldset>
			<input type="hidden" name="VIS_ID" value="<?php echo $VIS_ID; ?>">
            <legend>Frais au forfait</legend>
			
            <table>
                <tr>
                    <th>Repas midi :</th>
                    <td><input type="number" id="repas" name="repas" required></td>
                </tr>
                <tr>
                    <th>Nuitées :</th>
                    <td><input type="number" id="nuitees" name="nuitees" required></td>
                </tr>
                <tr>
                    <th>Etape :</th>
                    <td><input type="number" id="etape" name="etape" required></td>
                </tr>
                <tr>
                    <th>Km :</th>
                    <td><input type="number" id="km" name="km" required></td>
                </tr>
            </table>
        </fieldset>
        <input type="submit" value="Soumettre la requête">
    </form>
</body>
</html>
