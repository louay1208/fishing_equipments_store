<?php
$catIcons = ['🐟', '🎣', '⚓', '🌊', '🪝', '🧭'];
?>

<!-- Hero -->
<section class="hero">
    <div class="container position-relative">
        <div class="row align-items-center">
            <div class="col-lg-7">
                <p class="text-uppercase fw-semibold mb-2" style="font-size:0.8rem; letter-spacing:0.1em; color: var(--sea);">
                    🌊 La référence pêche en Tunisie
                </p>
                <h1>Équipez-vous<br>comme un <span class="highlight">pro</span></h1>
                <p class="mt-3">Matériel de pêche marine sélectionné pour les passionnés. Cannes, moulinets, leurres et accessoires livrés partout en Tunisie.</p>
                <div class="d-flex gap-2 mt-4 flex-wrap" style="animation:fadeInUp 0.6s 0.2s ease both;">
                    <a href="/products" class="btn btn-primary btn-lg">
                        ⚓ Explorer le Catalogue <i class="bi bi-arrow-right ms-1"></i>
                    </a>
                    <?php if (!isLoggedIn()): ?>
                        <a href="/register" class="btn btn-outline-light btn-lg">Créer un Compte</a>
                    <?php endif; ?>
                </div>
                <div class="d-flex gap-4 mt-4 pt-2" style="animation:fadeInUp 0.6s 0.3s ease both;">
                    <div><span class="fw-bold counter-value" style="color:var(--ocean);" data-count="24" data-suffix="+">0</span> <span class="text-muted" style="font-size:0.85rem;">Produits</span></div>
                    <div><span class="fw-bold counter-value" style="color:var(--ocean);" data-count="6">0</span> <span class="text-muted" style="font-size:0.85rem;">Catégories</span></div>
                    <div><span class="fw-bold" style="color:var(--ocean);">24/7</span> <span class="text-muted" style="font-size:0.85rem;">Disponible</span></div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Categories -->
<section class="py-5">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4 reveal">
            <h2 class="section-title mb-0">🐠 Catégories</h2>
            <a href="/products" class="btn btn-outline-secondary btn-sm">Tout voir <i class="bi bi-arrow-right ms-1"></i></a>
        </div>
        <div class="row g-3">
            <?php foreach ($categories as $i => $cat): ?>
                <div class="col-4 col-md-2 reveal" style="transition-delay:<?= $i * 0.08 ?>s;">
                    <a href="/products?category=<?= $cat['id'] ?>" class="card category-card h-100">
                        <span class="cat-icon"><?= $catIcons[$i] ?? '🐠' ?></span>
                        <span class="cat-name"><?= e($cat['nom']) ?></span>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Wave Divider -->
<div class="wave-divider">
    <svg viewBox="0 0 1200 40" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none">
        <path d="M0,20 C150,40 350,0 500,20 C650,40 850,0 1000,20 C1150,40 1200,30 1200,30 L1200,40 L0,40Z" fill="var(--bg-card)"/>
        <path d="M1200,20 C1050,40 850,0 700,20 C550,40 350,0 200,20 C50,40 0,30 0,30 L0,40 L1200,40Z" fill="var(--bg-card)" opacity="0.5"/>
    </svg>
</div>

<!-- Featured Products -->
<section class="py-5" style="background: var(--bg-card);">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4 reveal">
            <div>
                <h2 class="section-title mb-1">🎣 Nouveautés</h2>
                <p class="text-muted mb-0" style="font-size:0.9rem;">Derniers produits ajoutés au catalogue</p>
            </div>
            <a href="/products" class="btn btn-outline-primary">Catalogue complet <i class="bi bi-arrow-right ms-1"></i></a>
        </div>
        <div class="row g-3">
            <?php foreach ($featured as $product): ?>
                <div class="col-6 col-md-4 col-lg-3 reveal">
                    <div class="card product-card h-100">
                        <a href="/products/<?= $product['id'] ?>">
                            <?php if (!empty($product['image'])): ?>
                                <img src="/assets/images/products/<?= e($product['image']) ?>" class="card-img-top" alt="<?= e($product['nom']) ?>">
                            <?php else: ?>
                                <div class="product-img-placeholder"><i class="bi bi-image"></i></div>
                            <?php endif; ?>
                        </a>
                        <div class="card-body d-flex flex-column">
                            <span class="product-category"><?= e($product['categorie_nom'] ?? '') ?></span>
                            <a href="/products/<?= $product['id'] ?>" class="product-name text-decoration-none"><?= e($product['nom']) ?></a>
                            <div class="mt-auto pt-2 d-flex justify-content-between align-items-center">
                                <span class="product-price"><?= number_format($product['prix'], 2) ?> DT</span>
                                <?php if ($product['quantite_stock'] > 0): ?>
                                    <span class="badge bg-success-subtle text-success">En stock</span>
                                <?php else: ?>
                                    <span class="badge bg-danger-subtle text-danger">Épuisé</span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Wave Divider -->
<div class="wave-divider reverse">
    <svg viewBox="0 0 1200 40" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none">
        <path d="M0,20 C150,40 350,0 500,20 C650,40 850,0 1000,20 C1150,40 1200,30 1200,30 L1200,40 L0,40Z" fill="var(--bg)"/>
        <path d="M1200,20 C1050,40 850,0 700,20 C550,40 350,0 200,20 C50,40 0,30 0,30 L0,40 L1200,40Z" fill="var(--bg)" opacity="0.5"/>
    </svg>
</div>

<!-- CTA -->
<section class="py-5" style="position: relative;">
    <div class="container">
        <div class="card text-center reveal reveal-scale" style="padding: 3rem 2rem; background: linear-gradient(135deg, var(--ocean), var(--ocean-light)); border:none;">
            <h3 class="fw-bold mb-2" style="color:#fff;">🌊 Une question ?</h3>
            <p class="mb-3" style="color: #bae6fd;">Notre équipe est disponible pour vous conseiller sur le choix de votre matériel</p>
            <div><a href="/contact" class="btn" style="background:#fff; color:var(--ocean); font-weight:600; border-radius:var(--radius-sm); padding:0.6rem 1.6rem;"><i class="bi bi-envelope me-1"></i>Contactez-nous</a></div>
        </div>
    </div>
</section>
