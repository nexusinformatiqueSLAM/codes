<?php

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $nom = $_GET["nom"];
    $prenom = $_GET["prenom"];

}

$cnxBDD = new mysqli("localhost", "root", "Iroise29", "nexusinformatique", 3306);


$sql = "SELECT VIS_ID, VIS_NOM, VIS_PRENOM, VIS_ADRESSE, VIS_CP, VIS_VILLE, VIS_DATE_EMBAUCHE FROM visiteur WHERE VIS_NOM='$nom' AND VIS_PRENOM='$prenom'";
$result = $cnxBDD->query($sql);



foreach ($result as $ligne) {
    $VIS_ID = $ligne['VIS_ID'];

}

if ($VIS_ID==NULL){
    header("location: http://lab.sio-estran.fr:18102/KERFOURN/depot/logformulaire.php");
}else{
    header("location: http://lab.sio-estran.fr:18102/KERFOURN/depot/fichedefrais.php?VIS_ID=$VIS_ID");
}


exit();
?>