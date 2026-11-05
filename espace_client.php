<?php
/**
 * FICHIER : espace_client.php
 * ROLE : Tableau de bord client et suivi de l'historique des commandes.
 */

session_start();

// Connexion à la base de données via le dossier centralisé includes
require_once 'includes/db.php';

// Redirection de sécurité si l'utilisateur n'est pas authentifié
if (!isset($_SESSION['user_id'])) {
    header("Location: connexion.php");
    exit();
}

// Inclusion de l'en-tête de page
require_once 'includes/header.php';

// Récupération de l'historique des commandes de l'utilisateur connecté
$commandes = [];
if ($pdo) {
    try {
        $stmt = $pdo->prepare("SELECT c.*, m.titre 
                               FROM commande c 
                               JOIN menu m ON c.id_menu = m.id 
                               WHERE c.id_client = :id_client 
                               ORDER BY c.id DESC");
        $stmt->execute(['id_client' => $_SESSION['user_id']]);
        $commandes = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        $commandes = [];
    }
}
?>

<!-- Styles CSS spécifiques au tableau de bord client -->
<style>
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(25px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .fade-in { animation: fadeInUp 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards; }

    .badge-tag {
        display: inline-block;
        background: rgba(217, 119, 6, 0.15);
        color: var(--ocre);
        border: 1px solid var(--ocre);
        padding: 4px 14px;
        border-radius: 20px;
        font-size: 0.8rem;
        text-transform: uppercase;
        letter-spacing: 1px;
        font-weight: bold;
        margin-bottom: 12px;
    }

    .client-card {
        background: #111;
        border: 1px solid #222;
        border-radius: 16px;
        padding: 35px 30px;
        margin-bottom: 30px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
    }

    .table-responsive { width: 100%; overflow-x: auto; }

    .orders-table {
        width: 100%;
        border-collapse: collapse;
        text-align: left;
    }

    .orders-table th {
        background: #0a0a0a;
        color: var(--white);
        padding: 16px;
        font-weight: bold;
        font-size: 0.9rem;
        border-bottom: 2px solid #222;
        font-family: 'Playfair Display', serif;
    }

    .orders-table td {
        padding: 16px;
        border-bottom: 1px solid #1a1a1a;
        color: #ccc;
        font-size: 0.95rem;
    }

    .orders-table tr:hover td { background: rgba(255, 255, 255, 0.02); }

    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 14px;
        border-radius: 20px;
        font-size: 0.82rem;
        font-weight: bold;
        text-transform: capitalize;
    }

    .status-attente {
        background: rgba(217, 119, 6, 0.15);
        color: var(--ocre);
        border: 1px solid rgba(217, 119, 6, 0.4);
    }

    .status-validee {
        background: rgba(34, 197, 94, 0.15);
        color: #4ade80;
        border: 1px solid rgba(34, 197, 94, 0.4);
    }

    .alert-success {
        background: rgba(34, 197, 94, 0.1);
        border: 1px solid #22c55e;
        color: #4ade80;
        padding: 16px 20px;
        border-radius: 10px;
        margin-bottom: 30px;
        font-weight: bold;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .btn-logout {
        display: inline-block;
        background: transparent;
        color: #aaa;
        border: 1px solid #333;
        padding: 10px 22px;
        border-radius: 8px;
        text-decoration: none;
        font-size: 0.9rem;
        font-weight: bold;
        transition: all 0.3s ease;
    }

    .btn-logout:hover {
        background: #222;
        color: var(--white);
        border-color: #555;
    }
</style>

<main style="padding: 60px 8%; max-width: 1100px; margin: 0 auto;" class="fade-in">

    <!-- En-tête de l'espace personnel -->
    <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 20px; margin-bottom: 40px;">
        <div>
            <span class="badge-tag">Espace Personnel</span>
            <h1 style="font-family: 'Playfair Display', serif; color: var(--white); font-size: 2.5rem; margin: 5px 0 0;">
                Bienvenue, <?php echo htmlspecialchars($_SESSION['user_prenom'] ?? $_SESSION['user_nom']); ?> !
            </h1>
        </div>
        <a href="deconnexion.php" class="btn-logout">
            <i class="fas fa-sign-out-alt" style="margin-right: 8px;"></i>Se déconnecter
        </a>
    </div>

    <!-- Confirmation de validation de commande -->
    <?php if (isset($_GET['success'])): ?>
        <div class="alert-success">
            <i class="fas fa-check-circle" style="font-size: 1.4rem;"></i>
            <div>
                <span style="display: block; font-size: 1.05rem;">Commande validée avec succès !</span>
                <span style="font-weight: normal; font-size: 0.88rem; opacity: 0.9;">Votre demande est enregistrée et passe en statut "En attente".</span>
            </div>
        </div>
    <?php endif; ?>

    <!-- Historique des commandes -->
    <div class="client-card">
        <h2 style="font-family: 'Playfair Display', serif; color: var(--white); font-size: 1.6rem; margin: 0 0 25px;">
            Mes Commandes en cours & Passées
        </h2>

        <?php if (count($commandes) > 0): ?>
            <div class="table-responsive">
                <table class="orders-table">
                    <thead>
                        <tr>
                            <th>N°</th>
                            <th>Menu</th>
                            <th>Date Livraison</th>
                            <th>Convives</th>
                            <th>Total</th>
                            <th>Statut</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($commandes as $cmd): ?>
                            <tr>
                                <td style="color: #777; font-weight: bold;">
                                    #<?php echo htmlspecialchars($cmd['id']); ?>
                                </td>
                                <td style="font-weight: bold; color: var(--white);">
                                    <?php echo htmlspecialchars($cmd['titre']); ?>
                                </td>
                                <td>
                                    <?php echo htmlspecialchars(date('d/m/Y', strtotime($cmd['date_livraison']))); ?>
                                </td>
                                <td>
                                    <?php echo htmlspecialchars($cmd['nb_personnes']); ?> pers.
                                </td>
                                <td style="color: var(--ocre); font-weight: bold;">
                                    <?php echo number_format($cmd['prix_menu'] + $cmd['prix_livraison'], 2, ',', ' '); ?> €
                                </td>
                                <td>
                                    <?php 
                                        $statut = htmlspecialchars($cmd['statut_commande']);
                                        $badge_class = 'status-attente';
                                        $icon = 'fa-clock';
                                        if (in_array(mb_strtolower($statut), ['validée', 'validee', 'livrée', 'livree'])) {
                                            $badge_class = 'status-validee';
                                            $icon = 'fa-check-circle';
                                        }
                                    ?>
                                    <span class="status-badge <?php echo $badge_class; ?>">
                                        <i class="fas <?php echo $icon; ?>"></i>
                                        <?php echo $statut; ?>
                                    </span>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div style="text-align: center; padding: 40px 20px;">
                <i class="fas fa-utensils" style="font-size: 2.5rem; color: #333; margin-bottom: 15px; display: block;"></i>
                <p style="color: #888; font-size: 1rem; margin-bottom: 20px;">
                    Aucune commande enregistrée pour le moment.
                </p>
                <a href="menus.php" style="background: var(--ocre); color: white; padding: 10px 22px; border-radius: 8px; text-decoration: none; font-weight: bold;">
                    Découvrir les menus
                </a>
            </div>
        <?php endif; ?>
    </div>

</main>

<?php require_once 'includes/footer.php'; ?>