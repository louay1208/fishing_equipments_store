# Pêche Marine TN — Détails Techniques Complémentaires

> Ce document complète le `DEPLOYMENT_GUIDE.md` avec des explications approfondies sur l'architecture, la base de données, et les configurations avancées.

---

## 1 — Architecture du Projet

### 1.1 — Pattern MVC

Le projet suit le pattern **Model-View-Controller** (MVC) sans framework externe :

```
Requête HTTP
    ↓
public/index.php          ← Point d'entrée unique (Front Controller)
    ↓
router.php                ← Analyse l'URL, appelle le bon contrôleur
    ↓
app/controllers/*.php     ← Logique métier (13 contrôleurs)
    ↓
app/models/Database.php   ← Accès BD (PDO, supporte SQLite + MySQL)
    ↓
app/views/**/*.php        ← Templates HTML (13 modules de vues)
```

### 1.2 — Les 13 Contrôleurs

| Contrôleur | Route | Rôle |
|------------|-------|------|
| `HomeController` | `/` | Page d'accueil, produits vedettes |
| `AuthController` | `/login`, `/register`, `/logout` | Inscription, connexion, déconnexion |
| `ProductController` | `/products`, `/products/{id}` | Catalogue, fiche produit, recherche API |
| `CartController` | `/cart`, `/cart/add`, `/cart/update`, `/cart/remove` | Panier d'achat |
| `OrderController` | `/checkout`, `/orders`, `/orders/{id}` | Commandes et historique |
| `ProfileController` | `/profile` | Profil utilisateur |
| `ContactController` | `/contact` | Formulaire de contact |
| `AdminController` | `/admin/*` | Tableau de bord admin, CRUD produits/catégories/commandes |
| `AboutController` | `/about` | Page à propos |
| `ReviewController` | `/reviews/store`, `/reviews/delete` | Avis produits |
| `WishlistController` | `/wishlist`, `/wishlist/toggle` | Liste de souhaits |
| `FaqController` | `/faq` | Questions fréquentes |
| `WeatherController` | `/meteo` | Météo marine temps réel |

### 1.3 — Comment fonctionne le routage

1. Apache reçoit la requête (ex: `GET /products/5`)
2. `.htaccess` redirige tout vers `public/index.php`
3. `index.php` définit les constantes de chemins et charge `router.php`
4. `router.php` initialise la BD, puis utilise `match(true)` de PHP 8 pour router
5. Le contrôleur correspondant est appelé avec les paramètres extraits de l'URL

Le fichier `.htaccess` dans `public/` contient :
```apache
RewriteEngine On
RewriteCond %{REQUEST_FILENAME} !-f    # Si le fichier n'existe pas
RewriteCond %{REQUEST_FILENAME} !-d    # Si le dossier n'existe pas
RewriteRule ^(.*)$ index.php [QSA,L]   # Tout passe par index.php
```

---

## 2 — Base de Données MySQL — Schéma Détaillé

### 2.1 — Diagramme des Tables

```
┌──────────────┐     ┌──────────────┐     ┌──────────────────┐
│ utilisateur  │     │  categorie   │     │     produit      │
├──────────────┤     ├──────────────┤     ├──────────────────┤
│ id (PK)      │     │ id (PK)      │     │ id (PK)          │
│ nom          │     │ nom          │     │ nom              │
│ prenom       │     │ description  │     │ description      │
│ email (UQ)   │     │ image        │     │ prix             │
│ mot_de_passe │     └──────┬───────┘     │ quantite_stock   │
│ telephone    │            │             │ image            │
│ adresse      │            └─────────────│ categorie_id (FK)│
│ avatar       │                          │ created_at       │
│ role (enum)  │                          └────────┬─────────┘
│ created_at   │                                   │
└──────┬───────┘                                   │
       │                                           │
       ├─────── panier ──── ligne_panier ──────────┤
       │                                           │
       ├─────── commande ── ligne_commande ────────┤
       │                                           │
       ├─────── avis (note 1-5) ───────────────────┤
       │                                           │
       ├─────── favori ────────────────────────────┘
       │
       └─────── contact (messages reçus)
```

### 2.2 — Les 9 Tables

| Table | Rôle | Relations |
|-------|------|-----------|
| `utilisateur` | Comptes utilisateurs et admins | Parent de toutes les tables utilisateur |
| `categorie` | 4 catégories de produits | Parent de `produit` |
| `produit` | 8 articles de pêche | FK vers `categorie` |
| `panier` | Un panier par utilisateur | FK vers `utilisateur` (UNIQUE) |
| `ligne_panier` | Produits dans le panier | FK vers `panier` + `produit` |
| `commande` | Commandes passées | FK vers `utilisateur`, statut enum |
| `ligne_commande` | Détail des commandes | FK vers `commande` + `produit` |
| `avis` | Notes et commentaires produits | FK vers `utilisateur` + `produit` (UNIQUE pair) |
| `favori` | Produits favoris / wishlist | FK vers `utilisateur` + `produit` (UNIQUE pair) |
| `contact` | Messages du formulaire contact | Indépendant |

### 2.3 — Données initiales (seed)

Le fichier `seed_mysql.sql` insère :
- **1 administrateur** : `admin@pechemarine.tn` / `Admin123!`
- **4 catégories** : Cannes, Moulinets, Leurres, Accessoires
- **8 produits** : 2 par catégorie, avec descriptions en français, prix en DT (Dinar Tunisien)

### 2.4 — Statuts de commande

Les commandes passent par ces statuts (enum MySQL) :

```
en_attente → confirmee → expediee → livree
                                  ↘ annulee
```

---

## 3 — Le système dual SQLite / MySQL

Le fichier `app/models/Database.php` gère les deux modes :

```php
// Le mode est défini dans config/config.php
define('DB_MODE', 'mysql');  // ou 'sqlite'
```

**Mode SQLite** (développement rapide) :
- Base de données : fichier `database/peche_marine.db`
- Aucune installation requise (PHP inclut SQLite nativement)
- Lancer avec : `php -S localhost:8000 -t public/`

**Mode MySQL** (production / XAMPP) :
- Requiert XAMPP avec MySQL/MariaDB
- Connexion via PDO avec charset `utf8mb4`
- Auto-création des tables si absentes au premier chargement

### Comment basculer entre les modes

1. Ouvrir `config/config.php`
2. Modifier la ligne : `define('DB_MODE', 'sqlite');` ou `define('DB_MODE', 'mysql');`
3. En mode MySQL, s'assurer que la BD `peche_marine` existe

---

## 4 — Configuration PHP détaillée

### 4.1 — Pourquoi les chemins absolus dans php.ini ?

Quand Apache charge PHP comme module (`LoadModule php_module`), le répertoire de travail est celui d'Apache (`C:\xampp\apache`), PAS celui de PHP. Donc `extension_dir = "ext"` cherche dans `C:\xampp\apache\ext\` qui n'existe pas.

**Solution** : toujours utiliser des chemins absolus :
```ini
extension_dir = "C:/xampp/php/ext"
extension="C:/xampp/php/ext/php_pdo_mysql.dll"
```

### 4.2 — Pourquoi `libssl` et `libcrypto` en LoadFile ?

L'extension `php_pdo_mysql.dll` dépend de bibliothèques SSL. Ces DLLs sont dans `C:\xampp\php\` mais Apache ne cherche pas là. Les directives `LoadFile` dans `httpd-xampp.conf` forcent le chargement :

```apache
LoadFile "C:/xampp/php/libssl-3-x64.dll"
LoadFile "C:/xampp/php/libcrypto-3-x64.dll"
```

### 4.3 — Le piège du BOM UTF-8

PowerShell `Set-Content -Encoding UTF8` ajoute un **BOM** (Byte Order Mark, 3 octets `EF BB BF`) au début du fichier. PHP ne peut pas parser un `php.ini` qui commence par ces octets.

**Vérification** : ouvrir le fichier en hexadécimal. Les 3 premiers octets doivent être `5B 50 48` (`[PH` = début de `[PHP]`), PAS `EF BB BF`.

**Éditeurs sûrs** : Notepad++, VS Code, Sublime Text (tous sauvegardent sans BOM par défaut).

---

## 5 — Encodage UTF-8 — Chaîne complète

Pour afficher correctement les caractères français (é, è, à, ê, ù, ç, etc.), **chaque maillon** de la chaîne doit être en UTF-8 :

| Maillon | Fichier/Config | Valeur requise |
|---------|----------------|----------------|
| Base de données | `schema_mysql.sql` | `CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci` |
| Import des données | Commande mysql | `--default-character-set=utf8mb4` |
| Connexion PDO | `Database.php` | `charset=utf8mb4` dans le DSN + `SET NAMES utf8mb4` |
| Page HTML | `header.php` | `<meta charset="UTF-8">` |
| Fichiers source | Tous les `.php` | Encodés en UTF-8 (vérifier dans l'éditeur) |

Si **un seul maillon** est manquant, vous verrez des caractères comme `├á`, `├¬`, `├®` ou `Ã©`, `Ã¨`.

---

## 6 — Gestion des services XAMPP

### 6.1 — Toujours utiliser le XAMPP Control Panel

Ne PAS essayer de démarrer Apache/MySQL en ligne de commande. Le XAMPP Control Panel initialise correctement les variables d'environnement (PATH, PHPRC, etc.).

```
C:\xampp\xampp-control.exe
```

### 6.2 — Après chaque modification de configuration

Après avoir modifié `php.ini`, `httpd.conf`, `httpd-vhosts.conf` ou `httpd-xampp.conf` :

1. **Stopper** Apache dans le XAMPP Control Panel (bouton Stop)
2. Attendre que le statut passe au rouge
3. **Démarrer** Apache (bouton Start)
4. Vérifier qu'il repasse au vert

Un simple "Restart" ne suffit pas toujours — préférer Stop puis Start.

### 6.3 — Vérifier que PHP fonctionne correctement

Créer `C:\xampp\htdocs\peche-marine\public\phpinfo.php` :
```php
<?php phpinfo(); ?>
```

Accéder à http://pechemarine.local/phpinfo.php et vérifier :
- **Loaded Configuration File** = `C:\xampp\php\php.ini`
- **extension_dir** = `C:/xampp/php/ext`
- **pdo_mysql** = présent dans la liste des modules
- **mysqli** = présent dans la liste des modules

**Supprimer ce fichier après vérification** (fuite d'informations en production).

### 6.4 — Conflits de port 80

Si Apache ne démarre pas, un autre programme utilise le port 80. Pour identifier :

```powershell
netstat -ano | findstr :80
```

Programmes courants qui bloquent le port 80 : **IIS**, **Skype**, **Teams**, **World Wide Web Publishing Service**.

Solution : arrêter le programme concurrent, ou changer le port Apache dans `httpd.conf` :
```apache
Listen 8080
```
Et mettre à jour le VirtualHost avec `<VirtualHost *:8080>`.

---

## 7 — Sécurité en production

### 7.1 — Créer un utilisateur MySQL dédié

```sql
-- Dans phpMyAdmin ou mysql CLI
CREATE USER 'pechemarine'@'localhost' IDENTIFIED BY 'VotreMotDePasseSecurise!';
GRANT ALL PRIVILEGES ON peche_marine.* TO 'pechemarine'@'localhost';
FLUSH PRIVILEGES;
```

Puis dans `config.php` :
```php
define('DB_USER', 'pechemarine');
define('DB_PASS', 'VotreMotDePasseSecurise!');
```

### 7.2 — Fichiers à protéger

Ces fichiers ne doivent **jamais** être accessibles depuis le web :
- `config/config.php` (identifiants BD)
- `database/*.sql` (schéma et données)
- `database/*.db` (base SQLite)

Le VirtualHost pointe vers `public/` — ces fichiers sont donc naturellement protégés car ils sont en dehors du DocumentRoot.

### 7.3 — Supprimer les fichiers de test

Avant de mettre en production, supprimer :
- `public/phpinfo.php`
- `public/phptest.php`
- `public/test2.php`

---

## 8 — Sauvegarde et restauration

### 8.1 — Sauvegarder la base MySQL

```powershell
& "C:\xampp\mysql\bin\mysqldump.exe" -u root --default-character-set=utf8mb4 peche_marine > backup_peche_marine.sql
```

### 8.2 — Restaurer depuis une sauvegarde

```powershell
& "C:\xampp\mysql\bin\mysql.exe" -u root -e "DROP DATABASE IF EXISTS peche_marine;"
cmd /c "C:\xampp\mysql\bin\mysql.exe -u root --default-character-set=utf8mb4 < backup_peche_marine.sql"
```

### 8.3 — Sauvegarder les images uploadées

Les images produits uploadées par l'admin sont dans :
```
C:\xampp\htdocs\peche-marine\public\assets\images\products\
```
Pensez à inclure ce dossier dans vos sauvegardes.

---

## 9 — Développement local sans XAMPP (mode SQLite)

Pour développer rapidement sans XAMPP :

1. S'assurer que `config.php` a `define('DB_MODE', 'sqlite');`
2. Ouvrir un terminal dans le dossier du projet
3. Lancer le serveur PHP intégré :

```powershell
php -S localhost:8000 -t public/
```

4. Ouvrir http://localhost:8000 dans le navigateur

La base SQLite `database/peche_marine.db` sera créée automatiquement au premier accès.

---

*Complément au DEPLOYMENT_GUIDE.md — Pêche Marine TN v1.0*
