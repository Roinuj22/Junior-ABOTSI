<?php
session_start();
include_once __DIR__ . '/../config/database.php';
include_once __DIR__ . '/../models/AtelierModel.php';

$model = new AtelierModel($pdo);

// Ajouter un atelier
if (isset($_POST['ajouter_atelier'])) {
    $model->addAtelier(
        $_POST['nom'],
        $_POST['date'],
        $_POST['type'],
        $_POST['prix'],
        $_SESSION['user_id']
    );
    header("Location: ../views/atelier.php?success=Atelier ajouté");
    exit();
}

// Supprimer un atelier
if (isset($_GET['supprimer'])) {
    $model->deleteAtelier($_GET['supprimer']);
    header("Location: ../views/atelier.php?success=Atelier supprimé");
    exit();
}

// Inscrire un participant
if (isset($_POST['inscrire'])) {
    $model->inscrireParticipant($_POST['idAtelier'], $_POST['idParticipant']);
    header("Location: ../views/atelier.php?success=Participant inscrit");
    exit();
}
if (isset($_POST['inscrire_nouveau'])) {
    $model->inscrireNouveauParticipant(
        $_POST['idAtelier'],
        $_POST['nom'],
        $_POST['prenom'],
        $_POST['telephone']
    );
    header("Location: ../views/atelier.php?success=Participant ajouté et inscrit");
    exit();
}
if (isset($_POST['modifier_atelier'])) {
    $stmt = $pdo->prepare("UPDATE Atelier SET nomAtelier = ?, dateAtelier = ?, typeProduit = ?, prixAtelier = ? WHERE idAtelier = ?");
    $stmt->execute([
        $_POST['nom'],
        $_POST['date'],
        $_POST['type'],
        $_POST['prix'],
        $_POST['idAtelier']
    ]);
    header("Location: ../views/atelier.php?success=Atelier modifié");
    exit();
}
