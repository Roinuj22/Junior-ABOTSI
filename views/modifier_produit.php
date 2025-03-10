<?php
session_start();
if (!isset($_SESSION["idUtilisateur"]) || $_SESSION["typeUtilisateur"] !== "Responsable") {
    header("Location: ../index.php");
    exit();
}

include("../config/db.php");

if (isset($_GET["id"])) {
    $idProduit = $_GET["id"];
    $query = $pdo->prepare("SELECT * FROM Produit WHERE idProduit = :id");
    $query->execute(["id" => $idProduit]);
    $produit = $query->fetch(PDO::FETCH_ASSOC);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nomProduit = $_POST["nomProduit"];
    $categorieProduit = $_POST["categorieProduit"];
    $prix = $_POST["prix"];

    $query = $pdo->prepare("UPDATE Produit SET nomProduit = :nom, categorieProduit = :categorie, prix = :prix WHERE idProduit = :id");
    $query->execute([
        "nom" => $nomProduit,
        "categorie" => $categorieProduit,
        "prix" => $prix,
        "id" => $idProduit
    ]);

    header("Location: produits.php");
    exit();
}
?>