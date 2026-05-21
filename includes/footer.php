<?php
/**
 * FICHIER : includes/footer.php
 * ROLE : Pied de page standard, unifié avec logo officiel.
 * DESIGN : Palette respectée (Ocre/Sombre), intégration FontAwesome.
 */
?>
</main>

<footer style="background: #050505; color: #fff; padding: 40px 8%; margin-top: 50px; border-top: 2px solid var(--ocre);">
    
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 40px; text-align: center; margin-bottom: 40px;">
        
        <div>
            <h3 style="color: var(--ocre); margin-bottom: 15px; font-family: 'Playfair Display', serif;">Horaires</h3>
            <p style="margin: 5px 0; color: #888;"><strong>Lundi :</strong> Fermé</p>
            <p style="margin: 5px 0; color: #888;"><strong>Mardi - Samedi :</strong> 09h00 – 18h30</p>
            <p style="margin: 5px 0; color: #888;"><strong>Dimanche :</strong> 09h30 – 17h45</p>
        </div>

        <div>
            <h3 style="color: var(--ocre); margin-bottom: 15px; font-family: 'Playfair Display', serif;">Contacts</h3>
            <p style="margin: 5px 0; color: #888;">
                <i class="fas fa-envelope" style="color: var(--ocre); margin-right: 5px;"></i> 
                <a href="mailto:contact@vite-et-gourmand.fr" style="color: #888; text-decoration: none;" onmouseover="this.style.color='var(--ocre)'" onmouseout="this.style.color='#888'">contact@vite-et-gourmand.fr</a>
            </p>
            <p style="margin: 5px 0; color: #888;">
                <i class="fas fa-phone" style="color: var(--ocre); margin-right: 5px;"></i> 03 88 40 00 00
            </p>
            <p style="margin: 5px 0; color: #888;">
                <i class="fas fa-map-marker-alt" style="color: var(--ocre); margin-right: 5px;"></i> 1 Place de la République, 33000 Bordeaux
            </p>
        </div>
    </div>

    <div style="text-align: center; border-top: 1px solid #161616; padding-top: 30px; display: flex; flex-direction: column; align-items: center; gap: 12px;">
        <img src="assets/img/logo.png" alt="Logo Pied de Page" style="height: 45px; width: auto; display: block;">
        
        <p style="margin: 5px 0; color: #444; font-size: 0.9rem;">
            &copy; <?php echo date('Y'); ?> Vite & Gourmand - Tous droits réservés.
        </p>
        
        <div style="margin-top: 5px;">
            <a href="mentions.php" style="color: var(--ocre); font-size: 0.85rem; margin: 0 10px; text-decoration: none;" onmouseover="this.style.color='var(--white)'" onmouseout="this.style.color='var(--ocre)'">Mentions légales</a>
            <a href="cgv.php" style="color: var(--ocre); font-size: 0.85rem; margin: 0 10px; text-decoration: none;" onmouseover="this.style.color='var(--white)'" onmouseout="this.style.color='var(--ocre)'">CGV</a>
        </div>
    </div>
</footer>

</body>
</html>