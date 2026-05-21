<?php
// --- FICHIER : espace_client.php ---
// --- ROLE : Interface sécurisée pour le client avec historique de commandes ---

session_start();
require_once 'db.php';

// Sécurisation : accès refusé aux non-connectés
if (!isset($_SESSION['user_id'])) {
    header("Location: connexion.php");
    exit();
}

include 'header.php';

// Récupération des commandes de l'utilisateur connecté
$stmt = $pdo->prepare("SELECT c.*, m.titre 
                       FROM commande c 
                       JOIN menu m ON c.id_menu = m.id 
                       WHERE c.id_client = ? 
                       ORDER BY c.date_commande DESC");
$stmt->execute([$_SESSION['user_id']]);
$commandes = $stmt->fetchAll();
?>

<div style="padding: 50px 8%;">
    <h1>Bienvenue, <?php echo htmlspecialchars($_SESSION['user_nom']); ?> !</h1>
    
    <?php if (isset($_GET['success'])): ?>
        <p style="color: green; font-weight: bold;">✅ Commande confirmée avec succès !</p>
    <?php endif; ?>

    <h2>Mes commandes</h2>
    <?php if (count($commandes) > 0): ?>
        <table style="width: 100%; border-collapse: collapse; margin-top: 20px;">
            <tr style="background: #eee;">
                <th style="padding: 10px; border: 1px solid #ddd;">Menu</th>
                <th style="padding: 10px; border: 1px solid #ddd;">Date livraison</th>
                <th style="padding: 10px; border: 1px solid #ddd;">Statut</th>
            </tr>
            <?php foreach ($commandes as $cmd): ?>
            <tr>
                <td style="padding: 10px; border: 1px solid #ddd;"><?php echo htmlspecialchars($cmd['titre']); ?></td>
                <td style="padding: 10px; border: 1px solid #ddd;"><?php echo htmlspecialchars($cmd['date_livraison']); ?></td>
                <td style="padding: 10px; border: 1px solid #ddd;"><?php echo htmlspecialchars($cmd['statut_commande']); ?></td>
            </tr>
            <?php endforeach; ?>
        </table>
    <?php else: ?>
        <p>Vous n'avez pas encore passé de commande.</p>
    <?php endif; ?>
    
    <div style="margin-top: 30px;">
        <a href="deconnexion.php" style="padding: 10px 20px; background: #333; color: white; text-decoration: none; border-radius: 5px;">
            Se déconnecter
        </a>
    </div>
</div>

<?php include 'footer.php'; ?>