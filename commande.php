<?php
/**
 * FICHIER : commande.php
 * ROLE : Formulaire de finalisation et de validation d'une commande.
 */

session_start();

// Connexion BDD et contrôles de sécurité avant l'affichage HTML
require_once 'includes/db.php';

// 1. Contrôle d'accès : redirection si l'utilisateur n'est pas connecté
if (!isset($_SESSION['user_id'])) {
    header("Location: connexion.php");
    exit();
}

// 2. Vérification de la présence du paramètre 'id' de menu
if (!isset($_GET['id'])) {
    header("Location: menus.php");
    exit();
}

$id_menu = intval($_GET['id']);
$menu_details = null;
$error_msg = '';

// Récupération des messages d'erreur transmis dans l'URL
if (isset($_GET['error'])) {
    if ($_GET['error'] === 'empty') {
        $error_msg = 'Veuillez remplir tous les champs du formulaire.';
    } elseif ($_GET['error'] === 'db') {
        $error_msg = 'Une erreur est survenue lors de l\'enregistrement de votre commande.';
    }
}

// Récupération des informations du menu sélectionné
if ($pdo) {
    try {
        $stmt = $pdo->prepare("SELECT titre, prix_par_personne_min, nb_personne_min FROM menu WHERE id = :id");
        $stmt->execute(['id' => $id_menu]);
        $menu_details = $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        $menu_details = null;
    }
}

// Inclusion de l'en-tête HTML de la page
require_once 'includes/header.php';
?>

<!-- Styles CSS spécifiques à la carte de réservation -->
<style>
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(25px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .fade-in {
        animation: fadeInUp 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards;
    }

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

    .order-card {
        background: #111;
        width: 100%;
        max-width: 580px;
        border-radius: 16px;
        border: 1px solid #222;
        overflow: hidden;
        box-shadow: 0 12px 35px rgba(0, 0, 0, 0.6);
        transition: border-color 0.3s ease;
    }

    .order-card:hover {
        border-color: rgba(217, 119, 6, 0.4);
    }

    .order-header {
        background: #0a0a0a;
        padding: 35px 30px;
        text-align: center;
        border-bottom: 1px solid #222;
    }

    .order-body {
        padding: 35px 30px;
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    .form-group {
        display: flex;
        flex-direction: column;
        gap: 8px;
        text-align: left;
    }

    .form-group label {
        color: var(--white);
        font-size: 0.9rem;
        font-weight: 500;
    }

    .form-control {
        width: 100%;
        padding: 13px 16px;
        background: #0a0a0a;
        border: 1px solid #2a2a2a;
        border-radius: 8px;
        color: var(--white);
        font-size: 0.95rem;
        box-sizing: border-box;
        outline: none;
        transition: border-color 0.3s ease, box-shadow 0.3s ease;
    }

    .form-control:focus {
        border-color: var(--ocre);
        box-shadow: 0 0 0 3px rgba(217, 119, 6, 0.2);
    }

    .menu-summary-box {
        background: #0a0a0a;
        border: 1px solid #222;
        border-radius: 10px;
        padding: 15px 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 5px;
    }

    .alert-error {
        background: rgba(239, 68, 68, 0.1);
        border: 1px solid #ef4444;
        color: #f87171;
        padding: 12px 16px;
        border-radius: 8px;
        font-size: 0.88rem;
        text-align: center;
    }

    .btn-submit {
        background: var(--ocre);
        color: var(--white);
        padding: 15px;
        border: none;
        border-radius: 8px;
        font-weight: bold;
        cursor: pointer;
        font-size: 1rem;
        margin-top: 10px;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(217, 119, 6, 0.3);
    }

    .btn-submit:hover {
        background: #e68208;
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(217, 119, 6, 0.45);
    }
</style>

<main style="padding: 60px 8%; display: flex; justify-content: center; align-items: center;" class="fade-in">

    <div class="order-card">
        
        <!-- En-tête de la carte -->
        <div class="order-header">
            <span class="badge-tag">Réservation</span>
            <h1 style="margin: 10px 0 0; font-family: 'Playfair Display', serif; color: var(--white); font-size: 2.2rem;">
                Finaliser votre commande
            </h1>
            <p style="margin: 10px 0 0; color: #888; font-size: 0.92rem;">
                Précisez les détails de livraison pour valider votre demande.
            </p>
        </div>

        <!-- Formulaire transmis au traitement backend -->
        <form action="traitement_commande.php" method="POST" class="order-body">
            
            <input type="hidden" name="id_menu" value="<?php echo $id_menu; ?>">

            <!-- Affichage des erreurs si présentes -->
            <?php if (!empty($error_msg)): ?>
                <div class="alert-error">
                    <i class="fas fa-exclamation-circle" style="margin-right: 6px;"></i>
                    <?php echo htmlspecialchars($error_msg); ?>
                </div>
            <?php endif; ?>

            <!-- Récapitulatif du menu sélectionné -->
            <?php if ($menu_details): ?>
                <div class="menu-summary-box">
                    <div>
                        <span style="font-size: 0.8rem; color: #777; text-transform: uppercase; letter-spacing: 0.5px;">Menu sélectionné</span>
                        <h3 style="margin: 4px 0 0; color: var(--white); font-size: 1.1rem; font-family: 'Playfair Display', serif;">
                            <?php echo htmlspecialchars($menu_details['titre']); ?>
                        </h3>
                    </div>
                    <div style="text-align: right;">
                        <span style="color: var(--ocre); font-weight: bold; font-size: 1.1rem;">
                            <?php echo number_format($menu_details['prix_par_personne_min'], 2, ',', ' '); ?> €
                        </span>
                        <span style="display: block; font-size: 0.75rem; color: #666;">/ pers. min.</span>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Champ Date de livraison -->
            <div class="form-group">
                <label for="date_livraison">Date de livraison *</label>
                <input type="date" id="date_livraison" name="date_livraison" class="form-control" required style="color-scheme: dark;">
            </div>

            <!-- Champ Nombre de personnes -->
            <div class="form-group">
                <label for="nb_personnes">Nombre de personnes *</label>
                <input type="number" id="nb_personnes" name="nb_personnes" class="form-control" min="<?php echo $menu_details['nb_personne_min'] ?? 1; ?>" value="<?php echo $menu_details['nb_personne_min'] ?? 1; ?>" required>
            </div>

            <!-- Champ Lieu de livraison -->
            <div class="form-group">
                <label for="lieu_livraison">Lieu de livraison *</label>
                <input type="text" id="lieu_livraison" name="lieu_livraison" class="form-control" placeholder="Adresse complète de livraison" required>
            </div>

            <!-- Validation de la commande -->
            <button type="submit" class="btn-submit">
                Confirmer la demande
            </button>
        </form>

    </div>

</main>

<?php require_once 'includes/footer.php'; ?>