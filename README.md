# 🎣 Pêche Marine TN — Boutique en Ligne de Matériel de Pêche

Plateforme e-commerce dédiée à la vente de matériel de pêche marine en Tunisie.  
Développée en **PHP natif** avec **SQLite** et **Bootstrap 5**.

---

## 📋 Prérequis

| Logiciel | Version minimale | Rôle |
|----------|-----------------|------|
| **PHP**  | 8.1 ou supérieur | Serveur backend |
| **Git** | Dernière version | Clonage du projet |
| **Navigateur** | Chrome, Firefox, Edge | Accès à l'application |

> ⚠️ **Aucun autre outil n'est requis.** Pas besoin de Composer, Node.js, npm, MySQL ou Apache.  
> SQLite est inclus directement dans PHP — pas d'installation de base de données séparée.

---

## 🔧 Installation complète (Windows)

### Étape 1 — Télécharger PHP

1. Ouvrez votre navigateur et allez sur :  
   👉 **[https://windows.php.net/download](https://windows.php.net/download)**

2. Dans la section **PHP 8.x** (la plus récente), cherchez la ligne :
   ```
   VS16 x64 Thread Safe
   ```
   > ⚠️ Prenez bien la version **Thread Safe**, pas "Non Thread Safe".

3. Cliquez sur le lien **Zip** pour télécharger le fichier (environ 25 Mo)

4. Une fois téléchargé, **extrayez le fichier .zip** dans :
   ```
   C:\php
   ```
   > Après extraction, vous devez avoir `C:\php\php.exe` directement dans ce dossier.

---

### Étape 2 — Ajouter PHP au PATH système

Pour pouvoir utiliser la commande `php` depuis n'importe quel terminal :

1. Appuyez sur **`Windows + R`**, tapez `sysdm.cpl` et appuyez sur **Entrée**
2. Allez dans l'onglet **"Avancé"**
3. Cliquez sur **"Variables d'environnement..."** en bas
4. Dans la section **"Variables système"** (en bas), trouvez la variable `Path` et double-cliquez dessus
5. Cliquez sur **"Nouveau"**
6. Tapez :
   ```
   C:\php
   ```
7. Cliquez sur **OK** → **OK** → **OK** pour fermer toutes les fenêtres

> ⚠️ **Important** : Fermez et réouvrez tout terminal PowerShell après cette étape.

**Vérification** — ouvrez un **nouveau** PowerShell et tapez :
```powershell
php -v
```

Résultat attendu :
```
PHP 8.x.x (cli) (built: ...)
Copyright (c) The PHP Group
```

Si vous voyez `php n'est pas reconnu`, relisez l'étape 2 et redémarrez votre terminal.

---

### Étape 3 — Activer les extensions PHP requises

PHP est installé mais certaines fonctionnalités doivent être activées manuellement.

1. Ouvrez l'Explorateur de fichiers et allez dans `C:\php`

2. Cherchez le fichier `php.ini-development` et **renommez-le** en :
   ```
   php.ini
   ```
   > Si Windows cache les extensions de fichier : dans l'Explorateur → Affichage → cochez "Extensions de noms de fichiers"

3. Ouvrez `php.ini` avec le **Bloc-notes** (clic droit → Ouvrir avec → Bloc-notes)

4. Utilisez **Ctrl + H** (Rechercher et Remplacer) pour trouver et modifier ces lignes.  
   Pour chaque extension, cherchez la ligne **avec le point-virgule** et remplacez-la par la version **sans point-virgule** :

   | Chercher (avec `;`) | Remplacer par (sans `;`) |
   |---------------------|--------------------------|
   | `;extension=pdo_sqlite` | `extension=pdo_sqlite` |
   | `;extension=sqlite3` | `extension=sqlite3` |
   | `;extension=mbstring` | `extension=mbstring` |
   | `;extension=fileinfo` | `extension=fileinfo` |
   | `;extension=gd` | `extension=gd` |

   > 💡 Le point-virgule `;` au début d'une ligne signifie qu'elle est "commentée" (désactivée).  
   > En le supprimant, vous **activez** l'extension.

5. **Sauvegardez** le fichier (`Ctrl + S`)

**Vérification** — dans PowerShell, exécutez :
```powershell
php -m
```

Dans la liste affichée, vous devez voir ces modules :
```
PDO
pdo_sqlite
sqlite3
mbstring
fileinfo
gd
```

> Si `pdo_sqlite` n'apparaît pas, vérifiez que vous avez bien modifié le bon fichier `php.ini` dans `C:\php\` et pas ailleurs.

---

### Étape 4 — Installer Git

> Si Git est déjà installé, passez à l'étape 5.

1. Téléchargez Git depuis :  
   👉 **[https://git-scm.com/download/win](https://git-scm.com/download/win)**

2. Lancez l'installateur `.exe` téléchargé

3. **Gardez toutes les options par défaut** à chaque écran et cliquez sur "Next" jusqu'à la fin

4. **Vérification** — ouvrez un nouveau PowerShell :
   ```powershell
   git --version
   ```
   Résultat attendu : `git version 2.x.x`

---

### Étape 5 — Cloner et lancer le projet

1. **Ouvrez PowerShell** et naviguez vers le dossier où vous voulez mettre le projet :
   ```powershell
   cd $HOME\Documents
   ```

2. **Clonez le dépôt** :
   ```powershell
   git clone https://github.com/louay1208/fishing_equipments_store.git
   ```

3. **Entrez dans le dossier du projet** :
   ```powershell
   cd fishing_equipments_store
   ```

4. **Créez le dossier pour les avatars** (photos de profil) :
   ```powershell
   New-Item -ItemType Directory -Force -Path "public\assets\images\avatars"
   ```

5. **Lancez le serveur** :
   ```powershell
   php -S localhost:8000 -t public
   ```

6. **Ouvrez votre navigateur** et allez sur :
   ```
   http://localhost:8000
   ```

> 🎉 **C'est tout !** La base de données est créée et remplie automatiquement au premier lancement.

> 💡 Pour **arrêter** le serveur : appuyez sur `Ctrl + C` dans le terminal PowerShell.

---

## 👤 Comptes par défaut

| Rôle | Email | Mot de passe |
|------|-------|-------------|
| **Administrateur** | `admin@pechemarine.tn` | `admin123` |

> L'accès administrateur fait apparaître le bouton **"Dashboard Admin"** dans la barre de navigation.  
> Vous pouvez aussi créer un compte client depuis la page **"S'inscrire"**.

---

## 📁 Structure du projet

```
fishing_equipments_store/
├── app/
│   ├── controllers/        # Logique métier (Auth, Product, Cart, Order, Admin...)
│   ├── models/              # Accès base de données (Database.php)
│   └── views/               # Templates PHP (home, products, cart, admin...)
│       └── layouts/         # Header et Footer communs
├── config/
│   └── config.php           # Configuration, helpers, session
├── database/
│   ├── schema.sql            # Schéma de la base de données
│   ├── seed.sql              # Données initiales (24 produits, 6 catégories)
│   └── peche_marine.db       # Base SQLite (créée automatiquement)
├── public/
│   ├── index.php             # Point d'entrée (front controller)
│   └── assets/
│       ├── css/style.css     # Styles + thème sombre + animations
│       ├── js/app.js         # Scroll reveal, compteurs, mode sombre
│       └── images/           # Images produits et avatars
├── router.php                # Routeur URL → Contrôleur
└── .gitignore
```

---

## ✨ Fonctionnalités

### 🛒 Boutique
- Catalogue avec filtres par catégorie et tri
- Fiches produit détaillées avec images
- Panier d'achat (ajout, modification des quantités, suppression)
- Processus de commande complet
- Historique des commandes

### 🎨 Interface
- Thème nautique méditerranéen (bleu océan, turquoise, ambre)
- **Mode sombre** avec persistance via localStorage
- Vagues SVG animées entre les sections
- Bulles d'eau flottantes en arrière-plan
- Animations au défilement (scroll reveal)
- Notifications toast animées
- Page 404 thématique "Perdu en mer 🚢"
- Bouton flottant retour en haut 🌊

### 👤 Utilisateurs
- Inscription / Connexion / Déconnexion
- Profil avec photo d'avatar personnalisable
- Rôles : client et administrateur

### ⚙️ Administration
- Tableau de bord avec statistiques (ventes, commandes, produits)
- Gestion des produits (ajouter, modifier, supprimer)
- Gestion des catégories
- Suivi et mise à jour du statut des commandes

---

## 🔄 Réinitialiser la base de données

Si vous souhaitez repartir à zéro :

```powershell
# Arrêtez le serveur (Ctrl+C) puis exécutez :
Remove-Item database\peche_marine.db

# Relancez le serveur — la base sera recréée automatiquement :
php -S localhost:8000 -t public
```

> La base de données est automatiquement recréée et peuplée avec les 24 produits et 6 catégories au prochain démarrage.

---

## ❓ Résolution de problèmes

| Problème | Solution |
|----------|----------|
| `php n'est pas reconnu comme commande` | PHP n'est pas dans le PATH. Refaites l'étape 2 et **redémarrez votre terminal**. |
| `could not find driver` | L'extension `pdo_sqlite` n'est pas activée. Vérifiez `php.ini` (étape 3). |
| La page affiche du code PHP brut | Utilisez `http://localhost:8000` et non un chemin de fichier. Le serveur doit tourner. |
| Les images ne s'affichent pas | Le dossier `public/assets/images/products/` doit contenir les images (incluses dans le dépôt). |
| Erreur sur l'upload d'avatar | Créez le dossier `public/assets/images/avatars/` (étape 5.4). |
| Le port 8000 est déjà utilisé | Utilisez un autre port : `php -S localhost:9000 -t public` puis accédez à `http://localhost:9000`. |
| Le mode sombre ne fonctionne pas | Videz le cache du navigateur (`Ctrl + Shift + Suppr`) ou vérifiez la console (F12). |

---

## 🛠️ Technologies utilisées

| Technologie | Version | Usage |
|-------------|---------|-------|
| **PHP** | 8.1+ | Backend, routing, contrôleurs |
| **SQLite 3** | Inclus avec PHP | Base de données embarquée |
| **Bootstrap** | 5.3.3 | Framework CSS responsive |
| **Bootstrap Icons** | 1.11.3 | Iconographie |
| **CSS personnalisé** | — | Thème nautique, animations, mode sombre |
| **JavaScript vanilla** | — | Interactions côté client |

---

## 📄 Licence

Projet développé dans le cadre d'un projet de fin d'études.  
© 2026 Pêche Marine TN — Tous droits réservés.
