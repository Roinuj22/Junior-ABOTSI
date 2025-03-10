<?php
session_start();
if (!isset($_SESSION["idUtilisateur"])) {
    header("Location: ../index.php");
    exit();
}

include("../config/db.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $idVendeur = $_SESSION["idUtilisateur"];
    $produits = $_POST["produits"];
    $quantites = explode(",", $_POST["quantites"]); // Convertir les quantités en tableau

    if (count($produits) != count($quantites)) {
        die("Erreur : Les produits et quantités ne correspondent pas.");
    }

    // Insérer la vente
    $query = $pdo->prepare("INSERT INTO Vente (idVendeur, total) VALUES (:idVendeur, 0)");
    $query->execute(["idVendeur" => $idVendeur]);
    $idVente = $pdo->lastInsertId();

    $total = 0;
    foreach ($produits as $index => $idProduit) {
        $quantite = intval($quantites[$index]);

        // Récupérer le prix du produit
        $query = $pdo->prepare("SELECT prix, stockDisponible FROM Produit WHERE idProduit = :id");
        $query->execute(["id" => $idProduit]);
        $produit = $query->fetch(PDO::FETCH_ASSOC);

        if (!$produit || $quantite <= 0 || $produit["stockDisponible"] < $quantite) {
            die("Erreur : Stock insuffisant ou produit invalide.");
        }

        $prixTotalProduit = $produit["prix"] * $quantite;
        $total += $prixTotalProduit;

        // Ajouter dans Vente_Produit
        $query = $pdo->prepare("INSERT INTO Vente_Produit (idVente, idProduit, quantiteVendue) VALUES (:idVente, :idProduit, :quantite)");
        $query->execute(["idVente" => $idVente, "idProduit" => $idProduit, "quantite" => $quantite]);

        // Mettre à jour le stock
        $query = $pdo->prepare("UPDATE Produit SET stockDisponible = stockDisponible - :quantite WHERE idProduit = :idProduit");
        $query->execute(["quantite" => $quantite, "idProduit" => $idProduit]);
    }

    // Mettre à jour le total de la vente
    $query = $pdo->prepare("UPDATE Vente SET total = :total WHERE idVente = :idVente");
    $query->execute(["total" => $total, "idVente" => $idVente]);

    header("Location: ../views/ventes.php");
    exit();
}
?>