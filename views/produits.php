<?php
session_start();
if (!isset($_SESSION["idUtilisateur"]) || $_SESSION["typeUtilisateur"] !== "Responsable") {
    header("Location: ../index.php");
    exit();
}

include("../config/db.php");

// Récupérer tous les produits
$query = $pdo->query("SELECT * FROM Produit");
$produits = $query->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion des Produits</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>
    <h2>Gestion des Produits</h2>
    <a href="../index.php">Retour au tableau de bord</a>

    <table borde="1">
        <tr>
            <th>Nom</th>
            <th>Catégorie</th>
            <th>Prix</th>
            <th>Actions</th>
        </tr>
        <?php foreach ($produits as $produit) : ?>
            <tr>
                <td><?= htmlspecialchars($produit["nomProduit"]) ?></td>
                <td><?= htmlspecialchars($produit["categorieProduit"]) ?></td>
                <td><?= number_format($produit["prix"], 2) ?> €</td>
                <td>
                    <a href="modifier_produit.php?id=<?= $produit['idProduit'] ?>">Modifier</a>
                    <a href="../controllers/supprimer_produit.php?id=<?= $produit['idProduit'] ?>" onclick="return confirm('Êtes-vous sûr ?');">Supprimer</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>

    <h3>Ajouter un Produit</h3>
    <form action="../controllers/ajouter_produit.php" method="POST">
        <input type="text" name="nomProduit" placeholder="Nom du produit" required><br>
        <select name="categorieProduit">
            <option value="Périssable">Périssable</option>
            <option value="Non Périssable">Non Périssable</option>
        </select><br>
        <input type="number" step="0.01" name="prix" placeholder="Prix en €" required><br>
        <button type="submit">Ajouter</button>
    </form>
</body>
</html>