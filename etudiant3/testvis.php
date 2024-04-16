<?php
$servername = "localhost";
$username = "root";
$password = "Iroise29"; 
$database = "nexusinformatique";

// Création de la connexion
$cnxBDD = new mysqli($servername, $username, $password, $database);

// Vérification de la connexion
if ($cnxBDD->connect_error) {
    die("Échec de la connexion : " . $cnxBDD->connect_error);
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Validation des frais par visiteur</title>
    <link rel="stylesheet" href="index.css">
    <style>
        body {
            background-color: orange;
            color: white;
            font-family: Arial, sans-serif;
        }
        table {
            border-collapse: collapse;
            width: 100%;
        }
        th, td {
            border: 1px solid white;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #333;
        }
    </style>
</head>

<body class="body-style">
    <form method="POST" action="">
    <h1>Validation des frais par visiteur :</h1>
    <form method="POST" action="">
        <select name="nom" required>
            <option disabled selected hidden></option>
            <?php
            $query = $cnxBDD->prepare("SELECT VIS_ID, VIS_PRENOM, VIS_NOM FROM visiteur");
            $query->execute();
            $result = $query->get_result();

            while ($row = $result->fetch_assoc()) {
                echo '<option value="' . $row['VIS_ID'] . '">' . $row['VIS_PRENOM'] . " " . $row['VIS_NOM'] . '</option>';
}

            $query->close();
            ?>
        </select>
        <p>Mois / Annee :  <!-- formulaire de choix du mois et annee -->
            <select name="mois" required>
                <option disabled selected hidden></option>
                <?php
                $moisListe = array('JANVIER', 'FEVRIER', 'MARS', 'AVRIL', 'MAI', 'JUIN', 'JUILLET', 'AOUT', 'SEPTEMBRE', 'OCTOBRE', 'NOVEMBRE', 'DECEMBRE');
                foreach ($moisListe as $mois) {
                    echo '<option value="' . $mois . '">' . $mois . '</option>';
}
                ?>
            </select>

            <select name="annee" required>
            <option disabled selected hidden>Année</option>
            <?php
            for ($annee = 2000; $annee <= 2035; $annee++) {
            echo '<option value="' . $annee . '">' . $annee . '</option>';
}
            ?>
            </select>
        </p>

        <?php
        if (isset($_POST['Envoyer'])) {
            $vis_id = $_POST['nom'];
            $ffr_mois = $_POST['mois'];
            $ffr_annee = $_POST['annee'];

            $query = $cnxBDD->prepare("SELECT FFR_ID FROM fiche_frais WHERE VIS_ID = ? AND FFR_MOIS = ? AND FFR_ANNEE = ?");
            $query->bind_param("sss", $vis_id, $ffr_mois, $ffr_annee);
            $query->execute();
            $result = $query->get_result();

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    

                    // Requête pour les repas
                    $query_rep = $cnxBDD->prepare("SELECT COALESCE(SUM(LIG_QTE), 0) AS total_rep FROM ligne_frais_forfait WHERE FOR_ID = 'REP' AND FFR_ID = ?");
                    $query_rep->bind_param("s", $row['FFR_ID']);
                    $query_rep->execute();
                    $result_rep = $query_rep->get_result();
                    $row_rep = $result_rep->fetch_assoc();
                    $fr_rep_tt = $row_rep['total_rep'];

                    // Requête pour les kilomètres
                    $query_km = $cnxBDD->prepare("SELECT COALESCE(SUM(LIG_QTE), 0) AS total_km FROM ligne_frais_forfait WHERE FOR_ID = 'KM' AND FFR_ID = ?");
                    $query_km->bind_param("s", $row['FFR_ID']);
                    $query_km->execute();
                    $result_km = $query_km->get_result();
                    $row_km = $result_km->fetch_assoc();
                    $fr_km_tt = $row_km['total_km'];

                    // Requête pour les nuitées
                    $query_nui = $cnxBDD->prepare("SELECT COALESCE(SUM(LIG_QTE), 0) AS total_nui FROM ligne_frais_forfait WHERE FOR_ID = 'NUI' AND FFR_ID = ?");
                    $query_nui->bind_param("s", $row['FFR_ID']);
                    $query_nui->execute();
                    $result_nui = $query_nui->get_result();
                    $row_nui = $result_nui->fetch_assoc();
                    $fr_nui_tt = $row_nui['total_nui'];

                    // Requête pour les étapes
                    $query_etp = $cnxBDD->prepare("SELECT COALESCE(SUM(LIG_QTE), 0) AS total_etp FROM ligne_frais_forfait WHERE FOR_ID = 'ETP' AND FFR_ID = ?");
                    $query_etp->bind_param("s", $row['FFR_ID']);
                    $query_etp->execute();
                    $result_etp = $query_etp->get_result();
                    $row_etp = $result_etp->fetch_assoc();
                    $fr_etp_tt = $row_etp['total_etp'];

                }

            } else {

                echo "Pas de données trouvées pour cet utilisateur.";

            }
            ?>
            <br /><button type="submit" class="confirmation-fiche" name="Envoyer" value="Envoyer le formulaire">validation selection</button>
           

            
        <h1>Frais au forfait :</h1>
        <table>
            <thead>
                <tr>
                    <th>Repas midi</th>
                    <th>Nuitée</th>
                    <th>Etape</th>
                    <th>Km</th>
                    <th style="width: 200px;">Situation</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><input type="text" name="repas_midi" value="<?php echo isset($fr_rep_tt) ? $fr_rep_tt : '0'; ?>" disabled></td>
                    <td><input type="text" name="nuitee" value="<?php echo isset($fr_km_tt) ? $fr_km_tt : '0'; ?>" disabled></td>
                    <td><input type="text" name="etape" value="<?php echo isset($fr_nui_tt) ? $fr_nui_tt : '0'; ?>" disabled></td>
                    <td><input type="text" name="km" value="<?php echo isset($fr_etp_tt) ? $fr_etp_tt : '0'; ?>" disabled></td>
                    <td>
                        <input type="radio" id="test1" name="situ" value="valide" />
                        <label for="test1">Valide</label>
                        <br />
                        <input type="radio" id="test2" name="situ" value="non_valide" checked/>
                        <label for="test2">Non valide</label>
                    </td>
                </tr>
            </tbody>
        </table>

        <br />

        <table>
            <thead>
                <tr>
                    <th class="fiche-confirmation">Nombre de Justificatifs</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><input type="text" class="justifications" name="justifications" placeholder="Ex : 3"></td>
                    </td>
                </tr>
            </tbody>
        </table>
        <?php
           
        if (isset($_POST['Envoyer']) && $_POST['situ'] === 'test1') {
           
            $vis_id = $_POST['nom'];
            $ffr_mois = $_POST['mois'];
            $ffr_annee = $_POST['annee'];
        
            // Exécution de  la requête SQL pour mettre à jour l'état de la fiche dans la base de données
            $query_update = $cnxBDD->prepare("UPDATE fiche_frais SET ETA_ID = 'CL' WHERE VIS_ID = ? AND FFR_MOIS = ? AND FFR_ANNEE = ?");
            $query_update->bind_param("sss", $vis_id, $ffr_mois, $ffr_annee);
            $query_update->execute();
            $query_update->close();
        }
       
        $query->close();
        
    }
        ?>

        <br /><button type="submit" class="confirmation-fiche" name="Envoyer" value="Envoyer le formulaire">soumettre la requete </button>
    </form>
</body>

</html>
