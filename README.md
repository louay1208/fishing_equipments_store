# Pêche Marine TN — Boutique en Ligne de Matériel de Pêche

Plateforme e-commerce dédiée à la vente de matériel de pêche marine en Tunisie.  
Développée en **PHP natif** avec **SQLite/MySQL** et **Bootstrap 5**.

---

## Prérequis

| Logiciel | Version | Rôle |
|----------|---------|------|
| **PHP**  | 8.1+    | Backend |
| **Navigateur** | Chrome, Firefox, Edge | Accès à l'application |

> Le projet supporte **deux modes** de base de données :
> - **SQLite** — zéro configuration, fonctionne immédiatement
> - **MySQL** — via XAMPP, recommandé pour la production
>
> Voir [docs/DEPLOYMENT_GUIDE.md](docs/DEPLOYMENT_GUIDE.md) pour le déploiement MySQL/XAMPP complet.

---

## Installation rapide (SQLite)

### 1 — Cloner le projet

```powershell
git clone https://github.com/louay1208/fishing_equipments_store.git
cd fishing_equipments_store
git checkout dev
```

### 2 — Lancer le serveur

```powershell
php -S localhost:8000 -t public
```

### 3 — Ouvrir dans le navigateur

```
http://localhost:8000
```

> La base de données SQLite est créée et peuplée automatiquement au premier lancement.

---

## Installation XAMPP (MySQL)

Pour un déploiement complet avec Apache et MySQL, suivre le guide pas à pas :

**[docs/DEPLOYMENT_GUIDE.md](docs/DEPLOYMENT_GUIDE.md)**

Ce guide couvre : installation XAMPP, configuration PHP/Apache, VirtualHost, import de la base de données, et résolution de problèmes.

---

## Comptes par défaut

| Rôle | Email | Mot de passe |
|------|-------|-------------|
| **Administrateur** | `admin@pechemarine.tn` | `Admin123!` |

> Vous pouvez aussi créer un compte client depuis la page **S'inscrire**.

---

## Structure du projet

```
fishing_equipments_store/
├── app/
│   ├── controllers/        # Logique métier (13 contrôleurs)
│   ├── models/              # Accès BD (Database.php — SQLite/MySQL)
│   └── views/               # Templates PHP
│       └── layouts/         # Header et Footer
├── config/
│   └── config.php           # Configuration BD et helpers
├── database/
│   ├── schema_mysql.sql     # Schéma MySQL
│   ├── seed_mysql.sql       # Données MySQL (4 catégories, 8 produits)
│   ├── schema.sql           # Schéma SQLite
│   └── seed.sql             # Données SQLite
├── public/
│   ├── index.php            # Point d'entrée
│   ├── .htaccess            # Réécriture URL (Apache)
│   └── assets/              # CSS, JS, images
├── router.php               # Routeur URL
├── docs/
│   ├── DEPLOYMENT_GUIDE.md  # Guide de déploiement XAMPP
│   └── DEPLOYMENT_DETAILS.md # Architecture technique
└── README.md
```

---

## Fonctionnalités

### Boutique
- Catalogue avec filtres par catégorie et tri
- Fiches produit avec système d'avis
- Panier d'achat complet
- Processus de commande et historique
- Liste de favoris (wishlist)

### Interface
- Thème nautique (bleu océan, turquoise, ambre)
- Mode sombre avec persistance
- Animations au défilement
- Design responsive (mobile/desktop)
- Recherche de produits en temps réel

### Utilisateurs
- Inscription / Connexion / Déconnexion
- Profil avec avatar personnalisable
- Rôles : client et administrateur

### Administration
- Tableau de bord avec statistiques
- Gestion des produits et catégories (CRUD)
- Suivi des commandes

### Météo Marine
- Prévisions météo pour 8 spots côtiers tunisiens
- Données en temps réel via API Open-Meteo

---

## Réinitialiser la base de données

**Mode SQLite :**
```powershell
Remove-Item database\peche_marine.db
php -S localhost:8000 -t public
```

**Mode MySQL :**
```powershell
& "C:\xampp\mysql\bin\mysql.exe" -u root -e "DROP DATABASE IF EXISTS peche_marine;"
cmd /c "C:\xampp\mysql\bin\mysql.exe -u root --default-character-set=utf8mb4 < database\schema_mysql.sql"
cmd /c "C:\xampp\mysql\bin\mysql.exe -u root --default-character-set=utf8mb4 < database\seed_mysql.sql"
```

---

## Technologies

| Technologie | Version | Usage |
|-------------|---------|-------|
| **PHP** | 8.1+ | Backend, routing, MVC |
| **SQLite / MySQL** | Inclus | Base de données |
| **Bootstrap** | 5.3.3 | Framework CSS |
| **Bootstrap Icons** | 1.11.3 | Icônes |
| **Chart.js** | 4.4.4 | Graphiques admin |
| **Open-Meteo API** | — | Météo marine |

---

## Documentation

- [Guide de déploiement XAMPP](docs/DEPLOYMENT_GUIDE.md) — installation pas à pas
- [Détails techniques](docs/DEPLOYMENT_DETAILS.md) — architecture, schéma BD, sécurité

---

Projet de fin d'études — © 2026 Pêche Marine TN
