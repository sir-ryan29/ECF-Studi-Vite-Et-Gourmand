<?php
/**
 * FICHIER : offres.php
 * ROLE : Présentation des packs événementiels et entreprises.
 * DESIGN : Intégration du style "Béton" (Grille, Dark theme, Ocre).
 */
require_once 'includes/header.php';
?>

<main style="padding: 50px 8%;">
    <h1 style="text-align: center; color: var(--ocre); font-family: 'Playfair Display', serif; margin-bottom: 50px;">Nos Offres & Packs Traiteur</h1>

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(350px, 1fr)); gap: 30px;">
        
        <div style="background: #111; border: 1px solid #333; padding: 30px; border-radius: 20px; display: flex; flex-direction: column;">
            <h3 style="color: var(--white); font-size: 1.5rem; margin-top: 0;">Pack Réception Privée</h3>
            <p style="color: #ccc; margin-bottom: 20px;">Idéal pour les mariages, baptêmes ou anniversaires. Service complet inclus.</p>
            <ul style="color: #aaa; padding-left: 20px; flex-grow: 1; line-height: 2;">
                <li>Apéritif dînatoire</li>
                <li>Menu 3 services</li>
                <li>Service en salle</li>
            </ul>
            <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 30px; border-top: 1px solid #333; padding-top: 20px;">
                <span style="font-weight: bold; color: var(--white);">Dès 65 € / pers.</span>
                <a href="contact.php" style="background: var(--ocre); color: white; padding: 10px 20px; border-radius: 5px; text-decoration: none; font-weight: bold;">Devis</a>
            </div>
        </div>

        <div style="background: #111; border: 1px solid #333; padding: 30px; border-radius: 20px; display: flex; flex-direction: column;">
            <h3 style="color: var(--white); font-size: 1.5rem; margin-top: 0;">Offre Corporate</h3>
            <p style="color: #ccc; margin-bottom: 20px;">Pour vos séminaires, réunions ou déjeuners d'affaires. Efficacité et goût.</p>
            <ul style="color: #aaa; padding-left: 20px; flex-grow: 1; line-height: 2;">
                <li>Plateaux repas premium</li>
                <li>Pause café gourmande</li>
                <li>Livraison incluse</li>
            </ul>
            <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 30px; border-top: 1px solid #333; padding-top: 20px;">
                <span style="font-weight: bold; color: var(--white);">Dès 35 € / pers.</span>
                <a href="contact.php" style="background: var(--ocre); color: white; padding: 10px 20px; border-radius: 5px; text-decoration: none; font-weight: bold;">Devis</a>
            </div>
        </div>
        
    </div>
</main>

<?php require_once 'includes/footer.php'; ?>