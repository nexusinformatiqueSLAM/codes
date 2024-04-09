<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Validation des frais par visiteur</title>
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
<body>

<?php
$servername = "localhost";
$username = "root";
$password = "Iroise29"; // En production, il est préférable de gérer les identifiants de manière sécurisée
$database = "nexusinformatique";

// Création de la connexion
$cnxBDD = new mysqli($servername, $username, $password, $database, 3306);

// Vérification de la connexion
if ($cnxBDD->connect_error) {
    die("Échec de la connexion : " . $cnxBDD->connect_error);
}

// Initialisation des variables
$REP = '0';
$NUI = '0';
$ETP = '0';
$KM = '0';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $visiteurID = $_POST['choix'];
    $mois = $_POST['mois'];

    // Assurez-vous que les noms de colonne dans votre requête correspondent à ceux de votre base de données
    $sql = "SELECT REP, NUI, ETP, KM FROM frais WHERE VIS_ID = ? AND mois = ?";
    $stmt = $cnxBDD->prepare($sql);
    $stmt->bind_param("ss", $visiteurID, $mois);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $REP = $row['REP'];
        $NUI = $row['NUI'];
        $ETP = $row['ETP'];
        $KM = $row['KM'];
    } else {
        echo "<p>Aucune donnée trouvée pour cet utilisateur et ce mois.</p>";
    }
    $stmt->close();
}

// Récupérer la liste des utilisateurs pour le formulaire
$sql = "SELECT VIS_ID, VIS_NOM, VIS_PRENOM FROM visiteur";
$result = $cnxBDD->query($sql);
?>

<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
    <label for="choix">Sélectionnez votre Nom :</label>
    <select name="choix" id="choix">
        <?php
        while ($row = $result->fetch_assoc()) {
            echo "<option value=\"" . $row['VIS_ID'] . "\">" . $row['VIS_NOM'] . " " . $row['VIS_PRENOM'] . "</option>";
        }
        ?>
    </select>
    <br>
    <label for="mois">Choisissez le mois :</label>
    <select name="mois" id="mois">
        <!-- Boucle pour les mois -->
        <?php for ($i = 1; $i <= 12; $i++) {
            $val = sprintf("%02d", $i);
            $monthName = date("F", mktime(0, 0, 0, $i, 10)); // Convertir le numéro du mois en nom
            echo "<option value=\"$val\">$monthName</option>";
        } ?>
    </select>
    <br>
    <input type="submit" value="Valider">
</form>

<BR><H1>Frais au forfait</H1><BR>

<table>
    <tr>
        <th>Repas midi</th>
        <th>Nuitée</th>
        <th>Etape</th>
        <th>Km</th>
        <th>Situation</th>
    </tr>
    <tr>
        <td><?php echo htmlspecialchars($REP); ?></td>
        <td><?php echo htmlspecialchars($NUI); ?></td>
        <td><?php echo htmlspecialchars($ETP); ?></td>
        <td><?php echo htmlspecialchars($KM); ?></td>
        <td>
          <!-- Cette partie nécessite un formulaire supplémentaire ou une gestion via JavaScript pour traiter la "Situation" -->
          Situation valide<input type="checkbox" name="situation[]" value="valide" disabled>
          Situation non valide<input type="checkbox" name="situation[]" value="non-valide" disabled>
        </td>
    </tr>
</table>

<?php
$cnxBDD->close(); 
?>
</body>
</html>
