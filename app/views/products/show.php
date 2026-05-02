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
            
            <!-- Rating Summary -->
            <?php if (!empty($reviews)): ?>
                <div class="d-flex align-items-center gap-2 mb-3">
                    <div class="star-display">
                        <?php for ($i = 1; $i <= 5; $i++): ?>
                            <i class="bi bi-star<?= $i <= round($avgRating) ? '-fill' : ($i - 0.5 <= $avgRating ? '-half' : '') ?>" style="color:#f59e0b;"></i>
                        <?php endfor; ?>
                    </div>
                    <span class="fw-bold" style="color:#f59e0b;"><?= $avgRating ?></span>
                    <span class="text-muted" style="font-size:0.85rem;">(<?= count($reviews) ?> avis)</span>
                </div>
            <?php endif; ?>

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

            <!-- Action Buttons -->
            <div class="d-flex gap-3 align-items-center flex-wrap">
                <?php if (isLoggedIn() && $product['quantite_stock'] > 0): ?>
                    <form method="POST" action="/cart/add" class="add-to-cart-form">
                        <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                        <div class="d-flex align-items-center gap-3">
                            <input type="number" name="quantity" value="1" min="1" max="<?= $product['quantite_stock'] ?>" 
                                   class="form-control" style="width: 80px;">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="bi bi-cart-plus me-2"></i>Ajouter au Panier
                            </button>
                        </div>
                    </form>
                <?php elseif (!isLoggedIn()): ?>
                    <a href="/login" class="btn btn-primary btn-lg">
                        <i class="bi bi-box-arrow-in-right me-1"></i>Connectez-vous pour acheter
                    </a>
                <?php endif; ?>

                <!-- Wishlist button -->
                <?php if (isLoggedIn()): ?>
                    <form method="POST" action="/wishlist/toggle">
                        <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                        <button type="submit" class="btn btn-<?= $inWishlist ? 'danger' : 'outline-danger' ?> btn-lg" title="<?= $inWishlist ? 'Retirer des favoris' : 'Ajouter aux favoris' ?>">
                            <i class="bi bi-heart<?= $inWishlist ? '-fill' : '' ?>"></i>
                        </button>
                    </form>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Reviews Section -->
    <div class="mt-5 reveal">
        <h3 class="section-title mb-4" style="color:var(--ocean);">
            ⭐ Avis Clients
            <?php if (!empty($reviews)): ?>
                <span class="badge ms-2" style="background:var(--sea-subtle); color:var(--ocean); font-size:0.7rem;"><?= count($reviews) ?></span>
            <?php endif; ?>
        </h3>

        <div class="row g-4">
            <!-- Review Form -->
            <div class="col-lg-4">
                <div class="card p-4" style="border-top: 3px solid var(--sand);">
                    <?php if (!isLoggedIn()): ?>
                        <p class="text-muted text-center mb-3">Connectez-vous pour donner votre avis.</p>
                        <a href="/login" class="btn btn-primary btn-sm"><i class="bi bi-box-arrow-in-right me-1"></i>Connexion</a>
                    <?php elseif ($userReviewed): ?>
                        <div class="text-center">
                            <div style="font-size:2rem;">✅</div>
                            <p class="text-muted mb-0">Vous avez déjà donné votre avis sur ce produit.</p>
                        </div>
                    <?php else: ?>
                        <h6 class="fw-bold mb-3" style="color:var(--ocean);"><i class="bi bi-pencil-square me-1"></i>Donner votre avis</h6>
                        <form method="POST" action="/reviews/store">
                            <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Note *</label>
                                <div class="star-rating" id="starRating">
                                    <?php for ($i = 1; $i <= 5; $i++): ?>
                                        <input type="radio" name="note" value="<?= $i ?>" id="star<?= $i ?>" required <?= $i === 5 ? 'checked' : '' ?>>
                                        <label for="star<?= $i ?>" title="<?= $i ?> étoile<?= $i > 1 ? 's' : '' ?>"><i class="bi bi-star-fill"></i></label>
                                    <?php endfor; ?>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Commentaire</label>
                                <textarea name="commentaire" class="form-control" rows="3" placeholder="Partagez votre expérience..."></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="bi bi-send me-1"></i>Publier l'avis
                            </button>
                        </form>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Reviews List -->
            <div class="col-lg-8">
                <?php if (empty($reviews)): ?>
                    <div class="card p-4 text-center">
                        <div style="font-size:2.5rem; margin-bottom:0.5rem;">💬</div>
                        <p class="text-muted mb-0">Aucun avis pour le moment. Soyez le premier à donner votre avis !</p>
                    </div>
                <?php else: ?>
                    <div class="d-flex flex-column gap-3">
                        <?php foreach ($reviews as $review): ?>
                            <div class="card p-3">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div class="d-flex align-items-center gap-2">
                                        <?php if (!empty($review['user_avatar'])): ?>
                                            <img src="/assets/images/avatars/<?= e($review['user_avatar']) ?>" style="width:36px;height:36px;border-radius:50%;object-fit:cover;">
                                        <?php else: ?>
                                            <div style="width:36px;height:36px;border-radius:50%;background:var(--sea-subtle);display:flex;align-items:center;justify-content:center;color:var(--ocean);font-weight:700;">
                                                <?= strtoupper(substr($review['user_prenom'], 0, 1)) ?>
                                            </div>
                                        <?php endif; ?>
                                        <div>
                                            <div class="fw-bold" style="font-size:0.9rem;"><?= e($review['user_prenom'] . ' ' . $review['user_nom']) ?></div>
                                            <div class="text-muted" style="font-size:0.75rem;"><?= date('d/m/Y', strtotime($review['created_at'])) ?></div>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center gap-2">
                                        <div>
                                            <?php for ($i = 1; $i <= 5; $i++): ?>
                                                <i class="bi bi-star<?= $i <= $review['note'] ? '-fill' : '' ?>" style="color:#f59e0b; font-size:0.8rem;"></i>
                                            <?php endfor; ?>
                                        </div>
                                        <?php if (isLoggedIn() && ($review['utilisateur_id'] == $_SESSION['user_id'] || isAdmin())): ?>
                                            <form method="POST" action="/reviews/delete" style="display:inline;">
                                                <input type="hidden" name="review_id" value="<?= $review['id'] ?>">
                                                <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                                                <button type="submit" class="btn btn-sm text-muted p-0" title="Supprimer" onclick="return confirm('Supprimer cet avis ?')">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <?php if ($review['commentaire']): ?>
                                    <p class="mt-2 mb-0 text-muted" style="font-size:0.9rem;"><?= e($review['commentaire']) ?></p>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Related Products -->
    <?php if (!empty($related)): ?>
        <div class="mt-5 reveal">
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
