<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau d'Opérations</title>
    <link rel="stylesheet" href="index.css">

</head>
<body class = "fichedefrais-body">
<?php
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $VIS_ID = $_GET["VIS_ID"];
}
$cnxBDD = new mysqli("localhost", "root", "Iroise29", "nexusinformatique", 3306);
$sql = "SELECT VIS_ID, VIS_NOM, VIS_PRENOM, VIS_ADRESSE, VIS_CP, VIS_VILLE, VIS_DATE_EMBAUCHE FROM visiteur WHERE VIS_ID='$VIS_ID'";
$result = $cnxBDD->query($sql);

foreach($result as $ligne) {
    $VIS_NOM = $ligne['VIS_NOM'];
    $VIS_PRENOM = $ligne['VIS_PRENOM'];
}
?>

<p><h2>Fiche de frais : <a class = "fichedefrais-a" href="http://lab.sio-estran.fr:18102/KERFOURN/depot/logformulaire.php"><?php echo $VIS_NOM; ?></a></h2><div class="fichedefraisajouter-div"><a class = "fichedefrais-a" href="http://lab.sio-estran.fr:18102/KERFOURN/depot/gestionfraisforfait.php?VIS_ID=<?php echo $VIS_ID; ?>"><div><h1>Ajouter</h1><img src="http://lab.sio-estran.fr:18102/KERFOURN/depot/images/ajouter.png" width="50" height="50" /></div></a></div></p>
    <div class="GSB-div">
				<img src="http://lab.sio-estran.fr:18102/KERFOURN/depot/images/gsb.png" class="GSB-img"/>
    </div>
<table class="fichedefrais-table">
    <thead>
        <tr class = "fichedefrais-tr">
            <th class = "fichedefrais-th">Date</th>
            <th class = "fichedefrais-th">Montant</th>
            <th class = "fichedefrais-th">Etat</th>
            <th class = "fichedefrais-th">Supprimer</th>
            <th class = "fichedefrais-th">Modifier</th>
            <th class = "fichedefrais-th">Voir</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if ($_SERVER["REQUEST_METHOD"] == "GET") {
            $VIS_ID = $_GET["VIS_ID"];
        }
        $cnxBDD = new mysqli("localhost", "root", "Iroise29", "nexusinformatique", 3306);
        $sql = "SELECT FFR_ID, FFR_ANNEE, FFR_MOIS, FFR_MONTANT_VALIDE, ETA_ID, VIS_ID FROM fiche_frais WHERE VIS_ID='$VIS_ID' ORDER BY FFR_ANNEE, FFR_MOIS";
        $result = $cnxBDD->query($sql);

        foreach($result as $ligne) {
            $FFR_ANNEE = $ligne['FFR_ANNEE'];
            $FFR_MOIS = $ligne['FFR_MOIS'];
            $FFR_MONTANT_VALIDE = $ligne['FFR_MONTANT_VALIDE'];
            $ETA_ID = $ligne['ETA_ID'];
            $VIS_ID = $ligne['VIS_ID'];
            $FFR_ID = $ligne['FFR_ID'];
            if ($ETA_ID== "CL" ){
                $ETA="Saisie clôturée";
            } else {
                if ($ETA_ID== "CR"){
                    $ETA="Fiche créée, saisie en cours";
                } else {
                    $ETA="Remboursé";
                }
            }
        ?>
        <tr class = "fichedefrais-tr">
            <td class = "fichedefrais-td"><?= $FFR_ANNEE ?> <?= $FFR_MOIS ?></td>
            <td class = "fichedefrais-td"><?= $FFR_MONTANT_VALIDE?><h>€</h></td>
            <td class = "fichedefrais-td"><?= $ETA ?></td>
            <td class = "fichedefrais-td">
                <?php if ($ETA_ID == "CR") { ?>
                    <form action="delete.php" method="GET">
                        <input type="hidden" name="FFR_ID" value="<?= $FFR_ID ?>">
                        <input type="hidden" name="VIS_ID" value="<?= $VIS_ID ?>">
                        <button type="submit" class = "fichedefrais-button" ><img src="http://lab.sio-estran.fr:18102/KERFOURN/depot/images/supprimer.png" alt="Supprimer" width="30" height="30"></button>
                    </form>
                <?php } ?>
            </td>
            <td class = "fichedefrais-td">
                <?php if ($ETA_ID == "CR") { ?>
                    <form action="gestionupdate.php" method="GET">
                        <input type="hidden" name="FFR_ID" value="<?= $FFR_ID ?>">
                        <input type="hidden" name="VIS_ID" value="<?= $VIS_ID ?>">
                        <button type="submit" class = "fichedefrais-button"><img src="http://lab.sio-estran.fr:18102/KERFOURN/depot/images/modifier.png" alt="Modifier" width="30" height="30"></button>
                    </form>
                <?php } ?>
            </td>
            <td class = "fichedefrais-td">
                <form action="gestionselect.php" method="GET">
                    <input type="hidden" name="FFR_ID" value="<?= $FFR_ID ?>">
                    <input type="hidden" name="VIS_ID" value="<?= $VIS_ID ?>">
                    <button type="submit" class = "fichedefrais-button"><img src="http://lab.sio-estran.fr:18102/KERFOURN/depot/images/voir.png" alt="Voir" width="30" height="30"></button>
                </form>
            </td>
        </tr>
        <?php
        }
        $cnxBDD->close();
        ?>
    </tbody>
</table>

</body>
</html>
