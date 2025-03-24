<?php
session_start();
include_once __DIR__ . '/../models/StockModel.php';

$stockModel = new StockModel($pdo);

// Ajouter un produit
if (isset($_POST['add_product'])) {
    $nom = $_POST['nom'];
    $categorie = $_POST['categorie'];
    $prix = $_POST['prix'];
    $quantite = $_POST['quantite'];

    if ($stockModel->addProduct($nom, $categorie, $prix, $quantite)) {
        header("Location: ../views/stocks.php?success=Produit ajouté !");
    } else {
        header("Location: ../views/stocks.php?error=Erreur lors de l'ajout.");
    }
    exit();
}

// Modifier un produit
if (isset($_POST['update_product'])) {
    $id = $_POST['id'];
    $nom = $_POST['nom'];
    $categorie = $_POST['categorie'];
    $prix = $_POST['prix'];
    $quantite = $_POST['quantite'];

    if ($stockModel->updateProduct($id, $nom, $categorie, $prix, $quantite)) {
        header("Location: ../views/stocks.php?success=Produit mis à jour !");
    } else {
        header("Location: ../views/stocks.php?error=Erreur lors de la modification.");
    }
    exit();
}

// Supprimer un produit
if (isset($_GET['delete_product'])) {
    $id = $_GET['delete_product'];

    if ($stockModel->deleteProduct($id)) {
        header("Location: ../views/stocks.php?success=Produit supprimé !");
    } else {
        header("Location: ../views/stocks.php?error=Erreur lors de la suppression.");
    }
    exit();
}
?>