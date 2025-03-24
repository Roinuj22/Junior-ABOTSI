<?php
session_start();
if (!isset($_SESSION["role"])) {
    header("Location: login.php");
    exit();
}

include_once __DIR__ . '/../models/AtelierModel.php';
$model = new AtelierModel($pdo);

$ateliers = $model->getAllAteliers($_SESSION["role"], $_SESSION["user_id"]);
$woofers = $model->getAllUtilisateurs();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion des Ateliers</title>
    <link rel="stylesheet" href="/CSI_APPLICATION/asserts/stocks.css">
</head>
<body>
    <div class="header">
        <h1>Gestion des Ateliers</h1>
        <a href="<?= ($_SESSION['role'] === 'Responsable') ? '/CSI_APPLICATION/public/responsable_dashboard.php' : '/CSI_APPLICATION/public/woofer_dashboard.php'; ?>" class="back-link">🔙 Retour</a>
    </div>

    <div class="container">
        <?php if (isset($_GET['success'])) echo "<p class='success'>" . $_GET['success'] . "</p>"; ?>

        <?php if ($_SESSION["role"] === 'Responsable'): ?>
        <h2>Ajouter un atelier</h2>
        <form method="post" action="/CSI_APPLICATION/controllers/AtelierController.php">
            <input type="text" name="nom" placeholder="Nom atelier" required>
            <input type="date" name="date" required>
            <input type="text" name="type" placeholder="Type produit" required>
            <input type="number" name="prix" placeholder="Prix (€)" step="0.01" required>
            <button type="submit" name="ajouter_atelier">Ajouter</button>
        </form>
        <?php endif; ?>

        <h2>Liste des Ateliers</h2>
        <table>
            <tr>
                <th>Nom</th><th>Date</th><th>Type</th><th>Prix</th><th>Actions</th>
            </tr>
            <?php foreach ($ateliers as $atelier): ?>
            <tr>
                <form method="post" action="/CSI_APPLICATION/controllers/AtelierController.php">
                    <input type="hidden" name="idAtelier" value="<?= $atelier['idAtelier'] ?>">
                    <td><input type="text" name="nom" value="<?= $atelier['nomAtelier'] ?>" <?= ($_SESSION['role'] !== 'Responsable') ? 'readonly' : '' ?>></td>
                    <td><input type="date" name="date" value="<?= $atelier['dateAtelier'] ?>" <?= ($_SESSION['role'] !== 'Responsable') ? 'readonly' : '' ?>></td>
                    <td><input type="text" name="type" value="<?= $atelier['typeProduit'] ?>" <?= ($_SESSION['role'] !== 'Responsable') ? 'readonly' : '' ?>></td>
                    <td><input type="number" name="prix" value="<?= $atelier['prixAtelier'] ?>" step="0.01" <?= ($_SESSION['role'] !== 'Responsable') ? 'readonly' : '' ?>></td>
                    <td>
                        <?php if ($_SESSION['role'] === 'Responsable'): ?>
                            <button type="submit" name="modifier_atelier">✏️ Modifier</button>
                            <a href="/CSI_APPLICATION/controllers/AtelierController.php?supprimer=<?= $atelier['idAtelier'] ?>" onclick="return confirm('Supprimer ?')">🗑</a>
                        <?php endif; ?>
                    </td>
                </form>
            </tr>

            <?php if ($_SESSION["role"] === 'Woofer'): ?>
                <tr>
                    <td colspan="5">
                        <form method="post" action="/CSI_APPLICATION/controllers/AtelierController.php">
                            <input type="hidden" name="idAtelier" value="<?= $atelier['idAtelier'] ?>">
                            <input type="text" name="nom" placeholder="Nom du participant" required>
                            <input type="text" name="prenom" placeholder="Prénom" required>
                            <input type="text" name="telephone" placeholder="Téléphone" required>
                            <button type="submit" name="inscrire_nouveau">Inscrire</button>
                        </form>
                    </td>
                </tr>
                <?php endif; ?>

            <?php if ($_SESSION["role"] === 'Responsable'): ?>
            <tr>
                <td colspan="5">
                    <strong>Participants :</strong>
                    <ul>
                        <?php 
                            $participants = $model->getParticipants($atelier['idAtelier']);
                            foreach ($participants as $p): ?>
                            <li><?= $p['nom'] . ' ' . $p['prenom'] ?> (<?= $p['dateInscription'] ?>)</li>
                        <?php endforeach; ?>
                    </ul>
                </td>
            </tr>
            <?php endif; ?>

            <?php endforeach; ?>
        </table>
    </div>
</body>
</html>