<?php
session_start();
include_once __DIR__ . '/../models/StockModel.php';

$stockModel = new StockModel($pdo);
$products = $stockModel->getAllProducts();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion des Stocks</title>
    <link rel="stylesheet" href="/CSI_APPLICATION/asserts/stocks.css">

</head>
<body>
    <div class="header">
        <h1>Gestion des Stocks</h1>

        <a href="<?= ($_SESSION['role'] === 'Responsable') ? '/CSI_APPLICATION/public/responsable_dashboard.php' : '/CSI_APPLICATION/public/woofer_dashboard.php'; ?>" class="back-link">

                🔙 Retour au Tableau de Bord
        </a>



    </div>

    <div class="container">
        <?php if (isset($_GET['success'])) echo "<p class='success'>" . $_GET['success'] . "</p>"; ?>
        <?php if (isset($_GET['error'])) echo "<p class='error'>" . $_GET['error'] . "</p>"; ?>

        <h2>Ajouter un produit</h2>
        <form action="../controllers/StockController.php" method="post">
            <input type="text" name="nom" placeholder="Nom du produit" required>
            <input type="text" name="categorie" placeholder="Catégorie" required>
            <input type="number" name="prix" placeholder="Prix" required>
            <input type="number" name="quantite" placeholder="Quantité" required>
            <button type="submit" name="add_product">Ajouter</button>
        </form>

        <h2>Liste des Produits</h2>
        <table>
            <tr>
                <th>Nom</th>
                <th>Catégorie</th>
                <th>Prix</th>
                <th>Quantité</th>
                <th>Actions</th>
            </tr>
            <?php foreach ($products as $product) : ?>
            <tr>
                <td><?= htmlspecialchars($product['nomProduit']) ?></td>
                <td><?= htmlspecialchars($product['categorieProduit']) ?></td>

                <td><?= htmlspecialchars($product['prix']) ?> €</td>
                <td><?= isset($product['quantite']) ? htmlspecialchars($product['quantite']) : '0' ?></td>

                <td>
                    <a href="modifier_produit.php?id=<?= htmlspecialchars($product['idProduit']) ?>">Modifier</a> |
                    <a href="../controllers/StockController.php?delete_product=<?= htmlspecialchars($product['idProduit']) ?>" 
                    onclick="return confirm('Supprimer ce produit ?')">Supprimer</a>
                </td>

            </tr>
            <?php endforeach; ?>
        </table>
    </div>
</body>
</html>