<!DOCTYPE html>
<html>
<head>
	<title>Gestion des Frais</title>
	<link rel="stylesheet" href="index.css">
</head>
<body class="gestrionfraisforfait-body">
	<?php
    if ($_SERVER["REQUEST_METHOD"] == "GET") {
        $VIS_ID = $_GET["VIS_ID"];
    }
	?>

	<div class="gestionfraisforfait-Div">
		<h1 class="gestrionfraisforfait-h1"><a href="http://lab.sio-estran.fr:18102/KERFOURN/depot/fichedefrais.php?VIS_ID=<?= $VIS_ID ?>">Gestion des Frais </a><i class="fa-solid fa-hippo"></i></h1>
	</div>
	
	<form action="insert.php" method="get" class="gestrionfraisforfait-form">
		<input type="hidden" name="VIS_ID" value="<?php echo $VIS_ID; ?>">
		<fieldset>
		
			<legend>Saisie</legend>
			<label for="month" class="gestionfraisforfait-label">Mois (2 chiffres)</label>
			<input type="text" id="month" name="month" required class="gestionfraisforfait-input">
			<label for="year" class="gestionfraisforfait-label">Année (4 chiffres)</label>
			<input type="text" id="year" name="year" required class="gestionfraisforfait-input">
		</fieldset>
		<fieldset>
		
			<legend>Frais au forfait</legend>
			<table class="gestionfraisforfait-table">
				<tr>
					<th class="gestionfraisforfait-th">Repas midi :</th>
					<td class="gestionfraisforfait-td"><input type="number" id="repas" name="repas" required class="gestionfraisforfait-input"></td>
					
				</tr>
				<tr>
					<th class="gestionfraisforfait-th">Nuitées :</th>
					<td class="gestionfraisforfait-td"><input type="number" id="nuitees" name="nuitees" required class="gestionfraisforfait-input"></td>
				</tr>
				<tr>
					<th class="gestionfraisforfait-th">Étape :</th>
					<td class="gestionfraisforfait-td"><input type="number" id="etape" name="etape" required class="gestionfraisforfait-input"></td>
				</tr>
				<tr>
					<th class="gestionfraisforfait-th">Km :</th>
					<td class="gestionfraisforfait-td"><input type="number" id="km" name="km" required class="gestionfraisforfait-input"></td>
				</tr>
			</table>
		</fieldset>
		<input type="submit" value="Soumettre la requête" class="gestionfraisforfait-input">
	</form>
</body>
</html>
