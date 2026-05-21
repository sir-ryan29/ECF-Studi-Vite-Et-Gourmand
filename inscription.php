<?php 
// --- FICHIER : inscription.php ---
include 'header.php'; 
?>

<div style="display: flex; justify-content: center; padding: 50px;">
    <form action="traitement_inscription.php" method="POST" style="background: white; padding: 40px; border-radius: 20px; width: 400px; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
        <h2 style="margin-bottom: 20px; text-align: center;">Inscription</h2>
        
        <input type="text" name="nom" placeholder="Nom" style="width: 100%; padding: 10px; margin: 8px 0; border: 1px solid #ddd; border-radius: 5px;" required>
        <input type="text" name="prenom" placeholder="Prénom" style="width: 100%; padding: 10px; margin: 8px 0; border: 1px solid #ddd; border-radius: 5px;" required>
        <input type="email" name="email" placeholder="Email" style="width: 100%; padding: 10px; margin: 8px 0; border: 1px solid #ddd; border-radius: 5px;" required>
        <input type="text" name="telephone" placeholder="Téléphone" style="width: 100%; padding: 10px; margin: 8px 0; border: 1px solid #ddd; border-radius: 5px;" required>
        <input type="text" name="adresse_postale" placeholder="Adresse postale" style="width: 100%; padding: 10px; margin: 8px 0; border: 1px solid #ddd; border-radius: 5px;" required>
        <input type="password" name="password" placeholder="Mot de passe" style="width: 100%; padding: 10px; margin: 8px 0; border: 1px solid #ddd; border-radius: 5px;" required>
        
        <button type="submit" class="btn-orange" style="width: 100%; padding: 12px; margin-top: 20px; border: none; border-radius: 5px; cursor: pointer; color: white; background: #E85412; font-weight: bold;">
            Créer mon compte
        </button>
    </form>
</div>

<?php include 'footer.php'; ?>