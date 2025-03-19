<?php
session_start();
if (!isset($_SESSION["user_id"])) {
    header("Location: ../views/login.php");
    exit();
}

// Redirection selon le rôle
if ($_SESSION["role"] == "Responsable") {
    header("Location: responsable_dashboard.php");
} else {
    header("Location: woofer_dashboard.php");
}
exit();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de Bord</title>
    <link rel="stylesheet" href="../asserts/style.css">
</head>
<body>
    <div class="header">
        <h1>Bienvenue, <?php echo htmlspecialchars($_SESSION["email"]); ?> !</h1>
    </div>

    <div class="dashboard-container">
        <p>Vous êtes connecté avec succès !</p>
        <a href="../logout.php" class="logout-btn">Déconnexion</a>
    </div>

    <script src="../asserts/script.js"></script>
</body>
</html>