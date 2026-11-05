<?php
/**
 * FICHIER : traitement_commande.php
 * ROLE : Traitement du formulaire de commande et enregistrement sécurisé en base de données.
 * CONTEXTE : Evaluation DWWM - Vite & Gourmand
 */

// Initialisation de la session utilisateur
session_start();

// Connexion à la base de données via le dossier centralisé includes
if (file_exists('includes/db.php')) {
    require_once 'includes/db.php';
} else {
    require_once 'db.php';
}

// 1. Contrôle de sécurité : Vérification de la connexion de l'utilisateur
if (!isset($_SESSION['user_id'])) {
    header("Location: connexion.php");
    exit();
}

// 2. Traitement uniquement si la requête est transmise via la méthode POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Récupération, nettoyage et typage des données envoyées par le formulaire
    $id_menu         = isset($_POST['id_menu']) ? intval($_POST['id_menu']) : 0;
    $date_livraison  = isset($_POST['date_livraison']) ? trim(htmlspecialchars($_POST['date_livraison'])) : '';
    $nb_personnes    = isset($_POST['nb_personnes']) ? intval($_POST['nb_personnes']) : 0;
    $lieu_livraison  = isset($_POST['lieu_livraison']) ? trim(htmlspecialchars($_POST['lieu_livraison'])) : '';
    $heure_livraison = isset($_POST['heure_livraison']) ? trim(htmlspecialchars($_POST['heure_livraison'])) : '12:00:00';
    $id_client       = $_SESSION['user_id'];

    // 3. Validation de l'intégrité des champs obligatoires
    if ($id_menu <= 0 || empty($date_livraison) || $nb_personnes <= 0 || empty($lieu_livraison)) {
        header("Location: commande.php?id=" . $id_menu . "&error=empty");
        exit();
    }

    if ($pdo) {
        try {
            // 4. Récupération du prix par personne du menu sélectionné pour le calcul du montant total
            $stmt_menu = $pdo->prepare("SELECT prix_par_personne_min FROM menu WHERE id = :id");
            $stmt_menu->execute(['id' => $id_menu]);
            $menu = $stmt_menu->fetch(PDO::FETCH_ASSOC);

            if (!$menu) {
                header("Location: menus.php");
                exit();
            }

            // 5. Calculs des montants et définition de la date de la commande
            $prix_unitaire  = floatval($menu['prix_par_personne_min']);
            $prix_menu      = $prix_unitaire * $nb_personnes;
            $prix_livraison = 0.00; // Frais de livraison offerts ou inclus
            $date_commande  = date('Y-m-d');

            // 6. Requête préparée pour l'insertion de la commande (sécurisée contre les injections SQL)
            $sql = "INSERT INTO commande (
                        id_client, 
                        id_menu, 
                        statut_commande, 
                        date_commande, 
                        date_livraison, 
                        heure_livraison, 
                        lieu_livraison, 
                        nb_personnes, 
                        prix_menu, 
                        prix_livraison
                    ) VALUES (
                        :id_client, 
                        :id_menu, 
                        'en attente', 
                        :date_commande, 
                        :date_livraison, 
                        :heure_livraison, 
                        :lieu_livraison, 
                        :nb_personnes, 
                        :prix_menu, 
                        :prix_livraison
                    )";
            
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                'id_client'       => $id_client,
                'id_menu'         => $id_menu,
                'date_commande'    => $date_commande,
                'date_livraison'  => $date_livraison,
                'heure_livraison' => $heure_livraison,
                'lieu_livraison'  => $lieu_livraison,
                'nb_personnes'    => $nb_personnes,
                'prix_menu'       => $prix_menu,
                'prix_livraison'  => $prix_livraison
            ]);

            // 7. Redirection avec confirmation de succès vers l'espace client
            header("Location: espace_client.php?success=1");
            exit();

        } catch (PDOException $e) {
            // Gestion propre des erreurs de base de données
            header("Location: commande.php?id=" . $id_menu . "&error=db");
            exit();
        }
    } else {
        header("Location: commande.php?id=" . $id_menu . "&error=db");
        exit();
    }

} else {
    // Redirection de sécurité si le fichier est accédé directement hors formulaire POST
    header("Location: menus.php");
    exit();
}