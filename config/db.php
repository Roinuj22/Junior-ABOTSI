<?php
$host = "localhost";
$dbname = "ferme_ecoresponsable";
$username = "root"; // Change si nécessaire
$password = ""; // Laisse vide si aucun mot de passe

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}
?>