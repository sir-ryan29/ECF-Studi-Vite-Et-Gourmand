<?php
/**
 * FICHIER : actions/traitement_inscription.php
 * ROLE : Inscription nouvel utilisateur avec hachage de mot de passe.
 * SECURITE : Prévention injections et XSS (htmlspecialchars).
 */
require_once '../includes/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = htmlspecialchars($_POST['nom']);
    $prenom = htmlspecialchars($_POST['prenom']);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $telephone = htmlspecialchars($_POST['telephone']);
    $adresse = htmlspecialchars($_POST['adresse_postale']);
    
    // Hachage du mot de passe
    $password_hash = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $sql = "INSERT INTO utilisateur (nom, prenom, email, telephone, adresse_postale, password) 
            VALUES (:nom, :prenom, :email, :telephone, :adresse, :password)";
            
    $stmt = $pdo->prepare($sql);
    
    try {
        $stmt->execute([
            'nom'       => $nom,
            'prenom'    => $prenom,
            'email'     => $email,
            'telephone' => $telephone,
            'adresse'   => $adresse,
            'password'  => $password_hash
        ]);
        header("Location: ../connexion.php?inscription=success");
        exit();
    } catch (PDOException $e) {
        echo "Erreur lors de l'enregistrement : " . $e->getMessage();
    }
}