<div class="container py-4">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">🏠 Accueil</a></li>
            <li class="breadcrumb-item"><a href="/products">Catalogue</a></li>
            <?php if ($product['categorie_nom']): ?>
                <li class="breadcrumb-item"><a href="/products?category=<?= $product['categorie_id'] ?>"><?= e($product['categorie_nom']) ?></a></li>
            <?php endif; ?>
            <li class="breadcrumb-item active"><?= e($product['nom']) ?></li>
        </ol>
    </nav>

    <div class="row g-4">
        <!-- Product Image -->
        <div class="col-md-5">
            <div class="card" style="overflow:hidden;">
                <?php if (!empty($product['image'])): ?>
                    <img src="/assets/images/products/<?= e($product['image']) ?>" alt="<?= e($product['nom']) ?>" style="width:100%; height:400px; object-fit:cover; transition: transform 0.4s;" onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'">
                <?php else: ?>
                    <div class="product-img-placeholder" style="height: 400px; font-size: 5rem;"><i class="bi bi-image"></i></div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Product Details -->
        <div class="col-md-7">
            <span class="badge mb-2" style="background:var(--sea-subtle); color:var(--ocean); font-weight:600;"><?= e($product['categorie_nom'] ?? 'Non classé') ?></span>
            <h1 class="fw-bold mb-2" style="font-size: 1.75rem; color:var(--ocean);"><?= e($product['nom']) ?></h1>
            
            <div class="mb-3">
                <span style="font-size: 2rem; font-weight:800; color:var(--sand);"><?= number_format($product['prix'], 2) ?> DT</span>
            </div>

            <div class="mb-3">
                <?php if ($product['quantite_stock'] > 0): ?>
                    <span class="badge bg-success-subtle text-success fs-6">
                        <i class="bi bi-check-circle me-1"></i>En stock (<?= $product['quantite_stock'] ?> disponible<?= $product['quantite_stock'] > 1 ? 's' : '' ?>)
                    </span>
                <?php else: ?>
                    <span class="badge bg-danger-subtle text-danger fs-6">
                        <i class="bi bi-x-circle me-1"></i>Rupture de stock
                    </span>
                <?php endif; ?>
            </div>

            <?php if ($product['description']): ?>
                <div class="mb-4">
                    <h6 class="fw-bold" style="color:var(--ocean);"><i class="bi bi-info-circle me-1"></i>Description</h6>
                    <p class="text-muted"><?= e($product['description']) ?></p>
                </div>
            <?php endif; ?>

            <!-- Features -->
            <div class="d-flex gap-3 mb-4 flex-wrap">
                <div class="d-flex align-items-center gap-2" style="font-size:0.85rem; color:var(--text-secondary);">
                    <span style="width:32px;height:32px;border-radius:8px;background:var(--sea-subtle);display:flex;align-items:center;justify-content:center;">🚚</span>
                    Livraison Tunisie
                </div>
                <div class="d-flex align-items-center gap-2" style="font-size:0.85rem; color:var(--text-secondary);">
                    <span style="width:32px;height:32px;border-radius:8px;background:var(--sand-subtle);display:flex;align-items:center;justify-content:center;">🛡️</span>
                    Qualité garantie
                </div>
                <div class="d-flex align-items-center gap-2" style="font-size:0.85rem; color:var(--text-secondary);">
                    <span style="width:32px;height:32px;border-radius:8px;background:var(--sea-subtle);display:flex;align-items:center;justify-content:center;">📞</span>
                    Support 24/7
                </div>
            </div>

            <?php if (isLoggedIn() && $product['quantite_stock'] > 0): ?>
                <form method="POST" action="/cart/add" class="add-to-cart-form">
                    <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <label class="form-label mb-0 fw-bold">Quantité :</label>
                        <input type="number" name="quantity" value="1" min="1" max="<?= $product['quantite_stock'] ?>" 
                               class="form-control" style="width: 80px;">
                    </div>
                    <button type="submit" class="btn btn-primary btn-lg">
                        <i class="bi bi-cart-plus me-2"></i>Ajouter au Panier
                    </button>
                </form>
            <?php elseif (!isLoggedIn()): ?>
                <a href="/login" class="btn btn-primary btn-lg">
                    <i class="bi bi-box-arrow-in-right me-1"></i>Connectez-vous pour acheter
                </a>
            <?php endif; ?>
        </div>
    </div>

    <!-- Related Products -->
    <?php if (!empty($related)): ?>
        <div class="mt-5">
            <h3 class="section-title" style="color:var(--ocean);">🐟 Produits Similaires</h3>
            <div class="row g-3">
                <?php foreach ($related as $rel): ?>
                    <div class="col-6 col-md-3">
                        <div class="card product-card h-100">
                            <a href="/products/<?= $rel['id'] ?>">
                                <?php if (!empty($rel['image'])): ?>
                                    <img src="/assets/images/products/<?= e($rel['image']) ?>" class="card-img-top" alt="<?= e($rel['nom']) ?>" style="height:150px;">
                                <?php else: ?>
                                    <div class="product-img-placeholder" style="height:150px;"><i class="bi bi-image"></i></div>
                                <?php endif; ?>
                            </a>
                            <div class="card-body">
                                <a href="/products/<?= $rel['id'] ?>" class="product-name text-decoration-none"><?= e($rel['nom']) ?></a>
                                <div class="product-price mt-1"><?= number_format($rel['prix'], 2) ?> DT</div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>
</div>
