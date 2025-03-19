<?php
session_start();
if (!isset($_SESSION["role"]) || $_SESSION["role"] !== "Responsable") {
    header("Location: ../views/login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Tableau de Bord - Responsable</title>
    <link rel="stylesheet" href="/CSI_APPLICATION/asserts/dashboard.css">
</head>
<body>

    <div class="header">
        <h1>Tableau de Bord - Responsable</h1>
    </div>

    <div class="dashboard-container">
        <p>Bienvenue, <?php echo htmlspecialchars($_SESSION["email"]); ?> !</p>
        <nav>
            <a href="stocks.php">Gestion des stocks</a>
            <a href="ventes.php">Ventes</a>
            <a href="woofers.php">Gestion des woofers</a>
            <a href="ateliers.php">Gestion des ateliers</a>
        </nav>
        <a href="/CSI_APPLICATION/public/logout.php" class="logout-btn">Déconnexion</a>

    </div>

    <script src="/CSI_APPLICATION/asserts/script.js"></script>

</body>
</html>
