<?php
/**
 * FICHIER : offres.php
 * ROLE : Présentation des offres sur-mesure et packs événementiels (Privé, Corporate, Cocktails).
 * DESIGN : Thème sombre, cartes interactives avec effet hover, accents ocres et animations CSS fluides.
 * COMMENTAIRE EXAMEN : Page d'exposition des prestations traiteur avec grille responsive et redirections vers contact.php.
 */
require_once 'includes/header.php';
?>

<!-- ==========================================================================
     STYLES SPECIFIQUES ET ANIMATIONS CSS
     ========================================================================== -->
<style>
    /* Animation d'apparition au chargement de la page */
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

    /* Badges promotionnels et thématiques */
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

    /* Grille responsive pour l'alignement des cartes d'offres */
    .offres-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
        gap: 30px;
        max-width: 1200px;
        margin: 0 auto;
    }

    /* Structure des cartes d'offres */
    .offre-card {
        background: #111;
        border: 1px solid #222;
        border-radius: 16px;
        padding: 35px 30px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
        position: relative;
    }

    /* Effet d'élévation et bordure ocre au survol */
    .offre-card:hover {
        transform: translateY(-8px);
        border-color: var(--ocre);
        box-shadow: 0 12px 30px rgba(217, 119, 6, 0.2);
    }

    /* Highlight pour l'offre mise en avant */
    .offre-card.highlight {
        border-color: rgba(217, 119, 6, 0.6);
        background: linear-gradient(180deg, #16120b 0%, #111 100%);
    }

    .popular-badge {
        position: absolute;
        top: 20px;
        right: 20px;
        background: var(--ocre);
        color: var(--white);
        font-size: 0.75rem;
        font-weight: bold;
        padding: 4px 10px;
        border-radius: 6px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    /* Animation sur les icônes FontAwesome au survol */
    .offre-icon {
        font-size: 2.2rem;
        color: var(--ocre);
        margin-bottom: 20px;
        transition: transform 0.3s ease;
    }

    .offre-card:hover .offre-icon {
        transform: scale(1.15) rotate(4deg);
    }

    /* Liste stylisée des prestations avec puces personnalisées */
    .offre-list {
        list-style: none;
        padding: 0;
        margin: 20px 0 30px;
        flex-grow: 1;
    }

    .offre-list li {
        color: #aaa;
        padding: 10px 0;
        display: flex;
        align-items: center;
        gap: 12px;
        font-size: 0.95rem;
        border-bottom: 1px solid #1a1a1a;
    }

    .offre-list li:last-child {
        border-bottom: none;
    }

    .offre-list li i {
        color: var(--ocre);
        font-size: 0.85rem;
    }

    /* Bouton d'action Devis personnalisé */
    .btn-devis {
        background: var(--ocre);
        color: var(--white);
        padding: 12px 24px;
        border-radius: 8px;
        font-weight: bold;
        text-decoration: none;
        display: inline-block;
        transition: all 0.3s ease;
        text-align: center;
        box-shadow: 0 4px 12px rgba(217, 119, 6, 0.25);
    }

    .btn-devis:hover {
        background: #e68208;
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(217, 119, 6, 0.4);
    }

    /* Bloc de réassurance bas de page */
    .reassurance-block {
        background: #0d0d0d;
        border: 1px solid #222;
        border-radius: 16px;
        padding: 40px;
        max-width: 1200px;
        margin: 60px auto 0;
        text-align: center;
    }
</style>

<main style="padding: 60px 8%;" class="fade-in">

    <!-- En-tête de section -->
    <div style="text-align: center; margin-bottom: 50px;">
        <span class="badge-tag">Formules & Sur-Mesure</span>
        <h1 style="font-family: 'Playfair Display', serif; color: var(--white); font-size: 2.8rem; margin: 10px 0;">
            Nos Offres & Packs Traiteur
        </h1>
        <p style="color: #888; max-width: 650px; margin: 0 auto; line-height: 1.6;">
            Que ce soit pour une célébration privée ou un événement professionnel, Julie et José conçoivent des prestations adaptées à vos besoins sur Bordeaux et sa région.
        </p>
    </div>

    <!-- Grille des Offres -->
    <div class="offres-grid">

        <!-- Offre 1 : Réception Privée -->
        <div class="offre-card">
            <div>
                <i class="fas fa-glass-cheers offre-icon"></i>
                <h3 style="color: var(--white); font-family: 'Playfair Display', serif; font-size: 1.6rem; margin: 0 0 10px;">
                    Réception Privée
                </h3>
                <p style="color: #888; font-size: 0.95rem; line-height: 1.5; margin: 0;">
                    Idéal pour mariages, baptêmes et anniversaires. Une prise en charge complète pour profiter pleinement de vos invités.
                </p>

                <!-- Liste des prestations incluses -->
                <ul class="offre-list">
                    <li><i class="fas fa-check"></i> Apéritif dînatoire et pièces cocktail</li>
                    <li><i class="fas fa-check"></i> Menu gastronomique 3 services</li>
                    <li><i class="fas fa-check"></i> Service attentionné en salle</li>
                    <li><i class="fas fa-check"></i> Options pièces montées & desserts</li>
                </ul>
            </div>

            <!-- Tarif et lien vers devis -->
            <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 20px; border-top: 1px solid #222; padding-top: 20px;">
                <div>
                    <span style="font-size: 0.8rem; color: #666; display: block;">À partir de</span>
                    <span style="font-weight: bold; color: var(--ocre); font-size: 1.3rem;">65 € <span style="font-size: 0.85rem; color: #888; font-weight: normal;">/ pers.</span></span>
                </div>
                <a href="contact.php?offre=prive" class="btn-devis">Demander un devis</a>
            </div>
        </div>

        <!-- Offre 2 : Corporate (Mise en avant) -->
        <div class="offre-card highlight">
            <span class="popular-badge">Populaire</span>
            <div>
                <i class="fas fa-briefcase offre-icon"></i>
                <h3 style="color: var(--white); font-family: 'Playfair Display', serif; font-size: 1.6rem; margin: 0 0 10px;">
                    Offre Corporate
                </h3>
                <p style="color: #888; font-size: 0.95rem; line-height: 1.5; margin: 0;">
                    Pensée pour les séminaires, réunions de direction et déjeuners d'affaires. Efficacité, ponctualité et fraîcheur.
                </p>

                <!-- Liste des prestations incluses -->
                <ul class="offre-list">
                    <li><i class="fas fa-check"></i> Plateaux repas premium de saison</li>
                    <li><i class="fas fa-check"></i> Pause café gourmande & viennoiseries</li>
                    <li><i class="fas fa-check"></i> Matériel de service éco-responsable</li>
                    <li><i class="fas fa-check"></i> Livraison garantie sur site à Bordeaux</li>
                </ul>
            </div>

            <!-- Tarif et lien vers devis -->
            <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 20px; border-top: 1px solid #222; padding-top: 20px;">
                <div>
                    <span style="font-size: 0.8rem; color: #666; display: block;">À partir de</span>
                    <span style="font-weight: bold; color: var(--ocre); font-size: 1.3rem;">35 € <span style="font-size: 0.85rem; color: #888; font-weight: normal;">/ pers.</span></span>
                </div>
                <a href="contact.php?offre=corporate" class="btn-devis">Demander un devis</a>
            </div>
        </div>

        <!-- Offre 3 : Buffet & Cocktail Cocktail -->
        <div class="offre-card">
            <div>
                <i class="fas fa-utensils offre-icon"></i>
                <h3 style="color: var(--white); font-family: 'Playfair Display', serif; font-size: 1.6rem; margin: 0 0 10px;">
                    Cocktail & Buffet Signature
                </h3>
                <p style="color: #888; font-size: 0.95rem; line-height: 1.5; margin: 0;">
                    Une formule conviviale et raffinée déclinée en pièces salées et sucrées, idéale pour les vernissages et inaugurations.
                </p>

                <!-- Liste des prestations incluses -->
                <ul class="offre-list">
                    <li><i class="fas fa-check"></i> Assortiment de 12 à 18 pièces / pers.</li>
                    <li><i class="fas fa-check"></i> Animations culinaires (Bar à huîtres...)</li>
                    <li><i class="fas fa-check"></i> Boissons fraîches & sélection de vins</li>
                    <li><i class="fas fa-check"></i> Installation et scénographie du buffet</li>
                </ul>
            </div>

            <!-- Tarif et lien vers devis -->
            <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 20px; border-top: 1px solid #222; padding-top: 20px;">
                <div>
                    <span style="font-size: 0.8rem; color: #666; display: block;">À partir de</span>
                    <span style="font-weight: bold; color: var(--ocre); font-size: 1.3rem;">45 € <span style="font-size: 0.85rem; color: #888; font-weight: normal;">/ pers.</span></span>
                </div>
                <a href="contact.php?offre=cocktail" class="btn-devis">Demander un devis</a>
            </div>
        </div>

    </div>

    <!-- Section d'informations et réassurance -->
    <div class="reassurance-block">
        <h2 style="font-family: 'Playfair Display', serif; color: var(--white); font-size: 1.8rem; margin: 0 0 15px;">
            Besoin d'une formule sur-mesure ?
        </h2>
        <p style="color: #888; max-width: 700px; margin: 0 auto 25px; line-height: 1.6;">
            Chaque événement est unique. Contactez-nous pour adapter les régimes alimentaires (végétarien, sans gluten, halal) ou demander une proposition 100 % personnalisée.
        </p>
        <a href="contact.php" style="display: inline-block; border: 1px solid var(--ocre); color: var(--ocre); padding: 12px 28px; border-radius: 8px; font-weight: bold; text-decoration: none; transition: all 0.3s ease;" onmouseover="this.style.background='var(--ocre)'; this.style.color='#fff';" onmouseout="this.style.background='transparent'; this.style.color='var(--ocre)';">
            Contacter nos chefs traiteurs
        </a>
    </div>

</main>

<?php require_once 'includes/footer.php'; ?>