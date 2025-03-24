<?php
session_start();
if ($_SESSION["role"] !== "Responsable") {
    header("Location: login.php");
    exit();
}
include_once __DIR__ . '/../models/WooferModel.php';
$model = new WooferModel($pdo);
$woofers = $model->getAllWoofers();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion des Woofers</title>
    <link rel="stylesheet" href="/CSI_APPLICATION/asserts/stocks.css">
</head>
<body>
    <div class="header">
        <h1>Gestion des Woofers</h1>
        <a href="/CSI_APPLICATION/public/responsable_dashboard.php" class="back-link">🔙 Retour</a>
    </div>

    <div class="container">
        <?php if (isset($_GET['success'])) echo "<p class='success'>".$_GET['success']."</p>"; ?>

        <h2>Ajouter un Woofer</h2>
        <form method="post" action="/CSI_APPLICATION/controllers/WooferController.php">
            <input type="text" name="nom" placeholder="Nom" required>
            <input type="text" name="prenom" placeholder="Prénom" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="text" name="telephone" placeholder="Téléphone" required>
            <input type="password" name="password" placeholder="Mot de passe" required>
            <button type="submit" name="ajouter_woofer">Ajouter</button>
        </form>

        <h2>Liste des Woofers</h2>
        <table>
            <tr>
                <th>Nom</th><th>Email</th><th>Téléphone</th><th>Statut</th><th>Actions</th>
            </tr>
            <?php foreach ($woofers as $w): ?>
            <tr>
                <form method="post" action="/CSI_APPLICATION/controllers/WooferController.php">
                    <input type="hidden" name="id" value="<?= $w['idUtilisateur'] ?>">
                    <td><input type="text" name="nom" value="<?= $w['nom'] ?>"></td>
                    <td><input type="text" name="email" value="<?= $w['email'] ?>"></td>
                    <td><input type="text" name="telephone" value="<?= $w['telephone'] ?>"></td>
                    <td>
                        <select name="statut">
                            <option value="Actif" <?= $w['statut'] === 'Actif' ? 'selected' : '' ?>>Actif</option>
                            <option value="Inactif" <?= $w['statut'] === 'Inactif' ? 'selected' : '' ?>>Inactif</option>
                        </select>
                    </td>
                    <td>
                        <button type="submit" name="modifier_woofer">💾 Modifier</button>
                    </td>
                </form>
            </tr>
            <?php endforeach; ?>
        </table>
    </div>
</body>
</html>