<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - Ferme Écoresponsable</title>
    <link rel="stylesheet" href="../asserts/style.css">
</head>
<body>

    <div class="header">
        <h1>Bienvenue à la Ferme Écoresponsable</h1>
    </div>

    <div class="login-container">
        <div class="login-box">
            <h2>Connexion</h2>
            <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>
            <form action="../controllers/loginController.php" method="post">
                <div class="input-group">
                    <label for="email">Email :</label>
                    <input type="email" id="email" name="email" required>
                </div>
                <div class="input-group">
                    <label for="password">Mot de passe :</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <button type="submit">Se connecter</button>
            </form>
        </div>
    </div>
    <script src="../asserts/script.js"></script>

</body>
</html>