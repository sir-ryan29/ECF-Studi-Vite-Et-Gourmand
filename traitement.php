<?php
/**
 * FICHIER : traitement.php
 * ROLE : Confirmation de réception de devis avec design harmonisé.
 */
require_once 'includes/header.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = htmlspecialchars($_POST['nom']);
    $email = htmlspecialchars($_POST['email']);
} else {
    header("Location: index.php");
    exit();
}
?>

<main style="padding: 100px 8%; text-align: center;">
    <div style="background: #111; border: 1px solid #333; padding: 50px; border-radius: 40px; max-width: 600px; margin: 0 auto;">
        <h1 style="color: var(--ocre); font-family: 'Playfair Display', serif;">Merci <?php echo $nom; ?>,</h1>
        <p style="color: var(--white); font-size: 1.2rem; margin-bottom: 30px;">
            Votre demande de devis a bien été reçue. Nous reviendrons vers vous très rapidement à l'adresse : 
            <br><strong style="color: var(--ocre);"><?php echo $email; ?></strong>
        </p>
        <a href="index.php" class="btn-details">Retour à l'accueil</a>
    </div>
</main>

<?php require_once 'includes/footer.php'; ?>