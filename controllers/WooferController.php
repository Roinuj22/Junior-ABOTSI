<?php
session_start();
include_once __DIR__ . '/../config/database.php';
include_once __DIR__ . '/../models/WooferModel.php';

$model = new WooferModel($pdo);

// Ajout
if (isset($_POST['ajouter_woofer'])) {
    $model->addWoofer($_POST['nom'], $_POST['prenom'], $_POST['email'], $_POST['telephone'], $_POST['password']);
    header("Location: ../views/woofers.php?success=Woofer ajouté");
    exit();
}

// Modification
if (isset($_POST['modifier_woofer'])) {
    $model->updateWoofer($_POST['id'], $_POST['nom'], $_POST['prenom'], $_POST['email'], $_POST['telephone'], $_POST['statut']);
    header("Location: ../views/woofers.php?success=Woofer modifié");
    exit();
}