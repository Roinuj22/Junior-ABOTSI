<?php
include_once __DIR__ . '/../config/database.php';

class WooferModel {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function getAllWoofers() {
        $stmt = $this->pdo->prepare("SELECT * FROM Utilisateur WHERE typeUtilisateur = 'Woofer'");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function addWoofer($nom, $prenom, $email, $telephone, $password) {
        $hashed = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $this->pdo->prepare("
            INSERT INTO Utilisateur (nom, prenom, email, telephone, password, typeUtilisateur, statut)
            VALUES (?, ?, ?, ?, ?, 'Woofer', 'Actif')
        ");
        return $stmt->execute([$nom, $prenom, $email, $telephone, $hashed]);
    }

    public function updateWoofer($id, $nom, $prenom, $email, $telephone, $statut) {
        $stmt = $this->pdo->prepare("
            UPDATE Utilisateur 
            SET nom = ?, prenom = ?, email = ?, telephone = ?, statut = ?
            WHERE idUtilisateur = ?
        ");
        return $stmt->execute([$nom, $prenom, $email, $telephone, $statut, $id]);
    }
}