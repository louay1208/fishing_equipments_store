# 🎣 Pêche Marine TN — E-commerce de Matériel de Pêche

Plateforme e-commerce de vente de matériel de pêche en Tunisie, développée en PHP (MVC), HTML, CSS (Bootstrap 5), JavaScript et SQLite.

![PHP](https://img.shields.io/badge/PHP-8.0+-blue?logo=php)
![SQLite](https://img.shields.io/badge/SQLite-3-green?logo=sqlite)
![Bootstrap](https://img.shields.io/badge/Bootstrap-5.3-purple?logo=bootstrap)
![License](https://img.shields.io/badge/License-MIT-yellow)

---

## 📸 Aperçu

| Accueil | Catalogue | Détail Produit |
|---------|-----------|----------------|
| Page d'accueil avec héro, catégories et produits en vedette | Catalogue avec filtres, recherche et tri | Fiche produit avec description et produits similaires |

---

## ✨ Fonctionnalités

### Client
- 🔐 Inscription et connexion sécurisées
- 🛍️ Catalogue produits avec recherche, filtres par catégorie et tri
- 📄 Fiches produits détaillées avec produits similaires
- 🛒 Panier d'achat (ajout, modification quantité, suppression)
- 📦 Passage de commande avec adresse de livraison
- 📋 Historique et suivi des commandes
- 👤 Gestion du profil et changement de mot de passe
- ✉️ Formulaire de contact

### Administrateur
- 📊 Tableau de bord avec statistiques (produits, commandes, revenus)
- 📦 Gestion CRUD des produits (ajout, modification, suppression)
- 🏷️ Gestion des catégories
- 📋 Gestion des commandes avec mise à jour des statuts

---

## 🛠️ Prérequis

- **PHP 8.0+** avec les extensions suivantes activées :
  - `pdo_sqlite`
  - `sqlite3`
  - `mbstring`
- **Git** (pour cloner le projet)
- Aucun serveur web externe nécessaire (Apache, Nginx, XAMPP, etc.)

---

## 🚀 Installation

### 1. Cloner le projet

```bash
git clone https://github.com/votre-username/peche-marine-tn.git
cd peche-marine-tn
```

### 2. Installer PHP

<details>
<summary><strong>🪟 Windows</strong></summary>

**Option A — Scoop (recommandé) :**
```powershell
# Installer Scoop si pas déjà fait
Set-ExecutionPolicy -ExecutionPolicy RemoteSigned -Scope CurrentUser
irm get.scoop.dev | iex

# Installer PHP
scoop install php
```

**Option B — Téléchargement manuel :**
1. Télécharger PHP depuis [windows.php.net](https://windows.php.net/download/)
2. Extraire dans `C:\php`
3. Ajouter `C:\php` au PATH système

**Activer les extensions SQLite :**

Ouvrir le fichier `php.ini` (situé dans le dossier PHP) et décommenter (retirer le `;`) :
```ini
extension_dir = "ext"
extension=pdo_sqlite
extension=sqlite3
extension=mbstring
```

> 💡 Si le fichier `php.ini` n'existe pas, copier `php.ini-development` en `php.ini`

</details>

<details>
<summary><strong>🐧 Linux (Ubuntu/Debian)</strong></summary>

```bash
sudo apt update
sudo apt install php php-sqlite3 php-mbstring
```

</details>

<details>
<summary><strong>🍎 macOS</strong></summary>

```bash
# PHP est pré-installé sur macOS, sinon :
brew install php
```

</details>

### 3. Vérifier l'installation

```bash
php -v
# Doit afficher PHP 8.0+ 

php -m | grep -i sqlite
# Doit afficher : pdo_sqlite et sqlite3
```

### 4. Lancer le serveur

```bash
php -S localhost:8000 -t public
```

### 5. Ouvrir dans le navigateur

Aller sur **http://localhost:8000**

> 🎉 La base de données SQLite est **créée automatiquement** au premier lancement avec des données de démonstration (24 produits, 6 catégories).

---

## 🔑 Comptes par défaut

| Rôle | Email | Mot de passe |
|------|-------|-------------|
| **Administrateur** | `admin@pechemarine.tn` | `admin123` |

> Pour tester en tant que client, créez un nouveau compte via la page d'inscription.

---

## 📁 Structure du Projet

```
peche-marine-tn/
├── public/                     # Point d'entrée web
│   ├── index.php               # Front controller
│   └── assets/
│       ├── css/style.css       # Styles personnalisés (thème dark)
│       ├── js/app.js           # JavaScript client
│       └── images/products/    # Images des produits (24 photos)
│
├── app/
│   ├── controllers/            # Logique métier (8 contrôleurs)
│   │   ├── HomeController.php
│   │   ├── AuthController.php
│   │   ├── ProductController.php
│   │   ├── CartController.php
│   │   ├── OrderController.php
│   │   ├── ProfileController.php
│   │   ├── ContactController.php
│   │   └── AdminController.php
│   ├── models/
│   │   └── Database.php        # Singleton PDO SQLite
│   └── views/                  # Templates PHP (16 vues)
│       ├── layouts/            # Header + Footer
│       ├── home/               # Page d'accueil
│       ├── auth/               # Login + Register
│       ├── products/           # Catalogue + Fiche produit
│       ├── cart/               # Panier
│       ├── orders/             # Commandes
│       ├── profile/            # Profil utilisateur
│       ├── contact/            # Formulaire contact
│       ├── admin/              # Back-office admin
│       └── 404.php             # Page d'erreur
│
├── config/
│   └── config.php              # Configuration + helpers
│
├── database/
│   ├── schema.sql              # Schéma BDD (8 tables)
│   └── seed.sql                # Données initiales
│
├── router.php                  # Routeur URL → Controller
├── docs/                       # Documentation PFE
├── .gitignore
└── README.md
```

---

## 🗄️ Base de Données

La base SQLite contient **8 tables** conformes au diagramme de classes UML :

```
utilisateur ──1:1── panier ──1:*── ligne_panier ──*:1── produit
     │                                                    │
     └──1:*── commande ──1:*── ligne_commande ──*:1───────┘
                                                    produit ──*:1── categorie
contact (indépendante)
```

| Table | Description |
|-------|------------|
| `utilisateur` | Clients et administrateurs |
| `categorie` | Catégories de produits (6) |
| `produit` | Produits en vente (24) |
| `panier` | Panier par utilisateur |
| `ligne_panier` | Articles dans le panier |
| `commande` | Commandes passées |
| `ligne_commande` | Détail des commandes |
| `contact` | Messages du formulaire contact |

### Réinitialiser la base de données

Pour repartir à zéro avec les données de démonstration :

```bash
# Supprimer la BDD (elle sera recréée au prochain lancement)
rm database/peche_marine.db        # Linux/macOS
del database\peche_marine.db       # Windows
```

---

## 🔧 Configuration

Le fichier `config/config.php` contient les paramètres principaux :

```php
define('APP_NAME', 'Pêche Marine TN');
define('APP_URL', 'http://localhost:8000');
```

Pour changer le port du serveur :
```bash
php -S localhost:3000 -t public
# Puis modifier APP_URL dans config.php
```

---

## 🧰 Stack Technique

| Composant | Technologie |
|-----------|------------|
| **Backend** | PHP 8+ (MVC natif, sans framework) |
| **Base de données** | SQLite 3 (fichier local, zéro config) |
| **Frontend** | HTML5, CSS3, JavaScript ES6 |
| **UI Framework** | Bootstrap 5.3 (CDN) |
| **Icônes** | Bootstrap Icons (CDN) |
| **Police** | Outfit (Google Fonts) |
| **Sécurité** | `password_hash`, PDO prepared statements, CSRF-safe |

---

## 📄 Licence

Ce projet est développé dans le cadre d'un projet de fin d'études (PFE).
