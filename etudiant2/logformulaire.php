
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="index.css">
    <title>Login Page</title>
</head>
<body class="login-body">
<div class="login-container">
    <h2>Login</h2>
    <form method="get" action="logvisiteur.php">
        <label for="nom">Nom :</label>
        <input class="login-input" type="text" id="nom" name="nom" required>

        <label for="prenom" >Prenom:</label>
        <input class="login-input" type="text" id="prenom" name="prenom" required>

        <button type="submit" class="login-button">Login</button>
    </form>
</div>

</body>
</html>


