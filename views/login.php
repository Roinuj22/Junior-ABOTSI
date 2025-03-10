<?php
session_start();
include("../config/db.php"); // Inclure la connexion DB

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];

    $query = $pdo->prepare("SELECT * FROM Utilisateur WHERE email = :email");
    $query->execute(["email" => $email]);
    $user = $query->fetch(PDO::FETCH_ASSOC);

    if ($user && $password == $user["telephone"]) { // ⚠️ Remplace 'telephone' par un champ "motDePasse" dans la BD plus tard
        $_SESSION["idUtilisateur"] = $user["idUtilisateur"];
        $_SESSION["typeUtilisateur"] = $user["typeUtilisateur"];

        header("Location: ../index.php"); // Redirection après connexion
        exit();
    } else {
        $error = "Email ou mot de passe incorrect";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>
    <h2>Connexion</h2>
    <?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
    <form method="POST">
        <input type="email" name="email" placeholder="Email" required><br>
        <input type="password" name="password" placeholder="Mot de passe" required><br>
        <button type="submit">Se connecter</button>
    </form>
</body>
</html>