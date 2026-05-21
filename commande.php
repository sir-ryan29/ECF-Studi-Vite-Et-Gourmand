<?php
// --- FICHIER : commande.php ---
// --- ROLE : Formulaire de commande pour un menu spécifique ---

session_start();
require_once 'db.php';

// Sécurité : Redirection si non connecté
if (!isset($_SESSION['user_id'])) {
    header("Location: connexion.php");
    exit();
}

// Vérification de l'ID du menu passé dans l'URL
if (!isset($_GET['id'])) {
    header("Location: menus.php");
    exit();
}

include 'header.php';
?>

<div style="padding: 50px 8%; text-align: center;">
    <h1>Finaliser votre commande</h1>
    
    <form action="traitement_commande.php" method="POST" style="max-width: 500px; margin: 0 auto; background: #f9f9f9; padding: 30px; border-radius: 8px;">
        <input type="hidden" name="id_menu" value="<?php echo htmlspecialchars($_GET['id']); ?>">

        <label style="display: block; margin-bottom: 10px; font-weight: bold;">Date de livraison :</label>
        <input type="date" name="date_livraison" required style="width: 100%; padding: 10px; margin-bottom: 20px;">

        <label style="display: block; margin-bottom: 10px; font-weight: bold;">Nombre de personnes :</label>
        <input type="number" name="nb_personnes" min="1" required style="width: 100%; padding: 10px; margin-bottom: 20px;">

        <label style="display: block; margin-bottom: 10px; font-weight: bold;">Lieu de livraison :</label>
        <input type="text" name="lieu_livraison" required style="width: 100%; padding: 10px; margin-bottom: 20px;">

        <button type="submit" style="width: 100%; padding: 15px; background: #e65100; color: white; border: none; border-radius: 5px; font-weight: bold; cursor: pointer;">
            Confirmer la demande
        </button>
    </form>
</div>

<?php include 'footer.php'; ?>