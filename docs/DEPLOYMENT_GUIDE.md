# Pêche Marine TN — Guide de Déploiement XAMPP

> Guide complet pour déployer le projet **Pêche Marine TN** sur un nouveau PC Windows avec XAMPP, Apache, MySQL et phpMyAdmin.
>
> 📄 **Document complémentaire** : voir [DEPLOYMENT_DETAILS.md](DEPLOYMENT_DETAILS.md) pour l'architecture technique, le schéma de base de données, les explications approfondies et les commandes de sauvegarde/restauration.

---

## 📋 Table des matières

1. [Prérequis](#1--prérequis)
2. [Installer XAMPP](#2--installer-xampp)
3. [Copier le projet](#3--copier-le-projet)
4. [Configurer PHP (php.ini)](#4--configurer-php-phpini)
5. [Corriger les chemins XAMPP](#5--corriger-les-chemins-xampp)
6. [Configurer Apache (VirtualHost)](#6--configurer-apache-virtualhost)
7. [Configurer le fichier hosts](#7--configurer-le-fichier-hosts)
8. [Configurer le projet](#8--configurer-le-projet)
9. [Créer et peupler la base de données](#9--créer-et-peupler-la-base-de-données)
10. [Démarrer et tester](#10--démarrer-et-tester)
11. [Résolution de problèmes](#11--résolution-de-problèmes)

---

## 1 — Prérequis

| Composant | Version |
|-----------|---------|
| Windows | 10 ou 11 (64 bits) |
| XAMPP | 8.2.x (inclut Apache, MySQL/MariaDB, PHP 8.2, phpMyAdmin) |
| Navigateur | Chrome, Firefox, ou Edge |

> **NOTE**
> Le projet supporte **deux modes** de base de données :
> - **SQLite** — zéro configuration, fonctionne immédiatement
> - **MySQL** — nécessite XAMPP, recommandé pour la production
>
> Ce guide couvre le déploiement **MySQL via XAMPP**.

---

## 2 — Installer XAMPP

### 2.1 — Téléchargement

1. Aller sur https://www.apachefriends.org/download.html
2. Cliquer sur **XAMPP for Windows** — choisir la version **PHP 8.2.x** (64 bits)
3. Télécharger le fichier `.exe` (environ 150 Mo)

### 2.2 — Installation pas à pas

1. **Lancer l'installeur** en double-cliquant sur le `.exe` téléchargé
2. Si Windows affiche un avertissement UAC, cliquer **Oui**
3. **Sélectionner les composants** : cocher au minimum :
   - ✅ Apache
   - ✅ MySQL
   - ✅ PHP
   - ✅ phpMyAdmin
4. **Choisir le dossier d'installation** — utiliser un chemin **court et sans espaces** :

```
C:\xampp
```

> **⚠️ IMPORTANT**
> **Si vous installez XAMPP dans un dossier différent** (ex: `C:\xampp-server`), vous devrez adapter **tous les chemins** mentionnés dans ce guide. Faites un rechercher-remplacer global de `C:\xampp` → votre chemin.

5. Cliquer **Next** jusqu'à la fin de l'installation
6. Ne **pas** cocher "Lancer le Control Panel" à la fin (on le fera manuellement)

### 2.3 — Premier lancement

1. Ouvrir le dossier `C:\xampp` dans l'Explorateur
2. Double-cliquer sur **`xampp-control.exe`**
3. Si Windows Firewall demande l'autorisation, cliquer **Autoriser l'accès**
4. Cliquer **Start** à côté de **Apache** → doit passer au **vert**
5. Cliquer **Start** à côté de **MySQL** → doit passer au **vert**
6. Ouvrir http://localhost dans le navigateur → vous devez voir la page d'accueil XAMPP
7. Ouvrir http://localhost/phpmyadmin → vous devez voir phpMyAdmin

---

## 3 — Copier le projet

Copier l'intégralité du dossier projet dans le répertoire `htdocs` de XAMPP :

```powershell
# Depuis PowerShell
Copy-Item -Recurse "CHEMIN_DU_PROJET" "C:\xampp\htdocs\peche-marine"
```

Ou manuellement : copier/coller le dossier dans `C:\xampp\htdocs\` et le renommer `peche-marine`.

La structure finale doit être :

```
C:\xampp\htdocs\peche-marine\
├── app/
│   ├── controllers/
│   ├── models/
│   │   └── Database.php      ← Gestion SQLite/MySQL
│   └── views/
├── config/
│   └── config.php            ← Configuration BD
├── database/
│   ├── schema_mysql.sql      ← Schéma MySQL
│   ├── seed_mysql.sql        ← Données initiales MySQL
│   ├── schema.sql            ← Schéma SQLite (alternatif)
│   └── seed.sql              ← Données SQLite (alternatif)
├── public/
│   ├── index.php             ← Point d'entrée
│   ├── .htaccess             ← Réécriture d'URL
│   └── assets/               ← CSS, JS, images
├── router.php                ← Routeur principal
└── docs/
    └── DEPLOYMENT_GUIDE.md   ← Ce fichier
```

---

## 4 — Configurer PHP (php.ini)

Le fichier `php.ini` se trouve dans : `C:\xampp\php\php.ini`

### 4.1 — Définir le répertoire des extensions

Ouvrir `php.ini` dans un éditeur de texte (Notepad++, VS Code, etc.).

Rechercher la ligne `extension_dir` (autour de la ligne 768) et la remplacer par :

```ini
; Remplacer la ligne commentée:
;extension_dir = "ext"

; Par le chemin absolu:
extension_dir = "C:/xampp/php/ext"
```

### 4.2 — Activer les extensions nécessaires

Rechercher la section `Dynamic Extensions` et **décommenter** (supprimer le `;`) les extensions suivantes.

> **⚠️ CRITIQUE**
> **Utilisez des chemins absolus** vers les DLLs pour éviter les problèmes de résolution de chemin avec Apache. Remplacez les lignes comme `extension=pdo_mysql` par le format ci-dessous :

```ini
extension="C:/xampp/php/ext/php_curl.dll"
extension="C:/xampp/php/ext/php_fileinfo.dll"
extension="C:/xampp/php/ext/php_gettext.dll"
extension="C:/xampp/php/ext/php_mbstring.dll"
extension="C:/xampp/php/ext/php_exif.dll"
extension="C:/xampp/php/ext/php_mysqli.dll"
extension="C:/xampp/php/ext/php_openssl.dll"
extension="C:/xampp/php/ext/php_pdo_mysql.dll"
extension="C:/xampp/php/ext/php_pdo_sqlite.dll"
```

> **🚫 ATTENTION**
> **Ne pas modifier php.ini avec PowerShell `Set-Content`** — cela ajoute un BOM UTF-8 qui rend le fichier illisible par PHP. Utilisez **Notepad**, **Notepad++** ou **VS Code** uniquement. Vérifiez que l'encodage est `UTF-8 sans BOM`.

### 4.3 — Vérification rapide

Après modification, vérifier en ligne de commande :

```powershell
& "C:\xampp\php\php.exe" -m | Select-String "pdo_mysql"
```

Résultat attendu : `pdo_mysql`

---

## 5 — Corriger les chemins XAMPP

> **⚠️ IMPORTANT**
> Le programme d'installation de XAMPP laisse parfois des chemins incorrects dans la configuration Apache. Cette étape est **obligatoire** si XAMPP n'a pas été installé dans le chemin par défaut `C:\xampp`.

### 5.1 — Corriger `httpd-xampp.conf`

Ouvrir : `C:\xampp\apache\conf\extra\httpd-xampp.conf`

Vérifier que **tous les chemins** pointent vers votre installation XAMPP. Les lignes critiques :

```apache
<IfModule env_module>
    SetEnv MIBDIRS "C:/xampp/php/extras/mibs"
    SetEnv MYSQL_HOME "C:/xampp/mysql/bin"
    SetEnv OPENSSL_CONF "C:/xampp/apache/bin/openssl.cnf"
    SetEnv PHP_PEAR_SYSCONF_DIR "C:/xampp/php"
    SetEnv PHPRC "C:/xampp/php"
    SetEnv TMP "C:/xampp/tmp"
</IfModule>
```

> **⚠️ CRITIQUE**
> Le champ `PHPRC` est **le plus important** — il indique à Apache où trouver `php.ini`. S'il pointe vers un mauvais dossier (ex: `\\xampp\\php`), PHP chargera un fichier par défaut sans les extensions.

Vérifier aussi les lignes `LoadFile` et ajouter celles pour SSL si absentes :

```apache
LoadFile "C:/xampp/php/php8ts.dll"
LoadFile "C:/xampp/php/libpq.dll"
LoadFile "C:/xampp/php/libsqlite3.dll"
LoadFile "C:/xampp/php/libssl-3-x64.dll"
LoadFile "C:/xampp/php/libcrypto-3-x64.dll"
LoadModule php_module "C:/xampp/php/php8apache2_4.dll"
```

Et la directive `PHPINIDir` :

```apache
<IfModule php_module>
    PHPINIDir "C:/xampp/php"
    php_admin_value extension_dir "C:/xampp/php/ext"
</IfModule>
```

### 5.2 — Vérifier `httpd.conf`

Ouvrir : `C:\xampp\apache\conf\httpd.conf`

S'assurer que ce module est décommenté (pas de `#` devant) :

```apache
LoadModule rewrite_module modules/mod_rewrite.so
```

Et que le fichier vhosts est inclus :

```apache
Include conf/extra/httpd-vhosts.conf
```

---

## 6 — Configurer Apache (VirtualHost)

Ouvrir : `C:\xampp\apache\conf\extra\httpd-vhosts.conf`

Ajouter **à la fin du fichier** :

```apache
# ── Pêche Marine TN ──
<VirtualHost *:80>
    ServerName pechemarine.local
    DocumentRoot "C:/xampp/htdocs/peche-marine/public"

    <Directory "C:/xampp/htdocs/peche-marine/public">
        Options Indexes FollowSymLinks
        AllowOverride All
        Require all granted
    </Directory>
</VirtualHost>
```

**Explications ligne par ligne :**
- `ServerName pechemarine.local` → le nom de domaine local utilisé dans le navigateur
- `DocumentRoot` → pointe vers `public/` (PAS la racine du projet) pour la sécurité
- `AllowOverride All` → permet au `.htaccess` de fonctionner (réécriture d'URL)
- `Require all granted` → autorise l'accès depuis le navigateur

### Alternative sans VirtualHost

Si vous ne souhaitez pas configurer un VirtualHost, le site est aussi accessible directement via :
```
http://localhost/peche-marine/public/
```
Mais les URLs internes ne fonctionneront pas correctement sans la réécriture. Le VirtualHost est donc **fortement recommandé**.

---

## 7 — Configurer le fichier hosts

Le fichier `hosts` fait correspondre le nom `pechemarine.local` à votre machine locale.

### 7.1 — Ouvrir le fichier en administrateur

**Méthode 1 — Notepad :**
1. Cliquer sur le menu **Démarrer**
2. Taper `notepad`
3. Clic droit sur **Bloc-notes** → **Exécuter en tant qu'administrateur**
4. Menu Fichier → Ouvrir
5. Dans la barre d'adresse, coller : `C:\Windows\System32\drivers\etc`
6. En bas à droite, changer le filtre de "Documents texte" à **Tous les fichiers**
7. Sélectionner le fichier `hosts` → Ouvrir

**Méthode 2 — PowerShell (admin) :**
```powershell
Start-Process notepad "C:\Windows\System32\drivers\etc\hosts" -Verb RunAs
```

### 7.2 — Ajouter l'entrée

Ajouter cette ligne **à la toute fin** du fichier :

```
127.0.0.1    pechemarine.local
```

Sauvegarder (Ctrl+S) et fermer.

### 7.3 — Vérifier

```powershell
ping pechemarine.local
```

Résultat attendu : `Réponse de 127.0.0.1` — confirme que le nom est résolu.

---

## 8 — Configurer le projet

### 8.1 — Basculer en mode MySQL

Ouvrir : `C:\xampp\htdocs\peche-marine\config\config.php`

Modifier la ligne 14 :

```php
// Changer 'sqlite' en 'mysql'
define('DB_MODE', 'mysql');
```

### 8.2 — Vérifier les paramètres MySQL

Les valeurs par défaut fonctionnent avec XAMPP standard :

```php
define('DB_HOST', 'localhost');
define('DB_NAME', 'peche_marine');
define('DB_USER', 'root');
define('DB_PASS', '');    // XAMPP default = vide
```

> **💡 CONSEIL**
> En production, créez un utilisateur MySQL dédié avec un mot de passe sécurisé.

---

## 9 — Créer et peupler la base de données

### Option A — Via la ligne de commande (recommandé) ✅

Ouvrir **PowerShell** (menu Démarrer → taper `powershell`) :

**Étape 1 — Importer le schéma** (crée la base `peche_marine` + 9 tables) :
```powershell
cmd /c "C:\xampp\mysql\bin\mysql.exe -u root --default-character-set=utf8mb4 < C:\xampp\htdocs\peche-marine\database\schema_mysql.sql"
```

**Étape 2 — Importer les données** (1 admin + 4 catégories + 8 produits) :
```powershell
cmd /c "C:\xampp\mysql\bin\mysql.exe -u root --default-character-set=utf8mb4 < C:\xampp\htdocs\peche-marine\database\seed_mysql.sql"
```

> **🚫 CRITIQUE — Encodage UTF-8**
> Le flag `--default-character-set=utf8mb4` est **obligatoire** !
> Sans lui, la console Windows utilise le codepage `cp850` qui corrompt les caractères français.
> Symptôme : `Méditerranée` devient `├á├®├¬`, `Légère` devient `L├®g├¿re`.

### Option B — Via phpMyAdmin (interface graphique)

1. Ouvrir http://localhost/phpmyadmin dans le navigateur
2. Cliquer sur l'onglet **Importer** en haut
3. Cliquer **Choisir un fichier** → sélectionner `database/schema_mysql.sql`
4. Vérifier que le **jeu de caractères** est `utf-8`
5. Cliquer **Exécuter** en bas de page
6. Répéter les étapes 2-5 avec `database/seed_mysql.sql`

Alternativement, via l'onglet **SQL** :
1. Copier-coller le contenu complet de `schema_mysql.sql` dans la zone de texte
2. Cliquer **Exécuter**
3. Répéter avec `seed_mysql.sql`

### Option C — Automatique (premier chargement)

Le fichier `Database.php` auto-détecte si les tables n'existent pas et les crée automatiquement au premier chargement de la page. Les données initiales sont aussi insérées.

**Cependant**, cette méthode ne garantit pas le bon encodage UTF-8. **L'option A est préférée**.

### Vérification de l'import

```powershell
# Compter les produits (attendu : 8)
& "C:\xampp\mysql\bin\mysql.exe" -u root --default-character-set=utf8mb4 peche_marine -e "SELECT COUNT(*) as total FROM produit;"

# Vérifier l'encodage (les accents doivent être corrects)
& "C:\xampp\mysql\bin\mysql.exe" -u root --default-character-set=utf8mb4 peche_marine -e "SELECT nom FROM categorie;"
```

Résultats attendus :
- `8` produits
- Catégories : `Cannes à pêche`, `Moulinets`, `Leurres`, `Accessoires`
- Si les accents sont corrompus, voir §11 "Caractères corrompus"

---

## 10 — Démarrer et tester

### 10.1 — Démarrer les services

1. Ouvrir **XAMPP Control Panel** (`C:\xampp\xampp-control.exe`)
2. Cliquer **Start** pour **Apache** → doit passer au **vert**
3. Cliquer **Start** pour **MySQL** → doit passer au **vert**
4. Si un service reste en **rouge**, voir §11 pour le dépannage

### 10.2 — Vérifier PHP et les extensions

Avant de tester le site, vérifier que PHP est correctement configuré :

1. Créer le fichier `C:\xampp\htdocs\peche-marine\public\phpinfo.php` :
   ```php
   <?php phpinfo(); ?>
   ```
2. Ouvrir http://pechemarine.local/phpinfo.php
3. Vérifier ces éléments dans la page :
   - **Loaded Configuration File** = `C:\xampp\php\php.ini`
   - **extension_dir** = `C:/xampp/php/ext`
   - Le module **pdo_mysql** apparaît dans la liste
   - Le module **mysqli** apparaît dans la liste
4. **Supprimer** `phpinfo.php` après vérification (fuite d'informations sensibles)

### 10.3 — Tester le site

| URL | Description | Ce que vous devez voir |
|-----|-------------|------------------------|
| http://pechemarine.local/ | Page d'accueil | Bannière, produits vedettes, pied de page |
| http://pechemarine.local/products | Catalogue | Grille de 8 produits avec images |
| http://pechemarine.local/meteo | Météo marine | Widget météo pour les côtes tunisiennes |
| http://pechemarine.local/faq | FAQ | Questions fréquentes avec accordéon |
| http://pechemarine.local/about | À propos | Présentation de la boutique |
| http://pechemarine.local/contact | Contact | Formulaire de contact |
| http://pechemarine.local/login | Connexion | Formulaire de login |
| http://localhost/phpmyadmin | phpMyAdmin | Interface de gestion BD |

### 10.4 — Tester les fonctionnalités

**Test 1 — Connexion admin :**
1. Aller sur http://pechemarine.local/login
2. Email : `admin@pechemarine.tn`
3. Mot de passe : `Admin123!`
4. Vous devez voir le tableau de bord admin

**Test 2 — Inscription client :**
1. Aller sur http://pechemarine.local/register
2. Remplir le formulaire avec vos informations
3. Vous devez être redirigé vers la page d'accueil connecté

**Test 3 — Panier :**
1. Aller sur un produit, cliquer "Ajouter au panier"
2. Vérifier le panier → le produit doit apparaître

**Test 4 — Encodage :**
1. Vérifier que les noms de catégories s'affichent correctement :
   - ✅ `Cannes à pêche` (pas `Cannes ├á p├¬che`)
   - ✅ `Méditerranée` (pas `M├®diterran├®e`)
   - ✅ `Légère` (pas `L├®g├¿re`)

### 10.5 — Comptes par défaut

| Rôle | Email | Mot de passe |
|------|-------|--------------|
| Administrateur | `admin@pechemarine.tn` | `Admin123!` |

---

## 11 — Résolution de problèmes

### ❌ Erreur 500 — "could not find driver"

**Cause :** L'extension `pdo_mysql` n'est pas chargée par Apache.

**Solutions :**

1. Vérifier que les extensions dans `php.ini` utilisent des **chemins absolus** (voir §4.2)
2. Vérifier que `PHPRC` dans `httpd-xampp.conf` pointe vers le bon dossier PHP (voir §5.1)
3. Créer un fichier `phpinfo.php` dans `public/` :
   ```php
   <?php phpinfo(); ?>
   ```
   Accéder à http://pechemarine.local/phpinfo.php et chercher `pdo_mysql` dans la liste des modules.

4. Si `pdo_mysql` est absent, redémarrer Apache via le XAMPP Control Panel

---

### ❌ Caractères corrompus (├á, ├¬, ├®)

**Cause :** Les données ont été importées sans le flag `--default-character-set=utf8mb4`.

**Solution :** Ré-importer la base de données :

```powershell
# Supprimer la base existante
& "C:\xampp\mysql\bin\mysql.exe" -u root -e "DROP DATABASE IF EXISTS peche_marine;"

# Ré-importer avec le bon encodage
cmd /c "C:\xampp\mysql\bin\mysql.exe -u root --default-character-set=utf8mb4 < C:\xampp\htdocs\peche-marine\database\schema_mysql.sql"
cmd /c "C:\xampp\mysql\bin\mysql.exe -u root --default-character-set=utf8mb4 < C:\xampp\htdocs\peche-marine\database\seed_mysql.sql"
```

---

### ❌ Page blanche ou erreur 404

**Cause :** `mod_rewrite` désactivé ou `.htaccess` ignoré.

**Solution :**
1. Vérifier que `mod_rewrite` est activé dans `httpd.conf` (voir §5.2)
2. Vérifier que `AllowOverride All` est dans le VirtualHost (voir §6)
3. Redémarrer Apache

---

### ❌ "Access denied" ou "pechemarine.local ne répond pas"

**Solutions :**
1. Vérifier le fichier `hosts` (voir §7)
2. Vérifier qu'Apache est bien démarré dans le XAMPP Control Panel
3. Vérifier que le port 80 n'est pas utilisé par un autre programme (Skype, IIS, etc.)

---

### ❌ php.ini non reconnu après modification

**Cause :** Le fichier a été sauvegardé avec un BOM UTF-8.

**Solution :** Ouvrir le fichier dans **Notepad++** → menu Encodage → **Encoder en UTF-8 (sans BOM)** → Sauvegarder → Redémarrer Apache.

---

## 📁 Référence rapide des fichiers de configuration

| Fichier | Chemin | Rôle |
|---------|--------|------|
| `php.ini` | `C:\xampp\php\php.ini` | Extensions PHP, paramètres |
| `httpd.conf` | `C:\xampp\apache\conf\httpd.conf` | Config Apache principale |
| `httpd-vhosts.conf` | `C:\xampp\apache\conf\extra\httpd-vhosts.conf` | VirtualHosts |
| `httpd-xampp.conf` | `C:\xampp\apache\conf\extra\httpd-xampp.conf` | Chemins XAMPP et PHP |
| `hosts` | `C:\Windows\System32\drivers\etc\hosts` | Résolution DNS locale |
| `config.php` | `htdocs\peche-marine\config\config.php` | Config projet (BD) |

---

## ✅ Checklist de déploiement

Cocher chaque étape au fur et à mesure :

### Installation
```
[ ] XAMPP téléchargé et installé (PHP 8.2.x)
[ ] Apache et MySQL démarrés (vert dans XAMPP Control Panel)
[ ] http://localhost affiche la page XAMPP
[ ] http://localhost/phpmyadmin est accessible
```

### Configuration PHP
```
[ ] php.ini ouvert dans Notepad++ ou VS Code (PAS PowerShell)
[ ] extension_dir = chemin absolu (C:/xampp/php/ext)
[ ] 9 extensions activées avec chemins absolus vers les DLLs
[ ] Fichier sauvegardé en UTF-8 sans BOM
```

### Configuration Apache
```
[ ] httpd-xampp.conf : PHPRC = "C:/xampp/php"
[ ] httpd-xampp.conf : tous les SetEnv corrigés
[ ] httpd-xampp.conf : LoadFile pour libssl + libcrypto ajoutés
[ ] httpd-xampp.conf : PHPINIDir + php_admin_value configurés
[ ] httpd.conf : mod_rewrite décommenté
[ ] httpd-vhosts.conf : VirtualHost pechemarine.local ajouté
```

### Réseau
```
[ ] fichier hosts : 127.0.0.1 pechemarine.local
[ ] ping pechemarine.local → répond 127.0.0.1
```

### Projet
```
[ ] Projet copié dans C:\xampp\htdocs\peche-marine\
[ ] config.php : DB_MODE = 'mysql'
[ ] config.php : identifiants MySQL corrects
```

### Base de données
```
[ ] schema_mysql.sql importé avec --default-character-set=utf8mb4
[ ] seed_mysql.sql importé avec --default-character-set=utf8mb4
[ ] 8 produits dans la table produit
[ ] 4 catégories avec accents corrects
```

### Tests finaux
```
[ ] Apache redémarré après toutes les modifications
[ ] phpinfo.php : pdo_mysql présent dans les modules
[ ] http://pechemarine.local/ affiche la page d'accueil
[ ] Caractères français affichés correctement (é, è, à, ê)
[ ] Connexion admin fonctionne (admin@pechemarine.tn / Admin123!)
[ ] phpinfo.php supprimé
```

---

> 📄 Pour les détails techniques (architecture MVC, schéma BD, sécurité, sauvegardes), voir [DEPLOYMENT_DETAILS.md](DEPLOYMENT_DETAILS.md)

*Guide généré le 02/05/2026 — Pêche Marine TN v1.0*
