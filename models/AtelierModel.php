<?php
include_once __DIR__ . '/../config/database.php';

class AtelierModel {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function getAllAteliers($role, $userId) {
        $stmt = $this->pdo->query("SELECT * FROM Atelier");
        return $stmt->fetchAll();
    }

    public function addAtelier($nom, $date, $type, $prix, $idResp) {
        $stmt = $this->pdo->prepare("INSERT INTO Atelier (nomAtelier, dateAtelier, typeProduit, prixAtelier, idResponsableAtelier)
            VALUES (?, ?, ?, ?, ?)");
        return $stmt->execute([$nom, $date, $type, $prix, $idResp]);
    }

    public function deleteAtelier($id) {
        $stmt = $this->pdo->prepare("DELETE FROM Atelier WHERE idAtelier = ?");
        return $stmt->execute([$id]);
    }

    public function getParticipants($idAtelier) {
        $stmt = $this->pdo->prepare("
            SELECT u.nom, u.prenom, ai.dateInscription
            FROM Atelier_Inscription ai
            JOIN Utilisateur u ON ai.idParticipant = u.idUtilisateur
            WHERE ai.idAtelier = ?
        ");
        $stmt->execute([$idAtelier]);
        return $stmt->fetchAll();
    }

    public function inscrireParticipant($idAtelier, $idParticipant) {
        $stmt = $this->pdo->prepare("
            INSERT IGNORE INTO Atelier_Inscription (idAtelier, idParticipant) 
            VALUES (?, ?)
        ");
        return $stmt->execute([$idAtelier, $idParticipant]);
    }

    public function getAllUtilisateurs() {
        return $this->pdo->query("SELECT idUtilisateur, nom, prenom FROM Utilisateur WHERE typeUtilisateur = 'Woofer'")->fetchAll();
    }

    public function inscrireNouveauParticipant($idAtelier, $nom, $prenom, $telephone) {
        // Générer un email temporaire unique
        $email = uniqid('participant') . '@local';
    
        $stmt = $this->pdo->prepare("
            INSERT INTO Utilisateur (nom, prenom, telephone, typeUtilisateur, email, password)
            VALUES (?, ?, ?, 'Woofer', ?, '')
        ");
        $stmt->execute([$nom, $prenom, $telephone, $email]);
        $idParticipant = $this->pdo->lastInsertId();
    
        $stmt2 = $this->pdo->prepare("
            INSERT INTO Atelier_Inscription (idAtelier, idParticipant)
            VALUES (?, ?)
        ");
        return $stmt2->execute([$idAtelier, $idParticipant]);
    }
}