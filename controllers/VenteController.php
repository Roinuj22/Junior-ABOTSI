<?php
session_start();
include_once __DIR__ . '/../config/database.php'; 
include_once __DIR__ . '/../models/VenteModel.php';

$venteModel = new VenteModel($pdo);

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['valider_vente'])) {
    $produits = $_POST['produits'] ?? [];
    $total = 0;

    foreach ($produits as $id => $qte) {
        $stmt = $pdo->prepare("SELECT prix FROM Produit WHERE idProduit = ?");
        $stmt->execute([$id]);
        $prix = $stmt->fetchColumn();
        $total += $prix * $qte;
    }

    $idVendeur = $_SESSION['user_id'] ?? null;

   


    if ($idVendeur && $total > 0) {
        $venteModel->enregistrerVente($idVendeur, $total, $produits);
        header("Location: ../views/vente.php?success=Vente enregistrée avec succès");
        exit();
    } else {
        header("Location: ../views/vente.php?error=Erreur lors de l'enregistrement");
        exit();
    }
}