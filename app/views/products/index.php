<div class="page-header">
    <div class="container">
        <h1><i class="bi bi-grid me-2"></i>Catalogue</h1>
        <p><?= $total ?> produit<?= $total > 1 ? 's' : '' ?> trouvé<?= $total > 1 ? 's' : '' ?></p>
    </div>
</div>

<div class="container pb-5">
    <div class="row g-4">
        <!-- Sidebar Filters -->
        <div class="col-lg-3">
            <div class="card p-3 mb-3">
                <h6 class="fw-bold mb-3"><i class="bi bi-search me-1"></i>Rechercher</h6>
                <form method="GET" action="/products" id="search-form">
                    <?php if ($categoryId): ?>
                        <input type="hidden" name="category" value="<?= (int)$categoryId ?>">
                    <?php endif; ?>
                    <input type="text" class="form-control" id="product-search" name="q" 
                           value="<?= e($search) ?>" placeholder="Nom du produit...">
                </form>
            </div>
            
            <div class="card p-3 mb-3">
                <h6 class="fw-bold mb-3"><i class="bi bi-tag me-1"></i>Catégories</h6>
                <a href="/products" class="d-block mb-1 text-decoration-none <?= !$categoryId ? 'fw-bold' : '' ?>" 
                   style="color: <?= !$categoryId ? 'var(--accent)' : 'var(--text-secondary)' ?>">
                    Toutes les catégories
                </a>
                <?php foreach ($categories as $cat): ?>
                    <a href="/products?category=<?= $cat['id'] ?>" 
                       class="d-block mb-1 text-decoration-none <?= $categoryId == $cat['id'] ? 'fw-bold' : '' ?>"
                       style="color: <?= $categoryId == $cat['id'] ? 'var(--accent)' : 'var(--text-secondary)' ?>">
                        <?= e($cat['nom']) ?>
                    </a>
                <?php endforeach; ?>
            </div>

            <div class="card p-3">
                <h6 class="fw-bold mb-3"><i class="bi bi-sort-down me-1"></i>Trier par</h6>
                <form method="GET" action="/products" id="sort-form">
                    <?php if ($categoryId): ?><input type="hidden" name="category" value="<?= (int)$categoryId ?>"><?php endif; ?>
                    <?php if ($search): ?><input type="hidden" name="q" value="<?= e($search) ?>"><?php endif; ?>
                    <select class="form-select" name="sort" onchange="this.form.submit()">
                        <option value="newest" <?= $sort === 'newest' ? 'selected' : '' ?>>Plus récents</option>
                        <option value="price_asc" <?= $sort === 'price_asc' ? 'selected' : '' ?>>Prix croissant</option>
                        <option value="price_desc" <?= $sort === 'price_desc' ? 'selected' : '' ?>>Prix décroissant</option>
                        <option value="name" <?= $sort === 'name' ? 'selected' : '' ?>>Nom A-Z</option>
                    </select>
                </form>
            </div>
        </div>

        <!-- Product Grid -->
        <div class="col-lg-9">
            <?php if (empty($products)): ?>
                <div class="empty-state">
                    <div class="icon">🐟</div>
                    <h5>Aucun produit trouvé</h5>
                    <p class="text-muted">Essayez avec d'autres critères de recherche</p>
                    <a href="/products" class="btn btn-primary">Voir tout le catalogue</a>
                </div>
            <?php else: ?>
                <div class="row g-3">
                    <?php foreach ($products as $product): ?>
                        <div class="col-6 col-md-4">
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
                                    <div class="mt-auto pt-2">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span class="product-price"><?= number_format($product['prix'], 2) ?> DT</span>
                                            <?php if ($product['quantite_stock'] > 0): ?>
                                                <span class="badge bg-success-subtle text-success">En stock</span>
                                            <?php else: ?>
                                                <span class="badge bg-danger-subtle text-danger">Épuisé</span>
                                            <?php endif; ?>
                                        </div>
                                        <?php if (isLoggedIn() && $product['quantite_stock'] > 0): ?>
                                            <form method="POST" action="/cart/add" class="mt-2 add-to-cart-form">
                                                <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                                                <input type="hidden" name="quantity" value="1">
                                                <button type="submit" class="btn btn-primary btn-sm w-100">
                                                    <i class="bi bi-cart-plus me-1"></i>Ajouter
                                                </button>
                                            </form>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <!-- Pagination -->
                <?php if ($totalPages > 1): ?>
                    <nav class="mt-4">
                        <ul class="pagination justify-content-center">
                            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                                <li class="page-item <?= $i === $page ? 'active' : '' ?>">
                                    <a class="page-link" href="/products?page=<?= $i ?><?= $categoryId ? '&category='.$categoryId : '' ?><?= $search ? '&q='.urlencode($search) : '' ?><?= $sort !== 'newest' ? '&sort='.$sort : '' ?>">
                                        <?= $i ?>
                                    </a>
                                </li>
                            <?php endfor; ?>
                        </ul>
                    </nav>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>
</div>
