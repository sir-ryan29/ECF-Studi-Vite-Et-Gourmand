<?php include 'header.php'; ?>
  <div style="display: flex; justify-content: center; padding: 50px;">
    <form action="traitement_connexion.php" method="POST" style="background: white; padding: 40px; border-radius: 20px; width: 400px;">
      <h2>Connexion</h2>
      <input type="email" name="email" placeholder="Email" style="width: 100%; padding: 10px; margin: 10px 0;">
      <input type="password" name="password" placeholder="Mot de passe" style="width: 100%; padding: 10px; margin: 10px 0;">
      <button type="submit" class="btn-orange">Se connecter</button>
    </form>
  </div>
<?php include 'footer.php'; ?>