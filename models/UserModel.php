<?php
include_once __DIR__ . '/../config/database.php';

class UserModel {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // Vérifie les identifiants de l'utilisateur par email
    public function getUserByEmail($email) {
        $stmt = $this->pdo->prepare("SELECT idUtilisateur, email, password, typeUtilisateur FROM utilisateur WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    // Inscription d'un nouvel utilisateur avec mot de passe haché
    public function registerUser($nom, $prenom, $email, $telephone, $typeUtilisateur, $password) {
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        $stmt = $this->pdo->prepare("INSERT INTO utilisateur (nom, prenom, email, telephone, typeUtilisateur, password) VALUES (?, ?, ?, ?, ?, ?)");
        return $stmt->execute([$nom, $prenom, $email, $telephone, $typeUtilisateur, $hashedPassword]);
    }
}
?>