<?php
session_start();
if (!isset($_SESSION["idUtilisateur"]) || $_SESSION["typeUtilisateur"] !== "Responsable") {
    header("Location: ../index.php");
    exit();
}

include("../config/db.php");

if (isset($_GET["id"])) {
    $idProduit = $_GET["id"];

    // Vérifier si le produit a été vendu
    $verifQuery = $pdo->prepare("SELECT COUNT(*) FROM Vente_Produit WHERE idProduit = :id");
    $verifQuery->execute(["id" => $idProduit]);
    $dejaVendu = $verifQuery->fetchColumn();

    if ($dejaVendu == 0) {
        $query = $pdo->prepare("DELETE FROM Produit WHERE idProduit = :id");
        $query->execute(["id" => $idProduit]);
    } else {
        echo "Impossible de supprimer un produit déjà vendu.";
        exit();
    }

    header("Location: ../views/produits.php");
    exit();
}
?>