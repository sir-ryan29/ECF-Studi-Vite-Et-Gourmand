-- Création de la base de données pour Vite & Gourmand
CREATE DATABASE IF NOT EXISTS vite_et_gourmand;
USE vite_et_gourmand;

-- Table des rôles (pour différencier client, employé, admin)
CREATE TABLE IF NOT EXISTS roles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom_role VARCHAR(50) NOT NULL
);

-- Table des utilisateurs 
CREATE TABLE IF NOT EXISTS utilisateur (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(50) NOT NULL,
    prenom VARCHAR(50) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    telephone VARCHAR(20) NOT NULL,
    adresse_postale VARCHAR(255) NOT NULL,
    id_role INT DEFAULT 1,
    date_creation TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_role) REFERENCES roles(id)
);

-- Table pour les thèmes des menus (Noël, Pâques...)
CREATE TABLE IF NOT EXISTS theme (
    id INT AUTO_INCREMENT PRIMARY KEY,
    libelle VARCHAR(50) NOT NULL
);

-- Table pour les régimes (végétarien, classique...)
CREATE TABLE IF NOT EXISTS regime (
    id INT AUTO_INCREMENT PRIMARY KEY,
    libelle VARCHAR(50) NOT NULL
);

-- Table des menus
CREATE TABLE IF NOT EXISTS menu (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titre VARCHAR(100) NOT NULL,
    description TEXT NOT NULL,
    nb_personne_min INT NOT NULL,
    prix_par_personne_min DOUBLE NOT NULL,
    stock_disponible INT NOT NULL,
    id_theme INT,
    id_regime INT,
    FOREIGN KEY (id_theme) REFERENCES theme(id),
    FOREIGN KEY (id_regime) REFERENCES regime(id)
);

-- Table des plats
CREATE TABLE IF NOT EXISTS plat (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom_plat VARCHAR(100) NOT NULL,
    type_plat VARCHAR(50) NOT NULL,
    image_blob BLOB
);

-- Table pour lier les menus et les plats
CREATE TABLE IF NOT EXISTS menu_plat (
    id_menu INT,
    id_plat INT,
    PRIMARY KEY (id_menu, id_plat),
    FOREIGN KEY (id_menu) REFERENCES menu(id),
    FOREIGN KEY (id_plat) REFERENCES plat(id)
);

-- Table des allergènes
CREATE TABLE IF NOT EXISTS allergene (
    id INT AUTO_INCREMENT PRIMARY KEY,
    libelle VARCHAR(50) NOT NULL
);

-- Table pour lier les plats et les allergènes
CREATE TABLE IF NOT EXISTS plat_allergene (
    id_plat INT,
    id_allergene INT,
    PRIMARY KEY (id_plat, id_allergene),
    FOREIGN KEY (id_plat) REFERENCES plat(id),
    FOREIGN KEY (id_allergene) REFERENCES allergene(id)
);

-- Table des horaires
CREATE TABLE IF NOT EXISTS horaires (
    id INT AUTO_INCREMENT PRIMARY KEY,
    jour VARCHAR(20) NOT NULL,
    heure_ouverture VARCHAR(20) NOT NULL,
    heure_fermeture VARCHAR(20) NOT NULL
);

-- Table des commandes
CREATE TABLE IF NOT EXISTS commande (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_client INT,
    id_menu INT,
    statut_commande VARCHAR(50) DEFAULT 'en attente',
    date_commande DATE NOT NULL,
    date_livraison DATE NOT NULL,
    heure_livraison TIME NOT NULL,
    lieu_livraison VARCHAR(255) NOT NULL,
    nb_personnes INT NOT NULL,
    prix_menu DOUBLE NOT NULL,
    prix_livraison DOUBLE NOT NULL,
    pret_materiel BOOLEAN DEFAULT FALSE,
    restitue_materiel BOOLEAN DEFAULT FALSE,
    FOREIGN KEY (id_client) REFERENCES utilisateur(id),
    FOREIGN KEY (id_menu) REFERENCES menu(id)
);

-- Table des avis
CREATE TABLE IF NOT EXISTS avis (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_commande INT,
    note INT,
    commentaire TEXT NOT NULL,
    statut VARCHAR(30) DEFAULT 'en attente',
    FOREIGN KEY (id_commande) REFERENCES commande(id)
);