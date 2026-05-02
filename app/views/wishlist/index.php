<div class="page-header" style="background: linear-gradient(165deg, var(--sea-subtle) 0%, var(--bg) 100%);">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
            <div>
                <h1 style="color:var(--ocean);"><i class="bi bi-heart me-2"></i>Mes Favoris</h1>
                <p class="text-muted mb-0"><?= count($favorites) ?> produit<?= count($favorites) > 1 ? 's' : '' ?> sauvegardé<?= count($favorites) > 1 ? 's' : '' ?></p>
            </div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0" style="font-size:0.85rem;">
                    <li class="breadcrumb-item"><a href="/">Accueil</a></li>
                    <li class="breadcrumb-item active">Favoris</li>
                </ol>
            </nav>
        </div>
    </div>
</div>

<div class="container pb-5">
    <?php if (empty($favorites)): ?>
        <div class="text-center py-5">
            <div style="font-size:4rem; margin-bottom:1rem;"><i class="bi bi-heart" style="color:var(--ocean);"></i></div>
            <h3 class="fw-bold mb-2" style="color:var(--ocean);">Aucun favori pour le moment</h3>
            <p class="text-muted mb-4">Parcourez notre catalogue et cliquez sur le coeur pour sauvegarder vos produits préférés.</p>
            <a href="/products" class="btn btn-primary"><i class="bi bi-grid me-1"></i>Explorer le Catalogue</a>
        </div>
    <?php else: ?>
        <div class="row g-4">
            <?php foreach ($favorites as $product): ?>
                <div class="col-6 col-md-4 col-lg-3 reveal">
                    <div class="card product-card h-100">
                        <div style="position:relative;">
                            <a href="/products/<?= $product['id'] ?>">
                                <?php if (!empty($product['image'])): ?>
                                    <img src="/assets/images/products/<?= e($product['image']) ?>" class="card-img-top" alt="<?= e($product['nom']) ?>" style="height:200px;">
                                <?php else: ?>
                                    <div class="product-img-placeholder" style="height:200px;"><i class="bi bi-image"></i></div>
                                <?php endif; ?>
                            </a>
                            <!-- Remove from wishlist -->
                            <form method="POST" action="/wishlist/toggle" style="position:absolute; top:8px; right:8px;">
                                <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                                <button type="submit" class="btn btn-sm" style="background:rgba(255,255,255,0.9); border:none; border-radius:50%; width:36px; height:36px; padding:0; color:#ef4444; font-size:1.1rem;" title="Retirer des favoris">
                                    <i class="bi bi-heart-fill"></i>
                                </button>
                            </form>
                        </div>
                        <div class="card-body d-flex flex-column">
                            <?php if ($product['categorie_nom']): ?>
                                <span class="product-category"><?= e($product['categorie_nom']) ?></span>
                            <?php endif; ?>
                            <a href="/products/<?= $product['id'] ?>" class="product-name text-decoration-none"><?= e($product['nom']) ?></a>
                            <div class="mt-auto d-flex justify-content-between align-items-center pt-2">
                                <span class="product-price"><?= number_format($product['prix'], 2) ?> DT</span>
                                <?php if ($product['quantite_stock'] > 0): ?>
                                    <form method="POST" action="/cart/add" class="add-to-cart-form">
                                        <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                                        <input type="hidden" name="quantity" value="1">
                                        <button type="submit" class="btn btn-primary btn-sm">
                                            <i class="bi bi-cart-plus"></i>
                                        </button>
                                    </form>
                                <?php else: ?>
                                    <span class="badge bg-danger-subtle text-danger" style="font-size:0.7rem;">Rupture</span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>
