<?php
/**
 * FICHIER : traitement_inscription.php
 * ROLE : Inscription d'un nouvel utilisateur (hachage du mot de passe et insertion BDD).
 * SECURITE : Requêtes préparées PDO et password_hash().
 */

session_start();

// Inclusion de la connexion BDD (chemin centralisé)
if (file_exists('includes/db.php')) {
    require_once 'includes/db.php';
} else {
    require_once 'db.php';
}

// 1. Vérification de la soumission du formulaire
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // 2. Nettoyage et récupération des champs
    $nom       = isset($_POST['nom']) ? trim(htmlspecialchars($_POST['nom'])) : '';
    $prenom    = isset($_POST['prenom']) ? trim(htmlspecialchars($_POST['prenom'])) : '';
    $email     = isset($_POST['email']) ? filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL) : '';
    $telephone = isset($_POST['telephone']) ? trim(htmlspecialchars($_POST['telephone'])) : '';
    $adresse   = isset($_POST['adresse_postale']) ? trim(htmlspecialchars($_POST['adresse_postale'])) : '';
    $raw_pass  = isset($_POST['password']) ? $_POST['password'] : '';

    // 3. Contrôle des champs obligatoires
    if (empty($nom) || empty($prenom) || empty($email) || empty($raw_pass) || empty($telephone) || empty($adresse)) {
        header("Location: inscription.php?error=empty");
        exit();
    }

    // Validation du format d'email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header("Location: inscription.php?error=invalid_email");
        exit();
    }

    if ($pdo) {
        try {
            // 4. Hachage sécurisé du mot de passe avec Bcrypt
            $password_hash = password_hash($raw_pass, PASSWORD_DEFAULT);

            // 5. Requête préparée pour l'insertion en base (sécurité SQL)
            $sql = "INSERT INTO utilisateur (nom, prenom, email, telephone, adresse_postale, password) 
                    VALUES (:nom, :prenom, :email, :telephone, :adresse, :password)";
            
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                'nom'       => $nom,
                'prenom'    => $prenom,
                'email'     => $email,
                'telephone' => $telephone,
                'adresse'   => $adresse,
                'password'  => $password_hash
            ]);

            // 6. Redirection vers la page de connexion
            header("Location: connexion.php?success=registered");
            exit();

        } catch (PDOException $e) {
            // Gestion des doublons d'email ou erreurs BDD
            header("Location: inscription.php?error=exists");
            exit();
        }
    } else {
        header("Location: inscription.php?error=db");
        exit();
    }

} else {
    // Redirection de sécurité en cas d'accès direct
    header("Location: inscription.php");
    exit();
}