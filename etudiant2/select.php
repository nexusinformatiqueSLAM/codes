<?php
$host="localhost";
$user="root";
$password="Iroise29";
$dbname="Jaffres";
$port=3306;

$cnxBDD = new mysqli($host, $user, $password, $dbname, $port);


$sql = "SELECT id, nom, prenom FROM ETUDIANT;";
$lignes = $cnxBDD->query($sql) or die (afficheErreur($sql, $cnxBDD->error_list[0]['error']));

foreach ($lignes as $maligne){

$numContact=$maligne['id'];
$nom=$maligne['nom'];
$prenom=$maligne['prenom'];

echo $nom." ".$prenom;
}


$cnxBDD->close();
?>