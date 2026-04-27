-- Pêche Marine TN — Database Schema

CREATE TABLE IF NOT EXISTS utilisateur (
    id           INTEGER PRIMARY KEY AUTOINCREMENT,
    nom          TEXT NOT NULL,
    prenom       TEXT NOT NULL,
    email        TEXT NOT NULL UNIQUE,
    mot_de_passe TEXT NOT NULL,
    telephone    TEXT,
    adresse      TEXT,
    avatar       TEXT,
    role         TEXT NOT NULL DEFAULT 'client' CHECK(role IN ('client','admin')),
    created_at   DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS categorie (
    id          INTEGER PRIMARY KEY AUTOINCREMENT,
    nom         TEXT NOT NULL,
    description TEXT,
    image       TEXT
);

CREATE TABLE IF NOT EXISTS produit (
    id             INTEGER PRIMARY KEY AUTOINCREMENT,
    nom            TEXT NOT NULL,
    description    TEXT,
    prix           REAL NOT NULL,
    quantite_stock INTEGER NOT NULL DEFAULT 0,
    image          TEXT,
    categorie_id   INTEGER,
    created_at     DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (categorie_id) REFERENCES categorie(id)
);

CREATE TABLE IF NOT EXISTS panier (
    id             INTEGER PRIMARY KEY AUTOINCREMENT,
    utilisateur_id INTEGER NOT NULL UNIQUE,
    FOREIGN KEY (utilisateur_id) REFERENCES utilisateur(id)
);

CREATE TABLE IF NOT EXISTS ligne_panier (
    id         INTEGER PRIMARY KEY AUTOINCREMENT,
    panier_id  INTEGER NOT NULL,
    produit_id INTEGER NOT NULL,
    quantite   INTEGER NOT NULL DEFAULT 1,
    FOREIGN KEY (panier_id) REFERENCES panier(id) ON DELETE CASCADE,
    FOREIGN KEY (produit_id) REFERENCES produit(id)
);

CREATE TABLE IF NOT EXISTS commande (
    id                INTEGER PRIMARY KEY AUTOINCREMENT,
    utilisateur_id    INTEGER NOT NULL,
    date_commande     DATETIME DEFAULT CURRENT_TIMESTAMP,
    statut            TEXT NOT NULL DEFAULT 'en_attente'
                      CHECK(statut IN ('en_attente','confirmee','expediee','livree','annulee')),
    total             REAL NOT NULL,
    adresse_livraison TEXT,
    telephone         TEXT,
    FOREIGN KEY (utilisateur_id) REFERENCES utilisateur(id)
);

CREATE TABLE IF NOT EXISTS ligne_commande (
    id            INTEGER PRIMARY KEY AUTOINCREMENT,
    commande_id   INTEGER NOT NULL,
    produit_id    INTEGER NOT NULL,
    quantite      INTEGER NOT NULL,
    prix_unitaire REAL NOT NULL,
    FOREIGN KEY (commande_id) REFERENCES commande(id) ON DELETE CASCADE,
    FOREIGN KEY (produit_id) REFERENCES produit(id)
);

CREATE TABLE IF NOT EXISTS contact (
    id         INTEGER PRIMARY KEY AUTOINCREMENT,
    nom        TEXT NOT NULL,
    email      TEXT NOT NULL,
    sujet      TEXT NOT NULL,
    message    TEXT NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);
