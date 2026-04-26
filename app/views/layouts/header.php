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
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Pêche Marine TN — Votre boutique en ligne de matériel de pêche en Tunisie">
    <title><?= e($pageTitle ?? 'Pêche Marine TN') ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="/assets/css/style.css" rel="stylesheet">
</head>
<body>

<!-- Flash Messages -->
<?php if ($msg = flash('success')): ?>
    <div class="flash-message alert alert-success alert-dismissible fade show" role="alert">
        <i class="bi bi-check-circle me-2"></i><?= e($msg) ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>
<?php if ($msg = flash('error')): ?>
    <div class="flash-message alert alert-danger alert-dismissible fade show" role="alert">
        <i class="bi bi-exclamation-circle me-2"></i><?= e($msg) ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg">
    <div class="container">
        <a class="navbar-brand" href="/">
            <span class="brand-icon">🎣</span> Pêche Marine TN
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link <?= ($uri ?? '') === '/' ? 'active' : '' ?>" href="/">
                        <i class="bi bi-house me-1"></i>Accueil
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= str_starts_with($uri ?? '', '/products') ? 'active' : '' ?>" href="/products">
                        <i class="bi bi-grid me-1"></i>Catalogue
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= ($uri ?? '') === '/contact' ? 'active' : '' ?>" href="/contact">
                        <i class="bi bi-envelope me-1"></i>Contact
                    </a>
                </li>
            </ul>
            <ul class="navbar-nav">
                <?php if (isLoggedIn()): ?>
                    <li class="nav-item">
                        <a class="nav-link <?= ($uri ?? '') === '/cart' ? 'active' : '' ?>" href="/cart">
                            <i class="bi bi-cart3 me-1"></i>Panier
                            <?php if ($cartCount > 0): ?>
                                <span class="badge rounded-pill" style="background:#ef4444;color:#fff;"><?= $cartCount ?></span>
                            <?php endif; ?>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= ($uri ?? '') === '/orders' ? 'active' : '' ?>" href="/orders">
                            <i class="bi bi-box-seam me-1"></i>Commandes
                        </a>
                    </li>
                    <?php if (isAdmin()): ?>
                        <li class="nav-item">
                            <a class="nav-link <?= str_starts_with($uri ?? '', '/admin') ? 'active' : '' ?>" href="/admin">
                                <i class="bi bi-speedometer2 me-1"></i>Admin
                            </a>
                        </li>
                    <?php endif; ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                            <i class="bi bi-person-circle me-1"></i><?= e($_SESSION['user_name'] ?? '') ?>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="/profile"><i class="bi bi-person me-2"></i>Mon Profil</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item text-danger" href="/logout"><i class="bi bi-box-arrow-right me-2"></i>Déconnexion</a></li>
                        </ul>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link" href="/login">
                            <i class="bi bi-box-arrow-in-right me-1"></i>Connexion
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-primary btn-sm ms-2 mt-1" href="/register">S'inscrire</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>

<main>
