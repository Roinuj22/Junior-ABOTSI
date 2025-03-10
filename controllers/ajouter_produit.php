<?php
session_start();
if (!isset($_SESSION["idUtilisateur"]) || $_SESSION["typeUtilisateur"] !== "Responsable") {
    header("Location: ../index.php");
    exit();
}

include("../config/db.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nomProduit = $_POST["nomProduit"];
    $categorieProduit = $_POST["categorieProduit"];
    $prix = $_POST["prix"];

    $query = $pdo->prepare("INSERT INTO Produit (nomProduit, categorieProduit, prix) VALUES (:nom, :categorie, :prix)");
    $query->execute([
        "nom" => $nomProduit,
        "categorie" => $categorieProduit,
        "prix" => $prix
    ]);

    header("Location: ../views/produits.php");
    exit();
}
?>