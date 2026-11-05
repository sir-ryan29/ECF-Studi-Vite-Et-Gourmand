<?php
/**
 * FICHIER : traitement_connexion.php
 * ROLE : Vérification des identifiants et initialisation de la session utilisateur.
 * CONTEXTE : Évaluation DWWM - Vite & Gourmand
 */

// Initialisation de la session utilisateur
session_start();

// Inclusion sécurisée du fichier de connexion BDD depuis 'includes/'
if (file_exists('includes/db.php')) {
    require_once 'includes/db.php';
} else {
    require_once 'db.php';
}

// 1. Traitement uniquement si le formulaire est soumis en POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // Récupération et nettoyage des données saisies par l'utilisateur
    $email    = isset($_POST['email']) ? trim($_POST['email']) : '';
    $password = isset($_POST['password']) ? trim($_POST['password']) : '';

    // 2. Contrôle des champs obligatoires
    if (empty($email) || empty($password)) {
        header("Location: connexion.php?error=empty");
        exit();
    }

    if ($pdo) {
        try {
            // 3. Requête préparée pour rechercher l'utilisateur par son email (protection contre les injections SQL)
            $sql  = "SELECT * FROM utilisateur WHERE email = :email";
            $stmt = $pdo->prepare($sql);
            $stmt->execute(['email' => $email]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            // 4. Vérification du mot de passe haché via password_verify()
            if ($user && password_verify($password, $user['password'])) {

                // Initialisation des variables de session globales
                $_SESSION['user_id']     = $user['id'];
                $_SESSION['user_nom']    = $user['nom'];
                $_SESSION['user_prenom'] = $user['prenom'] ?? '';
                $_SESSION['user_role']   = $user['id_role'] ?? $user['role'] ?? 1;

                // Redirection vers la page d'accueil une fois connecté
                header("Location: index.php");
                exit();

            } else {
                // Redirection si les identifiants sont erronés
                header("Location: connexion.php?error=invalid");
                exit();
            }

        } catch (PDOException $e) {
            // Redirection en cas de problème de requête SQL
            header("Location: connexion.php?error=invalid");
            exit();
        }
    } else {
        header("Location: connexion.php?error=invalid");
        exit();
    }

} else {
    // Redirection de sécurité en cas d'accès direct hors POST
    header("Location: connexion.php");
    exit();
}