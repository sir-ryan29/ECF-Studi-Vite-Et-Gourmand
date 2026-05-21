<?php 
// Inclusion du header pour la navigation et le logo
include 'header.php'; 
?>

<div style="display: flex; justify-content: center; padding: 50px;">
    <form action="traitement_connexion.php" method="POST" style="background: #f9f9f9; padding: 40px; border-radius: 20px; width: 400px; box-shadow: 0 4px 8px rgba(0,0,0,0.1);">
        <h2 style="text-align: center;">Connexion</h2>
        
        <input type="email" name="email" placeholder="Email" required style="width: 100%; padding: 10px; margin: 10px 0; border: 1px solid #ccc; border-radius: 5px;">
        
        <input type="password" name="password" placeholder="Mot de passe" required style="width: 100%; padding: 10px; margin: 10px 0; border: 1px solid #ccc; border-radius: 5px;">
        
        <button type="submit" class="btn-orange" style="width: 100%; padding: 10px; border: none; border-radius: 5px; cursor: pointer;">
            Se connecter
        </button>
    </form>
</div>

<?php 
// Inclusion du footer
include 'footer.php'; 
?>