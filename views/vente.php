<?php
session_start();
if (!isset($_SESSION["role"])) {
    header("Location: login.php");
    exit();
}

include_once __DIR__ . '/../models/VenteModel.php';

$venteModel = new VenteModel($pdo);
$produits = $venteModel->getProduits();
$ventes = $venteModel->getHistoriqueVentes();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion des Ventes</title>
    <link rel="stylesheet" href="/CSI_APPLICATION/asserts/stocks.css">
</head>
<body>
    <div class="header">
        <h1>Gestion des Ventes</h1>
        <a href="<?= ($_SESSION['role'] === 'Responsable') ? '/CSI_APPLICATION/public/responsable_dashboard.php' : '/CSI_APPLICATION/public/woofer_dashboard.php'; ?>" class="back-link">🔙 Retour au Tableau de Bord</a>
    </div>

    <div class="container">
        <?php if (isset($_GET['success'])) echo "<p class='success'>" . $_GET['success'] . "</p>"; ?>
        <?php if (isset($_GET['error'])) echo "<p class='error'>" . $_GET['error'] . "</p>"; ?>

        <h2>Nouvelle vente</h2>
        <form method="post" action="/CSI_APPLICATION/controllers/VenteController.php">

            <?php foreach ($produits as $produit): ?>
                <div>
                    <label><?= $produit['nomProduit'] ?> (<?= $produit['prix'] ?> €)</label>
                    <input type="number" name="produits[<?= $produit['idProduit'] ?>]" min="0" value="0">
                </div>
            <?php endforeach; ?>
            <button type="submit" name="valider_vente">Valider la vente</button>
        </form>

        <h2>Historique des ventes</h2>
        <table>
            <tr>
                <th>#</th>
                <th>Date</th>
                <th>Vendeur</th>
                <th>Total (€)</th>
            </tr>
            <?php foreach ($ventes as $vente): ?>
            <tr>
                <td><?= $vente['idVente'] ?></td>
                <td><?= $vente['dateVente'] ?></td>
                <td><?= $vente['email'] ?></td>
                <td><?= $vente['total'] ?></td>
            </tr>
            <?php endforeach; ?>
        </table>
    </div>
</body>
</html>