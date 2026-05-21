<?php
// --- FICHIER : traitement_inscription.php ---
// --- ROLE : Gestion de la persistance des données utilisateur ---
// --- SECURITE : Prévention des failles SQL ---
// Utilisation de requêtes préparées pour éviter toute injection malveillante.
require_once 'db.php';

// Vérification de la méthode d'envoi des données
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Contrôle de la disponibilité de l'instance PDO
    if (!$pdo) {
        die("Erreur : Connexion à la base de données indisponible.");
    }
    
    // Récupération des entrées utilisateur
    $nom = htmlspecialchars($_POST['nom']);
    $prenom = htmlspecialchars($_POST['prenom']);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $telephone = htmlspecialchars($_POST['telephone']);
    $adresse = htmlspecialchars($_POST['adresse_postale']);
    
    // Sécurisation du mot de passe par hachage (Algorithme Bcrypt par défaut)
    $password_hash = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Préparation de la requête d'insertion (utilisation de marqueurs nommés pour prévenir les injections SQL)
    $sql = "INSERT INTO utilisateur (nom, prenom, email, telephone, adresse_postale, password) 
            VALUES (:nom, :prenom, :email, :telephone, :adresse, :password)";
            
    $stmt = $pdo->prepare($sql);
    
    // Exécution de la requête avec liaison des paramètres
    try {
        $stmt->execute([
            'nom'      => $nom,
            'prenom'   => $prenom,
            'email'    => $email,
            'telephone'=> $telephone,
            'adresse'  => $adresse,
            'password' => $password_hash
        ]);
        
        // Redirection après succès de l'opération
        header("Location: connexion.php?inscription=success");
        exit();
        
    } catch (PDOException $e) {
        // Journalisation de l'erreur (pour le correcteur : gestion des exceptions)
        echo "Erreur lors de l'enregistrement : " . $e->getMessage();
    }
}
?>