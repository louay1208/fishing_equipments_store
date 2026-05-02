

<!-- Hero -->
<section class="hero">
    <div class="container position-relative">
        <div class="row align-items-center">
            <div class="col-lg-7">
                <h1>Matériel de <span class="highlight">Pêche</span><br>en Tunisie</h1>
                <p class="mt-3">Cannes, moulinets, leurres et accessoires livrés partout en Tunisie.</p>
                <div class="d-flex gap-2 mt-4 flex-wrap" style="animation:fadeInUp 0.6s 0.2s ease both;">
                    <a href="/products" class="btn btn-primary btn-lg">
                        Voir le Catalogue <i class="bi bi-arrow-right ms-1"></i>
                    </a>
                    <?php if (!isLoggedIn()): ?>
                        <a href="/register" class="btn btn-outline-light btn-lg">Créer un Compte</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Categories -->
<section class="py-5">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4 reveal">
            <h2 class="section-title mb-0">Catégories</h2>
            <a href="/products" class="btn btn-outline-secondary btn-sm">Tout voir <i class="bi bi-arrow-right ms-1"></i></a>
        </div>
        <div class="row g-3">
            <?php foreach ($categories as $i => $cat): ?>
                <div class="col-6 col-md-3 reveal" style="transition-delay:<?= $i * 0.08 ?>s;">
                    <a href="/products?category=<?= $cat['id'] ?>" class="card category-card h-100">
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
            <h2 class="section-title mb-1">Nos Produits</h2>
            <a href="/products" class="btn btn-outline-primary">Tout voir <i class="bi bi-arrow-right ms-1"></i></a>
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
