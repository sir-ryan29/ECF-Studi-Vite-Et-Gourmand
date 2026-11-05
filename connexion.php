<?php
/**
 * FICHIER : connexion.php
 * ROLE : Page d'authentification pour les clients.
 * DESIGN : Thème sombre (#111), bordures et accents ocres.
 */

// Connexion BDD et en-tête de page
require_once 'includes/db.php';
require_once 'includes/header.php';

// Gestion des alertes (redirection après inscription ou erreur d'authentification)
$error_msg = '';
$success_msg = '';

if (isset($_GET['error'])) {
    if ($_GET['error'] === 'invalid') {
        $error_msg = 'Identifiants incorrects. Veuillez vérifier votre email et mot de passe.';
    } elseif ($_GET['error'] === 'empty') {
        $error_msg = 'Veuillez remplir tous les champs du formulaire.';
    }
}

if (isset($_GET['success']) && $_GET['success'] === 'registered') {
    $success_msg = 'Votre compte a été créé avec succès ! Vous pouvez maintenant vous connecter.';
}
?>

<!-- Styles CSS spécifiques à la carte de connexion -->
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

    .login-card {
        background: #111;
        width: 100%;
        max-width: 480px;
        border-radius: 16px;
        border: 1px solid #222;
        overflow: hidden;
        box-shadow: 0 12px 35px rgba(0, 0, 0, 0.6);
        transition: border-color 0.3s ease;
    }

    .login-card:hover {
        border-color: rgba(217, 119, 6, 0.4);
    }

    .login-header {
        background: #0a0a0a;
        padding: 35px 30px;
        text-align: center;
        border-bottom: 1px solid #222;
    }

    .login-body {
        padding: 35px 30px;
        display: flex;
        flex-direction: column;
        gap: 22px;
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

    .alert-box {
        padding: 12px 16px;
        border-radius: 8px;
        font-size: 0.88rem;
        line-height: 1.4;
        text-align: center;
    }

    .alert-error {
        background: rgba(239, 68, 68, 0.1);
        border: 1px solid #ef4444;
        color: #f87171;
    }

    .alert-success {
        background: rgba(34, 197, 94, 0.1);
        border: 1px solid #22c55e;
        color: #4ade80;
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
        margin-top: 5px;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(217, 119, 6, 0.3);
    }

    .btn-submit:hover {
        background: #e68208;
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(217, 119, 6, 0.45);
    }

    .register-link {
        color: var(--ocre);
        text-decoration: none;
        font-weight: bold;
        transition: color 0.3s ease;
    }

    .register-link:hover {
        color: var(--white);
    }
</style>

<main style="padding: 70px 8%; display: flex; justify-content: center; align-items: center; min-height: 70vh;" class="fade-in">
    
    <div class="login-card">
        
        <!-- Titre de la carte -->
        <div class="login-header">
            <span class="badge-tag">Espace Client</span>
            <h1 style="margin: 10px 0 0; font-family: 'Playfair Display', serif; color: var(--white); font-size: 2.2rem;">
                Connexion
            </h1>
            <p style="margin: 10px 0 0; color: #888; font-size: 0.92rem;">
                Accédez à votre espace sécurisé pour suivre vos commandes.
            </p>
        </div>

        <!-- Formulaire de connexion vers le traitement backend -->
        <form action="traitement_connexion.php" method="POST" class="login-body">

            <!-- Affichage dynamique des alertes -->
            <?php if (!empty($error_msg)): ?>
                <div class="alert-box alert-error">
                    <i class="fas fa-exclamation-circle" style="margin-right: 6px;"></i>
                    <?php echo htmlspecialchars($error_msg); ?>
                </div>
            <?php endif; ?>

            <?php if (!empty($success_msg)): ?>
                <div class="alert-box alert-success">
                    <i class="fas fa-check-circle" style="margin-right: 6px;"></i>
                    <?php echo htmlspecialchars($success_msg); ?>
                </div>
            <?php endif; ?>

            <!-- Champ Email -->
            <div class="form-group">
                <label for="email">Adresse email</label>
                <input type="email" id="email" name="email" class="form-control" placeholder="votre.email@exemple.com" required autocomplete="email">
            </div>

            <!-- Champ Mot de passe -->
            <div class="form-group">
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <label for="password">Mot de passe</label>
                    <a href="contact.php?sujet=Oubli+mot+de+passe" style="color: #777; font-size: 0.8rem; text-decoration: none;">Oublié ?</a>
                </div>
                <input type="password" id="password" name="password" class="form-control" placeholder="••••••••" required autocomplete="current-password">
            </div>

            <!-- Bouton d'envoi -->
            <button type="submit" class="btn-submit">
                Se connecter
            </button>

            <!-- Lien de redirection vers l'inscription -->
            <div style="text-align: center; margin-top: 10px; padding-top: 15px; border-top: 1px solid #1a1a1a; font-size: 0.9rem; color: #777;">
                Pas encore de compte ? 
                <a href="inscription.php" class="register-link">Créer un compte</a>
            </div>

        </form>

    </div>

</main>

<?php require_once 'includes/footer.php'; ?>