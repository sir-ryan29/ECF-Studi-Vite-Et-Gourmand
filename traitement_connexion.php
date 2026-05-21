<?php
// --- SECURITE : Prévention des failles SQL ---
// Utilisation de requêtes préparées pour éviter toute injection malveillante.
// On démarre la session pour gérer la connexion
session_start();

// Connexion à la BDD via le fichier dédié
require_once 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Récupération des données du formulaire
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Préparation de la requête pour éviter les injections SQL (bonne pratique prof)
    $sql = "SELECT * FROM utilisateur WHERE email = :email";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['email' => $email]);
    $user = $stmt->fetch();

    // Vérification du mot de passe avec le hash en base
    if ($user && password_verify($password, $user['password'])) {
        // Création de la session utilisateur
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_nom'] = $user['nom'];
        
        // Redirection vers index.php (et pas .html car c'est du PHP !)
        header("Location: index.php");
        exit();
    } else {
        // Message d'erreur si la connexion échoue
        echo "Identifiants incorrects. <a href='connexion.php'>Réessayer</a>";
    }
}
?>