-- Pêche Marine TN — MySQL Schema
-- Execute this in phpMyAdmin or MySQL CLI

CREATE DATABASE IF NOT EXISTS peche_marine
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE peche_marine;

-- ══════════════════════════════════════════════
-- TABLES
-- ══════════════════════════════════════════════

CREATE TABLE IF NOT EXISTS utilisateur (
    id           INT AUTO_INCREMENT PRIMARY KEY,
    nom          VARCHAR(100) NOT NULL,
    prenom       VARCHAR(100) NOT NULL,
    email        VARCHAR(255) NOT NULL UNIQUE,
    mot_de_passe VARCHAR(255) NOT NULL,
    telephone    VARCHAR(20),
    adresse      TEXT,
    avatar       VARCHAR(255),
    role         ENUM('client','admin') NOT NULL DEFAULT 'client',
    created_at   DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS categorie (
    id          INT AUTO_INCREMENT PRIMARY KEY,
    nom         VARCHAR(100) NOT NULL,
    description TEXT,
    image       VARCHAR(255)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS produit (
    id             INT AUTO_INCREMENT PRIMARY KEY,
    nom            VARCHAR(255) NOT NULL,
    description    TEXT,
    prix           DECIMAL(10,2) NOT NULL,
    quantite_stock INT NOT NULL DEFAULT 0,
    image          VARCHAR(255),
    categorie_id   INT,
    created_at     DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (categorie_id) REFERENCES categorie(id) ON DELETE SET NULL
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS panier (
    id             INT AUTO_INCREMENT PRIMARY KEY,
    utilisateur_id INT NOT NULL UNIQUE,
    FOREIGN KEY (utilisateur_id) REFERENCES utilisateur(id) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS ligne_panier (
    id         INT AUTO_INCREMENT PRIMARY KEY,
    panier_id  INT NOT NULL,
    produit_id INT NOT NULL,
    quantite   INT NOT NULL DEFAULT 1,
    FOREIGN KEY (panier_id) REFERENCES panier(id) ON DELETE CASCADE,
    FOREIGN KEY (produit_id) REFERENCES produit(id) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS commande (
    id                INT AUTO_INCREMENT PRIMARY KEY,
    utilisateur_id    INT NOT NULL,
    date_commande     DATETIME DEFAULT CURRENT_TIMESTAMP,
    statut            ENUM('en_attente','confirmee','expediee','livree','annulee') NOT NULL DEFAULT 'en_attente',
    total             DECIMAL(10,2) NOT NULL,
    adresse_livraison TEXT,
    telephone         VARCHAR(20),
    FOREIGN KEY (utilisateur_id) REFERENCES utilisateur(id) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS ligne_commande (
    id            INT AUTO_INCREMENT PRIMARY KEY,
    commande_id   INT NOT NULL,
    produit_id    INT NOT NULL,
    quantite      INT NOT NULL,
    prix_unitaire DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (commande_id) REFERENCES commande(id) ON DELETE CASCADE,
    FOREIGN KEY (produit_id) REFERENCES produit(id) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS contact (
    id         INT AUTO_INCREMENT PRIMARY KEY,
    nom        VARCHAR(100) NOT NULL,
    email      VARCHAR(255) NOT NULL,
    sujet      VARCHAR(255) NOT NULL,
    message    TEXT NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS avis (
    id             INT AUTO_INCREMENT PRIMARY KEY,
    utilisateur_id INT NOT NULL,
    produit_id     INT NOT NULL,
    note           TINYINT NOT NULL CHECK(note BETWEEN 1 AND 5),
    commentaire    TEXT,
    created_at     DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (utilisateur_id) REFERENCES utilisateur(id) ON DELETE CASCADE,
    FOREIGN KEY (produit_id) REFERENCES produit(id) ON DELETE CASCADE,
    UNIQUE KEY unique_avis (utilisateur_id, produit_id)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS favori (
    id             INT AUTO_INCREMENT PRIMARY KEY,
    utilisateur_id INT NOT NULL,
    produit_id     INT NOT NULL,
    created_at     DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (utilisateur_id) REFERENCES utilisateur(id) ON DELETE CASCADE,
    FOREIGN KEY (produit_id) REFERENCES produit(id) ON DELETE CASCADE,
    UNIQUE KEY unique_favori (utilisateur_id, produit_id)
) ENGINE=InnoDB;
