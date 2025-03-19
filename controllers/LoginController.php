
<?php


session_start();

include __DIR__ . '/../config/database.php';
include __DIR__ . '/../models/UserModel.php';

$userModel = new UserModel($pdo);

$user = null; // Initialise la variable

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);

    if (!empty($email) && !empty($password)) {
        $user = $userModel->getUserByEmail($email); // Récupération de l'utilisateur

        if ($user) {
            // Teste si le mot de passe correspond
            if ($user && password_verify($password, $user['password'])) {
                $_SESSION["email"] = $user["email"];
                $_SESSION["role"] = $user["typeUtilisateur"];

  
                // Redirection selon le rôle
                if ($user["typeUtilisateur"] == "Responsable") {
                    header("Location: ../public/responsable_dashboard.php");
                    exit();
                } else {
                    header("Location: ../public/woofer_dashboard.php");
                    exit();
                }
            } else {
                $error = "Mot de passe incorrect.";
            }
        } else {
            $error = "Email incorrect.";
        }
    } else {
        $error = "Veuillez remplir tous les champs.";
    }
}
include '../views/login.php';
?>
