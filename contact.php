<?php
/**
 * FICHIER : contact.php
 * ROLE : Page de contact officielle et demande de devis.
 * DESIGN : Thème sombre, grille 2 colonnes (Infos & Formulaire), accents ocres.
 */
require_once 'includes/header.php';

// Récupération de l'offre si transmise dans l'URL
$offre_param = isset($_GET['offre']) ? htmlspecialchars($_GET['offre']) : '';
$default_sujet = '';

if ($offre_param === 'prive') {
    $default_sujet = 'Demande de devis - Pack Réception Privée';
} elseif ($offre_param === 'corporate') {
    $default_sujet = 'Demande de devis - Offre Corporate';
} elseif ($offre_param === 'cocktail') {
    $default_sujet = 'Demande de devis - Cocktail & Buffet Signature';
}
?>

<style>
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(25px); }
        to { opacity: 1; transform: translateY(0); }
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

    .contact-container {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
        gap: 40px;
        max-width: 1100px;
        margin: 0 auto;
        align-items: start;
    }

    .info-card {
        background: #111;
        border: 1px solid #222;
        border-radius: 16px;
        padding: 40px;
        display: flex;
        flex-direction: column;
        gap: 30px;
    }

    .info-item {
        display: flex;
        gap: 20px;
        align-items: flex-start;
    }

    .info-icon {
        background: rgba(217, 119, 6, 0.1);
        border: 1px solid var(--ocre);
        color: var(--ocre);
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
        flex-shrink: 0;
    }

    .form-card {
        background: #111;
        border: 1px solid #222;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
        min-height: 450px;
    }

    .form-header {
        background: #0a0a0a;
        padding: 30px;
        text-align: center;
        border-bottom: 1px solid #222;
    }

    .form-body {
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
        transition: border-color 0.3s ease;
    }

    .form-control:focus {
        border-color: var(--ocre);
        box-shadow: 0 0 0 3px rgba(217, 119, 6, 0.2);
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
    }

    .btn-submit:hover {
        background: #e68208;
        transform: translateY(-2px);
    }
</style>

<main style="padding: 60px 8%;" class="fade-in">

    <div style="text-align: center; margin-bottom: 50px;">
        <span class="badge-tag">À votre écoute</span>
        <h1 style="font-family: 'Playfair Display', serif; color: var(--white); font-size: 2.8rem; margin: 10px 0;">
            Contact & Devis
        </h1>
        <p style="color: #888; max-width: 600px; margin: 0 auto; line-height: 1.6;">
            Une question sur nos menus, une demande de devis sur-mesure ou une réservation ? Julie et José vous répondent sous 24h.
        </p>
    </div>

    <div class="contact-container">

        <!-- Colonne Gauche : Coordonnées -->
        <div class="info-card">
            <div>
                <h3 style="font-family: 'Playfair Display', serif; color: var(--white); font-size: 1.5rem; margin: 0 0 10px;">
                    Vite & Gourmand
                </h3>
                <p style="color: #888; font-size: 0.95rem; line-height: 1.6; margin: 0;">
                    Artisans traiteurs depuis 25 ans à Bordeaux. Nous accompagnons tous vos événements professionnels et privés.
                </p>
            </div>

            <div class="info-item">
                <div class="info-icon"><i class="fas fa-map-marker-alt"></i></div>
                <div>
                    <strong style="color: var(--white); display: block; margin-bottom: 4px;">Adresse</strong>
                    <span style="color: #888; font-size: 0.9rem;">1 Place de la République, 33000 Bordeaux</span>
                </div>
            </div>

            <div class="info-item">
                <div class="info-icon"><i class="fas fa-phone"></i></div>
                <div>
                    <strong style="color: var(--white); display: block; margin-bottom: 4px;">Téléphone</strong>
                    <span style="color: #888; font-size: 0.9rem;">03 88 40 00 00</span>
                </div>
            </div>

            <div class="info-item">
                <div class="info-icon"><i class="fas fa-envelope"></i></div>
                <div>
                    <strong style="color: var(--white); display: block; margin-bottom: 4px;">Email</strong>
                    <a href="mailto:contact@vite-et-gourmand.fr" style="color: var(--ocre); text-decoration: none; font-size: 0.9rem;">contact@vite-et-gourmand.fr</a>
                </div>
            </div>

            <div class="info-item">
                <div class="info-icon"><i class="fas fa-clock"></i></div>
                <div>
                    <strong style="color: var(--white); display: block; margin-bottom: 4px;">Horaires d'ouverture</strong>
                    <span style="color: #888; font-size: 0.88rem; display: block;">Mardi - Samedi : 09h00 – 18h30</span>
                    <span style="color: #888; font-size: 0.88rem; display: block;">Dimanche : 09h30 – 17h45</span>
                    <span style="color: #666; font-size: 0.85rem; display: block; margin-top: 4px;">Fermé le Lundi</span>
                </div>
            </div>
        </div>

        <!-- Colonne Droite : Formulaire -->
        <div class="form-card">
            <div class="form-header">
                <h2 style="margin: 0; font-family: 'Playfair Display', serif; color: var(--white); font-size: 1.8rem;">
                    Envoyez-nous un message
                </h2>
                <p style="margin: 8px 0 0; color: #888; font-size: 0.9rem;">
                    Remplissez ce formulaire pour recevoir une réponse rapide.
                </p>
            </div>

            <form action="traitement.php" method="POST" class="form-body">
                <div class="form-group">
                    <label for="email">Votre adresse email *</label>
                    <input type="email" id="email" name="email" class="form-control" placeholder="votre.email@exemple.com" required>
                </div>

                <div class="form-group">
                    <label for="sujet">Sujet du message *</label>
                    <input type="text" id="sujet" name="sujet" class="form-control" placeholder="Résumé de votre demande" value="<?php echo $default_sujet; ?>" required>
                </div>

                <div class="form-group">
                    <label for="message">Votre message *</label>
                    <textarea id="message" name="message" class="form-control" rows="5" placeholder="Précisez le nombre de personnes, la date et vos souhaits..." required style="resize: vertical; font-family: inherit;"></textarea>
                </div>

                <div style="font-size: 0.85rem; color: #888; display: flex; align-items: flex-start; gap: 10px; margin-top: 5px;">
                    <input type="checkbox" id="cgv" required style="margin-top: 3px; accent-color: var(--ocre);">
                    <label for="cgv" style="color: #aaa; cursor: pointer; line-height: 1.4;">
                        J'accepte la politique de confidentialité et l'utilisation de mes données. *
                    </label>
                </div>

                <button type="submit" class="btn-submit">
                    Envoyer la demande
                </button>
            </form>
        </div>

    </div>

</main>

<?php require_once 'includes/footer.php'; ?>