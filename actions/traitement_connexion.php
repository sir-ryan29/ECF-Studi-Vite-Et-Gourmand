<?php
/**
 * FICHIER : actions/traitement_connexion.php
 * ROLE : Validation des identifiants et création de session.
 * SECURITE : Vérification de hash Bcrypt.
 */
session_start();
require_once '../includes/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM utilisateur WHERE email = :email";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['email' => $email]);
    $user = $stmt->fetch();

    // Vérification du mot de passe haché
    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_nom'] = $user['nom'];
        header("Location: ../index.php");
        exit();
    } else {
        echo "Identifiants incorrects. <a href='../connexion.php'>Réessayer</a>";
    }
}