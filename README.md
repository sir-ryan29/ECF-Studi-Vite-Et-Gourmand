
# Vite & Gourmand

Projet d'Évaluation en Cours de Formation (ECF) — Plateforme de gestion de commandes pour traiteur.

## 📝 Présentation
"Vite & Gourmand" est une application web conçue pour faciliter la commande de menus gastronomiques. Elle permet aux clients de consulter une carte dynamique et de réserver des menus en fonction de leurs besoins spécifiques.

## 🚀 Fonctionnalités
* **Catalogue dynamique :** Affichage des menus depuis la base de données.
* **Authentification sécurisée :** Gestion des sessions et hachage des mots de passe.
* **Système de commande :** Formulaire de réservation lié à l'espace client.
* **Espace Client :** Suivi personnalisé de l'historique des commandes.
* **Interface responsive :** Design moderne et cohérent basé sur une charte graphique définie.

## 🛠️ Technologies
* **Front-end :** HTML5, CSS3 (Charte graphique personnalisée).
* **Back-end :** PHP 8 avec architecture MVC simplifiée.
* **Base de données :** Système hybride MySQL / SQLite (avec initialisation automatique du schéma).
* **Sécurité :** Requêtes préparées PDO contre les injections SQL et protection XSS.

## 💡 Installation
1. Cloner le projet.
2. S'assurer que le serveur local supporte PHP et PDO.
3. Lancer le projet : Le système initialise automatiquement la base de données (via `db.php`) si celle-ci est absente.
4. Accéder à l'application via votre navigateur.