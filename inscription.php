<?php include 'header.php'; ?>
  <div style="display: flex; justify-content: center; padding: 50px;">
    <form action="traitement_inscription.php" method="POST" style="background: white; padding: 40px; border-radius: 20px; width: 400px;">
      <h2>Inscription</h2>
      <input type="text" name="nom" placeholder="Nom" style="width: 100%; padding: 10px; margin: 5px 0;">
      <input type="email" name="email" placeholder="Email" style="width: 100%; padding: 10px; margin: 5px 0;">
      <input type="password" name="password" placeholder="Mot de passe" style="width: 100%; padding: 10px; margin: 5px 0;">
      <button type="submit" class="btn-orange">Créer mon compte</button>
    </form>
  </div>
<?php include 'footer.php'; ?>