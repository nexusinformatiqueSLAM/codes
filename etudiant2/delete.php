<?php
$servername = "localhost";
$username = "root";
$password = "Iroise29";
$database = "nexusinformatique";

$cnxBDD = new mysqli($servername, $username, $password, $database, 3306);

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $FFR_ID = $_GET["FFR_ID"];

    $sql = "DELETE FROM ligne_frais_forfait WHERE FFR_ID='$FFR_ID'";
    echo "$sql";
    $result = $cnxBDD->query($sql);

    echo "$sql";
    header("location: http://lab.sio-estran.fr:18102/KERFOURN/depot/fichedefrais.php?VIS_ID=$VIS_ID");
    exit();
}
?>
