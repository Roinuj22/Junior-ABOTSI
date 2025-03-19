<?php
// Empêcher l'inclusion multiple du fichier
if (defined('DB_CONFIG_INCLUDED')) {
    return;
}
define('DB_CONFIG_INCLUDED', true);

// Paramètres de connexion à la base de données
$host = 'localhost';
$dbname = 'ferme_ecoresponsable';
$username = 'root';
$password = '';

// Vérifier si une connexion existe déjà pour éviter de la recréer
global $pdo;
if (!isset($pdo)) {
    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false
        ]);
    } catch (PDOException $e) {
        die("Erreur de connexion à la base de données : " . $e->getMessage());
    }
}
?>
