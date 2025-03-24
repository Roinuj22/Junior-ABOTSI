<?php
session_start();
if (!isset($_SESSION["role"]) || $_SESSION["role"] !== "Woofer") {
    header("Location: ../views/login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Tableau de Bord - Woofer</title>
    <link rel="stylesheet" href="/CSI_APPLICATION/asserts/dashboard.css">
</head>
<body>

    <div class="header">
        <h1>Tableau de Bord - Woofer</h1>
    </div>

    <div class="dashboard-container">
        <p>Bienvenue, <?php echo htmlspecialchars($_SESSION["email"]); ?> !</p>
        <nav>
            <a href="/CSI_APPLICATION/views/vente.php">Effectuer une vente</a>
            <a href="/CSI_APPLICATION/views/stocks.php">Entrées/Sorties de produits</a>
            <a href="/CSI_APPLICATION/views/atelier.php">Inscription aux ateliers</a>
        </nav>
        <a href="/CSI_APPLICATION/public/logout.php" class="logout-btn">Déconnexion</a>
    </div>

    <script src="/CSI_APPLICATION/asserts/script.js"></script>

</body>
</html>