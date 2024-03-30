<!DOCTYPE html>
<html>
<head>
	<title>Gestion des Frais</title>
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
		input[type="text"], input[type="number"] {
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
        $VIS_ID = $_GET["VIS_ID"];
    }
	?>

	<div class="maDiv">
		<h1><a href="http://lab.sio-estran.fr:18102/KERFOURN/depot/fichedefrais.php?VIS_ID=<?= $VIS_ID ?>">Gestion des Frais </a><i class="fa-solid fa-hippo"></i></h1>
	</div>
	
	<form action="insert.php" method="get">
		<input type="hidden" name="VIS_ID" value="<?php echo $VIS_ID; ?>">
		<fieldset>
		
			<legend>Saisie</legend>
			<label for="month">Mois (2 chiffres)</label>
			<input type="text" id="month" name="month" required>
			<label for="year">Année (4 chiffres)</label>
			<input type="text" id="year" name="year" required>
		</fieldset>
		<fieldset>
		
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
					<th>Étape :</th>
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
