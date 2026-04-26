<?php
$catIcons = ['🎣', '⚙️', '🐟', '🧵', '🪝', '🎒'];
?>

<!-- Hero -->
<section class="hero">
    <div class="container position-relative">
        <div class="row align-items-center">
            <div class="col-lg-7">
                <p class="text-uppercase fw-semibold mb-2" style="font-size:0.8rem; letter-spacing:0.1em; color: var(--accent);">
                    🎣 La référence pêche en Tunisie
                </p>
                <h1>Équipez-vous<br>comme un <span class="highlight">pro</span></h1>
                <p class="mt-3">Matériel de pêche marine sélectionné pour les passionnés. Cannes, moulinets, leurres et accessoires livrés partout en Tunisie.</p>
                <div class="d-flex gap-2 mt-4 flex-wrap">
                    <a href="/products" class="btn btn-primary btn-lg">
                        Explorer le Catalogue <i class="bi bi-arrow-right ms-1"></i>
                    </a>
                    <?php if (!isLoggedIn()): ?>
                        <a href="/register" class="btn btn-outline-light btn-lg">Créer un Compte</a>
                    <?php endif; ?>
                </div>
                <div class="d-flex gap-4 mt-4 pt-2">
                    <div><span class="fw-bold" style="color:var(--accent);">24+</span> <span class="text-muted" style="font-size:0.85rem;">Produits</span></div>
                    <div><span class="fw-bold" style="color:var(--accent);">6</span> <span class="text-muted" style="font-size:0.85rem;">Catégories</span></div>
                    <div><span class="fw-bold" style="color:var(--accent);">24/7</span> <span class="text-muted" style="font-size:0.85rem;">Disponible</span></div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Categories -->
<section class="py-5">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="section-title mb-0">Catégories</h2>
            <a href="/products" class="btn btn-outline-secondary btn-sm">Tout voir <i class="bi bi-arrow-right ms-1"></i></a>
        </div>
        <div class="row g-3">
            <?php foreach ($categories as $i => $cat): ?>
                <div class="col-4 col-md-2">
                    <a href="/products?category=<?= $cat['id'] ?>" class="card category-card h-100">
                        <span class="cat-icon"><?= $catIcons[$i] ?? '🐠' ?></span>
                        <span class="cat-name"><?= e($cat['nom']) ?></span>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Featured Products -->
<section class="py-5" style="border-top: 1px solid var(--border);">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="section-title mb-1">Nouveautés</h2>
                <p class="text-muted mb-0" style="font-size:0.9rem;">Derniers produits ajoutés au catalogue</p>
            </div>
            <a href="/products" class="btn btn-outline-primary">Catalogue complet <i class="bi bi-arrow-right ms-1"></i></a>
        </div>
        <div class="row g-3">
            <?php foreach ($featured as $product): ?>
                <div class="col-6 col-md-4 col-lg-3">
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

<!-- CTA -->
<section class="py-5" style="border-top: 1px solid var(--border);">
    <div class="container">
        <div class="card text-center" style="padding: 3rem 2rem; background: var(--accent-subtle);">
            <h3 class="fw-bold mb-2">Une question ?</h3>
            <p class="mb-3" style="color: var(--text-muted);">Notre équipe est disponible pour vous conseiller sur le choix de votre matériel</p>
            <div><a href="/contact" class="btn btn-primary"><i class="bi bi-envelope me-1"></i>Contactez-nous</a></div>
        </div>
    </div>
</section>
