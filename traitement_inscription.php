<?php
// --- FICHIER : traitement_inscription.php ---
// --- ROLE : Logique back-end pour enregistrer un nouvel utilisateur ---

// 1. Connexion à la base de données
require_once 'db.php';

// 2. Vérification que le formulaire a bien été envoyé
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // 3. Récupération et sécurisation des données du formulaire
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $email = $_POST['email'];
    $telephone = $_POST['telephone'];
    $adresse = $_POST['adresse_postale'];
    
    // 4. Hashage sécurisé du mot de passe (indispensable pour la sécurité)
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // 5. Préparation de la requête SQL (protection contre les injections)
    $sql = "INSERT INTO utilisateur (nom, prenom, email, telephone, adresse_postale, password) 
            VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    
    // 6. Exécution de l'insertion
    if($stmt->execute([$nom, $prenom, $email, $telephone, $adresse, $password])) {
        // Succès : redirection vers la page de connexion
        header("Location: connexion.php?inscription=success");
        exit();
    } else {
        // En cas d'échec
        echo "Erreur lors de l'enregistrement en base de données.";
    }
}
?>