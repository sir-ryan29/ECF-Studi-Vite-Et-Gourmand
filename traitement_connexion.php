<?php
// On démarre la session pour garder l'utilisateur connecté
session_start();
// On inclut le fichier de connexion à la base de données
require_once 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Recherche de l'utilisateur dans la base par son email
    $sql = "SELECT * FROM utilisateur WHERE email = :email";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['email' => $email]);
    $user = $stmt->fetch();

    // Vérification : si l'utilisateur existe ET que le mot de passe est bon
    if ($user && password_verify($password, $user['password'])) {
        // Enregistrement des infos en session
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_nom'] = $user['nom'];
        
        // Redirection vers l'accueil après connexion réussie
        header("Location: index.html");
        exit();
    } else {
        // Message d'erreur simple si les identifiants sont faux
        echo "Email ou mot de passe incorrect.";
    }
}
?>