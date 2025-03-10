<?php
session_start();
if (!isset($_SESSION["idUtilisateur"])) {
    header("Location: views/login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Tableau de Bord</title>
    <link rel="stylesheet" href="assets/style.css">

</head>
<body>
    <h1>Bienvenue, <?php echo $_SESSION["typeUtilisateur"]; ?> !</h1>
    <nav>
        <ul>
            <li><a href="views/produits.php">Gérer les Produits</a></li>
            <li><a href="views/ventes.php">Effectuer une Vente</a></li>
            <li><a href="views/ateliers.php">Gérer les Ateliers</a></li>
            <li><a href="logout.php">Se déconnecter</a></li>
        </ul>
    </nav>
</body>
</html>