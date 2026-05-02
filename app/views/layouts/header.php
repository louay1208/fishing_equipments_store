<?php
// Get cart count for navbar badge
$cartCount = 0;
if (isLoggedIn()) {
    $db = Database::get();
    $stmt = $db->prepare("SELECT COALESCE(SUM(lp.quantite), 0) FROM ligne_panier lp
        JOIN panier p ON p.id = lp.panier_id WHERE p.utilisateur_id = ?");
    $stmt->execute([$_SESSION['user_id']]);
    $cartCount = (int)$stmt->fetchColumn();
}
?>
<!DOCTYPE html>
<html lang="fr" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Pêche Marine TN — Votre boutique en ligne de matériel de pêche en Tunisie">
    <title><?= e($pageTitle ?? 'Pêche Marine TN') ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="/assets/css/style.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.4/dist/chart.umd.min.js"></script>
    <script>
        (function(){var t=localStorage.getItem('theme')||'light';document.documentElement.setAttribute('data-theme',t);})();
    </script>
</head>
<body>

<!-- Background Bubbles -->
<div class="bg-bubbles">
    <div class="bubble"></div><div class="bubble"></div><div class="bubble"></div>
    <div class="bubble"></div><div class="bubble"></div><div class="bubble"></div>
    <div class="bubble"></div><div class="bubble"></div><div class="bubble"></div>
    <div class="bubble"></div>
</div>

<!-- Toast Notifications -->
<div class="toast-container">
    <?php if ($msg = flash('success')): ?>
        <div class="toast-notification toast-success">
            <span class="toast-icon">✅</span>
            <span><?= e($msg) ?></span>
            <button class="toast-close">&times;</button>
        </div>
    <?php endif; ?>
    <?php if ($msg = flash('error')): ?>
        <div class="toast-notification toast-error">
            <span class="toast-icon">⚠️</span>
            <span><?= e($msg) ?></span>
            <button class="toast-close">&times;</button>
        </div>
    <?php endif; ?>
</div>

<!-- Back to Top -->
<button class="back-to-top" id="backToTop" title="Retour en haut">🌊</button>

<!-- ═══ Premium Navbar ═══ -->
<nav class="navbar navbar-expand-lg">
    <div class="container">
        <!-- Brand -->
        <a class="navbar-brand" href="/">
            <span class="brand-icon">⚓</span>
            <span>Pêche Marine <strong>TN</strong></span>
        </a>

        <!-- Mobile toggle -->
        <div class="d-flex align-items-center gap-2 d-lg-none">
            <button class="theme-toggle" id="themeToggleMobile" title="Thème">
                <i class="bi bi-moon-fill"></i>
            </button>
            <?php if (isLoggedIn()): ?>
                <a href="/cart" class="nav-icon-btn" title="Panier">
                    <i class="bi bi-cart3"></i>
                    <?php if ($cartCount > 0): ?>
                        <span class="nav-icon-badge"><?= $cartCount ?></span>
                    <?php endif; ?>
                </a>
            <?php endif; ?>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>

        <div class="collapse navbar-collapse" id="navbarNav">
            <!-- Left nav links -->
            <ul class="navbar-nav me-auto gap-1">
                <li class="nav-item">
                    <a class="nav-link <?= ($uri ?? '') === '/' ? 'active' : '' ?>" href="/">Accueil</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= str_starts_with($uri ?? '', '/products') ? 'active' : '' ?>" href="/products">Catalogue</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= ($uri ?? '') === '/about' ? 'active' : '' ?>" href="/about">À propos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= ($uri ?? '') === '/faq' ? 'active' : '' ?>" href="/faq">FAQ</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= ($uri ?? '') === '/meteo' ? 'active' : '' ?>" href="/meteo">
                        <i class="bi bi-cloud-sun me-1"></i>Météo
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= ($uri ?? '') === '/contact' ? 'active' : '' ?>" href="/contact">Contact</a>
                </li>
            </ul>

            <!-- Center: search -->
            <div class="navbar-search-wrapper position-relative d-none d-lg-block">
                <div class="nav-search-input">
                    <i class="bi bi-search"></i>
                    <input type="text" id="navbarSearch" placeholder="Rechercher un produit..." autocomplete="off">
                </div>
                <div class="search-results-dropdown" id="searchResults"></div>
            </div>

            <!-- Right: actions -->
            <div class="navbar-actions d-flex align-items-center">
                <?php if (isLoggedIn()): ?>
                    <!-- Icon buttons row -->
                    <div class="nav-icon-group d-none d-lg-flex">
                        <a href="/wishlist" class="nav-icon-btn <?= ($uri ?? '') === '/wishlist' ? 'active' : '' ?>" title="Favoris">
                            <i class="bi bi-heart"></i>
                        </a>
                        <a href="/cart" class="nav-icon-btn <?= ($uri ?? '') === '/cart' ? 'active' : '' ?>" title="Panier">
                            <i class="bi bi-cart3"></i>
                            <?php if ($cartCount > 0): ?>
                                <span class="nav-icon-badge"><?= $cartCount ?></span>
                            <?php endif; ?>
                        </a>
                        <a href="/orders" class="nav-icon-btn <?= ($uri ?? '') === '/orders' ? 'active' : '' ?>" title="Commandes">
                            <i class="bi bi-box-seam"></i>
                        </a>
                    </div>

                    <!-- Mobile: text links -->
                    <ul class="navbar-nav d-lg-none">
                        <li class="nav-item"><a class="nav-link" href="/wishlist"><i class="bi bi-heart me-2"></i>Favoris</a></li>
                        <li class="nav-item"><a class="nav-link" href="/cart"><i class="bi bi-cart3 me-2"></i>Panier<?php if ($cartCount > 0): ?> <span class="badge rounded-pill bg-danger"><?= $cartCount ?></span><?php endif; ?></a></li>
                        <li class="nav-item"><a class="nav-link" href="/orders"><i class="bi bi-box-seam me-2"></i>Commandes</a></li>
                    </ul>

                    <?php if (isAdmin()): ?>
                        <span class="nav-separator d-none d-lg-block"></span>
                        <a class="btn btn-admin-panel <?= str_starts_with($uri ?? '', '/admin') ? 'active' : '' ?>" href="/admin">
                            <i class="bi bi-shield-lock me-1"></i>Admin
                        </a>
                    <?php endif; ?>

                    <span class="nav-separator d-none d-lg-block"></span>

                    <!-- User dropdown -->
                    <div class="dropdown">
                        <a class="nav-user-btn" href="#" data-bs-toggle="dropdown">
                            <?php if (!empty($_SESSION['user_avatar'])): ?>
                                <img src="/assets/images/avatars/<?= e($_SESSION['user_avatar']) ?>" class="nav-user-avatar" alt="">
                            <?php else: ?>
                                <span class="nav-user-initial"><?= strtoupper(mb_substr($_SESSION['user_name'] ?? 'U', 0, 1)) ?></span>
                            <?php endif; ?>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li class="dropdown-header">
                                <div class="fw-bold"><?= e($_SESSION['user_name'] ?? '') ?></div>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="/profile"><i class="bi bi-person me-2"></i>Mon Profil</a></li>
                            <li><a class="dropdown-item" href="/orders"><i class="bi bi-receipt me-2"></i>Mes Commandes</a></li>
                            <li><a class="dropdown-item" href="/wishlist"><i class="bi bi-heart me-2"></i>Mes Favoris</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item text-danger" href="/logout"><i class="bi bi-box-arrow-right me-2"></i>Déconnexion</a></li>
                        </ul>
                    </div>
                <?php else: ?>
                    <div class="nav-auth-btns d-flex align-items-center gap-2">
                        <a class="btn btn-nav-login" href="/login">Connexion</a>
                        <a class="btn btn-nav-signup" href="/register">S'inscrire</a>
                    </div>
                <?php endif; ?>

                <!-- Theme toggle (desktop) -->
                <button class="theme-toggle d-none d-lg-flex" id="themeToggle" title="Changer le thème">
                    <i class="bi bi-moon-fill"></i>
                </button>
            </div>
        </div>
    </div>
</nav>

<main>
