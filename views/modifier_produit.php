<?php


session_start();

if (empty($_SESSION["role"]) || $_SESSION["role"] !== "Responsable") {
    
    die('<style>
    .error-message {
        color: red;
        font-size: 20px;
        font-weight: bold;
        text-align: center;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        background: #ffe6e6;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 4px 15px rgba(255, 0, 0, 0.2);
    }
    .back-link {
        display: block;
        text-align: center;
        margin-top: 20px;
        font-size: 16px;
        color: #0056b3;
        text-decoration: none;
        font-weight: bold;
    }
</style>
<p class="error-message">⛔ Accès refusé : Vous n\'êtes pas autorisé à modifier un produit.</p>
<a href="stocks.php" class="back-link">🔙 Retour à la gestion des stocks</a>');


}

include_once __DIR__ . '/../models/StockModel.php';

$stockModel = new StockModel($pdo);
$product = null;

// Vérifier si un ID de produit est passé
if (isset($_GET['id'])) {
    $idProduit = $_GET['id'];
    $products = $stockModel->getAllProducts();
    
    foreach ($products as $p) {
        if ($p['idProduit'] == $idProduit) {
            $product = $p;
            break;
        }
    }
}

// Si produit introuvable, retour à stocks.php
if (!$product) {
    die("<p class='error'>Erreur : Produit introuvable.</p>");
}

// Mise à jour du produit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = trim($_POST["nom"]);
    $categorie = trim($_POST["categorie"]);
    $prix = trim($_POST["prix"]);
    $quantite = trim($_POST["quantite"]);

    if ($stockModel->updateProduct($idProduit, $nom, $categorie, $prix, $quantite)) {
        header("Location: stocks.php?success=Produit modifié avec succès");
        exit();
    } else {
        $error = "Erreur lors de la modification.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier Produit</title>
    <link rel="stylesheet" href="/CSI_APPLICATION/asserts/stocks.css">
</head>
<body>
    <div class="header">
        <h1>Modifier Produit</h1>
    </div>

    <div class="container">
        <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>

        <form method="post">
            <input type="text" name="nom" value="<?= htmlspecialchars($product['nomProduit']) ?>" required>
            <input type="text" name="categorie" value="<?= htmlspecialchars($product['categorieProduit']) ?>" required>
            <input type="number" step="0.01" name="prix" value="<?= htmlspecialchars($product['prix']) ?>" required>
            <input type="number" name="quantite" value="<?= htmlspecialchars($product['quantite']) ?>" required>
            <button type="submit">Mettre à jour</button>
        </form>
    </div>
</body>
</html>
