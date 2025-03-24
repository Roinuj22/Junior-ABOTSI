<?php
include_once __DIR__ . '/../config/database.php';

class VenteModel {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function enregistrerVente($idVendeur, $total, $produits) {
        $this->pdo->beginTransaction();

        $stmt = $this->pdo->prepare("INSERT INTO Vente (idVendeur, total) VALUES (?, ?)");
        $stmt->execute([$idVendeur, $total]);
        $idVente = $this->pdo->lastInsertId();

        $stmtProduit = $this->pdo->prepare("INSERT INTO Vente_Produit (idVente, idProduit, quantiteVendue) VALUES (?, ?, ?)");

        foreach ($produits as $idProduit => $quantite) {
            if ($quantite > 0) {
                $stmtProduit->execute([$idVente, $idProduit, $quantite]);
            }
        }

        $this->pdo->commit();
        return $idVente;
    }

    public function getHistoriqueVentes() {
        $stmt = $this->pdo->query("
            SELECT v.idVente, v.dateVente, v.total, u.email 
            FROM Vente v
            JOIN Utilisateur u ON v.idVendeur = u.idUtilisateur
            ORDER BY v.dateVente DESC
        ");
        return $stmt->fetchAll();
    }

    public function getProduits() {
        return $this->pdo->query("SELECT idProduit, nomProduit, prix FROM Produit")->fetchAll();
    }
}