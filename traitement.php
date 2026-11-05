<?php
/**
 * FICHIER : traitement.php
 * ROLE : Page de confirmation après l'envoi du formulaire de contact / devis.
 */

// 1. Contrôle de sécurité : traitement uniquement si le formulaire est soumis en POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nom   = isset($_POST['nom']) && !empty($_POST['nom']) ? htmlspecialchars($_POST['nom']) : '';
    $email = isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '';
} else {
    header("Location: index.php");
    exit();
}

// 2. Inclusions HTML de l'en-tête
require_once 'includes/header.php';
?>

<!-- Styles CSS spécifiques à la carte de confirmation -->
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
        margin-bottom: 15px;
    }

    .confirm-card {
        background: #111;
        border: 1px solid #222;
        border-radius: 20px;
        padding: 50px 40px;
        max-width: 600px;
        margin: 0 auto;
        box-shadow: 0 12px 35px rgba(0, 0, 0, 0.6);
        transition: border-color 0.3s ease;
    }

    .confirm-card:hover {
        border-color: rgba(217, 119, 6, 0.4);
    }

    .confirm-icon {
        font-size: 3.2rem;
        color: var(--ocre);
        margin-bottom: 20px;
    }

    .btn-home {
        display: inline-block;
        background: var(--ocre);
        color: var(--white);
        padding: 13px 28px;
        border-radius: 8px;
        font-weight: bold;
        text-decoration: none;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(217, 119, 6, 0.3);
    }

    .btn-home:hover {
        background: #e68208;
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(217, 119, 6, 0.45);
    }
</style>

<main style="padding: 90px 8%; text-align: center;" class="fade-in">

    <!-- Carte de confirmation de message -->
    <div class="confirm-card">
        <i class="fas fa-check-circle confirm-icon"></i>
        <br>
        <span class="badge-tag">Demande transmise</span>
        
        <h1 style="color: var(--white); font-family: 'Playfair Display', serif; font-size: 2.2rem; margin: 10px 0 20px;">
            Merci <?php echo !empty($nom) ? $nom : ''; ?>,
        </h1>

        <p style="color: #aaa; font-size: 1.05rem; line-height: 1.6; margin-bottom: 30px;">
            Votre demande de devis a bien été reçue par nos équipes.<br>
            Nous reviendrons vers vous très rapidement à l'adresse :<br>
            <strong style="color: var(--ocre); font-size: 1.1rem; display: inline-block; margin-top: 8px;"><?php echo $email; ?></strong>
        </p>

        <a href="index.php" class="btn-home">Retour à l'accueil</a>
    </div>

</main>

<?php require_once 'includes/footer.php'; ?>