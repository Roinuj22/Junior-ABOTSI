<?php
include_once __DIR__ . '/../config/database.php';

class StockModel {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // Ajouter un produit
    public function addProduct($nom, $categorie, $prix, $quantite) {
        $stmt = $this->pdo->prepare("INSERT INTO Produit (nomProduit, categorieProduit, prix) VALUES (?, ?, ?)");
        $stmt->execute([$nom, $categorie, $prix]);

        // Récupérer l'ID du produit inséré
        $idProduit = $this->pdo->lastInsertId();

        // Ajouter la quantité dans le stock
        $stmt = $this->pdo->prepare("INSERT INTO Stock (idProduit, quantite, dateMAJStock) VALUES (?, ?, NOW())");
        return $stmt->execute([$idProduit, $quantite]);
    }

    // Modifier un produit
    public function updateProduct($id, $nom, $categorie, $prix, $quantite) {
        $stmt = $this->pdo->prepare("UPDATE Produit SET nomProduit = ?, categorieProduit = ?, prix = ? WHERE idProduit = ?");
        $stmt->execute([$nom, $categorie, $prix, $id]);

        // Mettre à jour la quantité en stock
        $stmt = $this->pdo->prepare("UPDATE Stock SET quantite = ?, dateMAJStock = NOW() WHERE idProduit = ?");
        return $stmt->execute([$quantite, $id]);
    }

    // Supprimer un produit
    public function deleteProduct($id) {
        // Supprimer d'abord le stock associé
        $stmt = $this->pdo->prepare("DELETE FROM Stock WHERE idProduit = ?");
        $stmt->execute([$id]);

        // Ensuite, supprimer le produit
        $stmt = $this->pdo->prepare("DELETE FROM Produit WHERE idProduit = ?");
        return $stmt->execute([$id]);
    }

    // Récupérer tous les produits
    public function getAllProducts() {
        $stmt = $this->pdo->query("
            SELECT Produit.idProduit, Produit.nomProduit, Produit.categorieProduit, Produit.prix, 
                   IFNULL(Stock.quantite, 0) AS quantite
            FROM Produit
            LEFT JOIN Stock ON Produit.idProduit = Stock.idProduit
            ORDER BY Produit.nomProduit ASC
        ");
        return $stmt->fetchAll();
    }
}
?>
