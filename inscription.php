<?php
/**
 * FICHIER : inscription.php
 * ROLE : Page de création de compte client.
 * DESIGN : Thème sombre (#111), bordures et accents ocres.
 */

// Connexion BDD et en-tête de page
require_once 'includes/db.php';
require_once 'includes/header.php';

// Récupération des messages d'erreur depuis l'URL
$error_msg = '';

if (isset($_GET['error'])) {
    if ($_GET['error'] === 'exists') {
        $error_msg = 'Un compte existe déjà avec cette adresse email.';
    } elseif ($_GET['error'] === 'password') {
        $error_msg = 'Le mot de passe ne respecte pas les prérequis de sécurité.';
    } elseif ($_GET['error'] === 'empty') {
        $error_msg = 'Veuillez remplir tous les champs obligatoires.';
    } elseif ($_GET['error'] === 'invalid_email') {
        $error_msg = 'L\'adresse email saisie n\'est pas valide.';
    }
}
?>

<!-- Styles CSS spécifiques à la carte d'inscription -->
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

    .register-card {
        background: #111;
        width: 100%;
        max-width: 600px;
        border-radius: 16px;
        border: 1px solid #222;
        overflow: hidden;
        box-shadow: 0 12px 35px rgba(0, 0, 0, 0.6);
        transition: border-color 0.3s ease;
    }

    .register-card:hover {
        border-color: rgba(217, 119, 6, 0.4);
    }

    .register-header {
        background: #0a0a0a;
        padding: 35px 30px;
        text-align: center;
        border-bottom: 1px solid #222;
    }

    .register-body {
        padding: 35px 30px;
        display: flex;
        flex-direction: column;
        gap: 18px;
    }

    .form-row {
        display: flex;
        gap: 15px;
    }

    .form-group {
        display: flex;
        flex-direction: column;
        gap: 8px;
        text-align: left;
        flex: 1;
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

    .alert-box {
        padding: 12px 16px;
        border-radius: 8px;
        font-size: 0.88rem;
        line-height: 1.4;
        text-align: center;
        background: rgba(239, 68, 68, 0.1);
        border: 1px solid #ef4444;
        color: #f87171;
    }

    .btn-submit {
        background: var(--ocre);
        color: var(--white);
        padding: 14px;
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

    .login-link {
        color: var(--ocre);
        text-decoration: none;
        font-weight: bold;
        transition: color 0.3s ease;
    }

    .login-link:hover {
        color: var(--white);
    }

    @media (max-width: 600px) {
        .form-row {
            flex-direction: column;
        }
    }
</style>

<main style="padding: 60px 8%; display: flex; justify-content: center; align-items: center;" class="fade-in">
    
    <div class="register-card">
        
        <!-- En-tête du formulaire -->
        <div class="register-header">
            <span class="badge-tag">Nouveau Client</span>
            <h1 style="margin: 10px 0 0; font-family: 'Playfair Display', serif; color: var(--white); font-size: 2.2rem;">
                Créer un compte
            </h1>
            <p style="margin: 10px 0 0; color: #888; font-size: 0.92rem;">
                Créez votre compte pour commander nos menus et suivre vos prestations.
            </p>
        </div>

        <!-- Formulaire de création de compte vers le script de traitement -->
        <form action="traitement_inscription.php" method="POST" class="register-body">

            <!-- Affichage des alertes d'erreur -->
            <?php if (!empty($error_msg)): ?>
                <div class="alert-box">
                    <i class="fas fa-exclamation-circle" style="margin-right: 6px;"></i>
                    <?php echo htmlspecialchars($error_msg); ?>
                </div>
            <?php endif; ?>

            <!-- Nom et Prénom -->
            <div class="form-row">
                <div class="form-group">
                    <label for="nom">Nom *</label>
                    <input type="text" id="nom" name="nom" class="form-control" placeholder="Nom" required>
                </div>
                <div class="form-group">
                    <label for="prenom">Prénom *</label>
                    <input type="text" id="prenom" name="prenom" class="form-control" placeholder="Prénom" required>
                </div>
            </div>

            <!-- Email -->
            <div class="form-group">
                <label for="email">Adresse email *</label>
                <input type="email" id="email" name="email" class="form-control" placeholder="votre.email@exemple.com" required autocomplete="email">
            </div>

            <!-- Téléphone GSM -->
            <div class="form-group">
                <label for="telephone">Téléphone (GSM) *</label>
                <input type="tel" id="telephone" name="telephone" class="form-control" placeholder="06 12 34 56 78" required>
            </div>

            <!-- Adresse postale -->
            <div class="form-group">
                <label for="adresse_postale">Adresse postale *</label>
                <input type="text" id="adresse_postale" name="adresse_postale" class="form-control" placeholder="12 rue de Bordeaux, 33000 Bordeaux" required>
            </div>

            <!-- Mot de passe -->
            <div class="form-group">
                <label for="password">Mot de passe (10 car. min, 1 maj, 1 min, 1 chiffre, 1 spécial) *</label>
                <input type="password" id="password" name="password" class="form-control" placeholder="••••••••" required autocomplete="new-password">
            </div>

            <!-- Bouton de création de compte -->
            <button type="submit" class="btn-submit">
                Créer mon compte
            </button>

            <!-- Lien de redirection vers la connexion -->
            <div style="text-align: center; margin-top: 10px; padding-top: 15px; border-top: 1px solid #1a1a1a; font-size: 0.9rem; color: #777;">
                Déjà un compte ? 
                <a href="connexion.php" class="login-link">Se connecter</a>
            </div>

        </form>

    </div>

</main>

<?php require_once 'includes/footer.php'; ?>