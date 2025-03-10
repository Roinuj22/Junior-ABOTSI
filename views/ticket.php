<?php
include("../config/db.php");

if (!isset($_GET["id"])) {
    die("ID vente manquant.");
}

$idVente = $_GET["id"];
$query = $pdo->prepare("
    SELECT Vente.idVente, Vente.dateVente, Utilisateur.nom, Utilisateur.prenom, Vente.total
    FROM Vente
    JOIN Utilisateur ON Vente.idVendeur = Utilisateur.idUtilisateur
    WHERE Vente.idVente = :id
");
$query->execute(["id" => $idVente]);
$vente = $query->fetch(PDO::FETCH_ASSOC);

$query = $pdo->prepare("
    SELECT Produit.nomProduit, Vente_Produit.quantiteVendue, Produit.prix
    FROM Vente_Produit
    JOIN Produit ON Vente_Produit.idProduit = Produit.idProduit
    WHERE Vente_Produit.idVente = :id
");
$query->execute(["id" => $idVente]);
$produits = $query->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ticket de Vente</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>
    <h2>Ticket de Vente #<?= $vente["idVente"] ?></h2>
    <p>Date : <?= $vente["dateVente"] ?></p>
    <p>Vendeur : <?= $vente["nom"] . " " . $vente["prenom"] ?></p>

    <table borde="1">
        <tr><th>Produit</th><th>Quantité</th><th>Prix Unitaire</th></tr>
        <?php foreach ($produits as $produit) : ?>
            <tr>
                <td><?= $produit["nomProduit"] ?></td>
                <td><?= $produit["quantiteVendue"] ?></td>
                <td><?= number_format($produit["prix"], 2) ?> €</td>
            </tr>
        <?php endforeach; ?>
    </table>
    <h3>Total : <?= number_format($vente["total"], 2) ?> €</h3>
</body>
</html>