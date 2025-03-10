<?php
session_start();
if (!isset($_SESSION["idUtilisateur"])) {
    header("Location: ../index.php");
    exit();
}

include("../config/db.php");

// Récupérer toutes les ventes
$query = $pdo->query("
    SELECT Vente.idVente, Vente.dateVente, Utilisateur.nom, Utilisateur.prenom, Vente.total
    FROM Vente
    JOIN Utilisateur ON Vente.idVendeur = Utilisateur.idUtilisateur
    ORDER BY Vente.dateVente DESC
");
$ventes = $query->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion des Ventes</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>
    <h2>Gestion des Ventes</h2>
    <a href="../index.php">Retour au tableau de bord</a>

    <table>
        <tr>
            <th>ID Vente</th>
            <th>Date</th>
            <th>Vendeur</th>
            <th>Total (€)</th>
            <th>Actions</th>
        </tr>
        <?php foreach ($ventes as $vente) : ?>
            <tr>
                <td><?= $vente["idVente"] ?></td>
                <td><?= $vente["dateVente"] ?></td>
                <td><?= $vente["nom"] . " " . $vente["prenom"] ?></td>
                <td><?= number_format($vente["total"], 2) ?> €</td>
                <td>
                    <a href="ticket.php?id=<?= $vente['idVente'] ?>" target="_blank">Voir Ticket</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>

    <h3>Nouvelle Vente</h3>
    <form action="../controllers/ajouter_vente.php" method="POST">
        <label for="produits">Sélectionner les produits :</label><br>
        <select name="produits[]" multiple required>
            <?php
            $produitsQuery = $pdo->query("SELECT idProduit, nomProduit, prix FROM Produit");
            while ($produit = $produitsQuery->fetch(PDO::FETCH_ASSOC)) {
                echo "<option value='{$produit['idProduit']}'>{$produit['nomProduit']} - {$produit['prix']}€</option>";
            }
            ?>
        </select><br>

        <label for="quantites">Saisir les quantités :</label><br>
        <input type="text" name="quantites" placeholder="Ex: 2,1,3 (séparés par des virgules)" required><br>

        <button type="submit">Enregistrer Vente</button>
    </form>
</body>
</html>