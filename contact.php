<?php
/**
 * FICHIER : contact.php
 * ROLE : Page de contact officielle et demande de devis.
 * DESIGN : Theme sombre, ocre, angles arrondis harmonises.
 */
require_once 'includes/header.php';
?>

<main style="padding: 80px 8%; display: flex; justify-content: center;">
    <div style="background: #111; width: 100%; max-width: 600px; border-radius: 15px; border: 1px solid #222; overflow: hidden;">
        
        <div style="background: #0a0a0a; padding: 40px 30px; text-align: center; border-bottom: 1px solid #222;">
            <h2 style="margin: 0; font-family: 'Playfair Display', serif; color: var(--white); font-size: 2rem;">Contact</h2>
            <p style="margin: 15px 0 0; color: #888; font-size: 0.95rem;">Une question ou un projet ? Laissez-nous un message.</p>
        </div>

        <form action="traitement.php" method="POST" style="padding: 40px 30px; display: flex; flex-direction: column; gap: 25px;">
            <div>
                <label style="display: block; color: var(--white); margin-bottom: 8px; font-size: 0.9rem;">Adresse email</label>
                <input type="email" name="email" placeholder="votre.email@exemple.com" required style="width: 100%; padding: 12px; background: #0a0a0a; border: 1px solid #333; border-radius: 8px; color: var(--white); box-sizing: border-box;">
            </div>

            <div>
                <label style="display: block; color: var(--white); margin-bottom: 8px; font-size: 0.9rem;">Sujet du message</label>
                <input type="text" name="sujet" placeholder="Resumez votre demande" required style="width: 100%; padding: 12px; background: #0a0a0a; border: 1px solid #333; border-radius: 8px; color: var(--white); box-sizing: border-box;">
            </div>

            <div>
                <label style="display: block; color: var(--white); margin-bottom: 8px; font-size: 0.9rem;">Votre message</label>
                <textarea name="message" placeholder="Decrivez votre demande en detail..." rows="5" required style="width: 100%; padding: 12px; background: #0a0a0a; border: 1px solid #333; border-radius: 8px; color: var(--white); box-sizing: border-box; font-family: sans-serif; resize: vertical;"></textarea>
            </div>

            <div style="font-size: 0.85rem; color: #888;">
                <input type="checkbox" id="cgv" required style="margin-right: 8px; vertical-align: middle;">
                <label for="cgv" style="vertical-align: middle;">J'accepte la politique de confidentialite et les CGV *</label>
            </div>

            <button type="submit" style="background: var(--ocre); color: var(--white); padding: 15px; border: none; border-radius: 8px; font-weight: bold; cursor: pointer; font-size: 1rem; margin-top: 10px;">
                Envoyer la demande
            </button>
        </form>
    </div>
</main>

<?php require_once 'includes/footer.php'; ?>