<!DOCTYPE html>
<html>
<head>
	<title>Modfication des Frais</title>
	<link rel="stylesheet" href="index.css">

</head>
<body class="gestionupdate-body">
	<?php
	    if ($_SERVER["REQUEST_METHOD"] == "GET") {
			$FFR_ID = $_GET["FFR_ID"];
			$VIS_ID = $_GET["VIS_ID"];
		}
	
	?>

    <div class="gestionupdate-div">
        <h1 class="gestionupdate-h1"><a href="http://lab.sio-estran.fr:18102/KERFOURN/depot/fichedefrais.php?VIS_ID=<?= $VIS_ID ?>" class="fichedefrais-a">Modfication des Frais</a> <i class="fa-solid fa-hippo"></i></h1>
        <div class="GSB-div">
				<img src="http://lab.sio-estran.fr:18102/KERFOURN/depot/images/gsb.png" class="GSB-img"/>
    </div>
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
    <form action="update.php" method="get" class="gestionupdate-form">
        <input type="hidden" name="FFR_ID" value="<?php echo $FFR_ID; ?>">
        <legend><h2>Date de la fiche de frais <?php echo $FFR_MOIS; echo " "; echo $FFR_ANNEE;?></h2> </legend>
        <br />
        <fieldset>
			<input type="hidden" name="VIS_ID" value="<?php echo $VIS_ID; ?>">
            <legend>Frais au forfait</legend>
			
            <table class="gestionupdate-table">
                <tr>
                    <th class="gestionupdate-th">Repas midi :</th>
                    <td class="gestionupdate-td"><input type="number" id="repas" name="repas" required></td>
                </tr>
                <tr>
                    <th class="gestionupdate-th">Nuitées :</th>
                    <td class="gestionupdate-td"><input type="number" id="nuitees" name="nuitees" required></td>
                </tr>
                <tr>
                    <th class="gestionupdate-th">Etape :</th>
                    <td class="gestionupdate-td"><input type="number" id="etape" name="etape" required></td>
                </tr>
                <tr>
                    <th class="gestionupdate-th">Km :</th>
                    <td class="gestionupdate-td"><input type="number" id="km" name="km" required></td>
                </tr>
            </table>
        </fieldset>
        <input type="submit" value="Soumettre la requête" class="gestionupdate-input">
    </form>
</body>
</html>
