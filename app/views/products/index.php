<div class="page-header" style="background: linear-gradient(165deg, var(--sea-subtle) 0%, var(--bg) 100%);">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
            <div>
                <h1 style="color:var(--ocean);"><i class="bi bi-compass me-2"></i>Catalogue</h1>
                <p class="text-muted mb-0">🐟 <?= $total ?> produit<?= $total > 1 ? 's' : '' ?> trouvé<?= $total > 1 ? 's' : '' ?><?= $search ? ' pour "'.e($search).'"' : '' ?></p>
            </div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0" style="font-size:0.85rem;">
                    <li class="breadcrumb-item"><a href="/">Accueil</a></li>
                    <li class="breadcrumb-item active">Catalogue</li>
                </ol>
            </nav>
        </div>
    </div>
</div>

<div class="container pb-5">
    <div class="row g-4">
        <!-- Sidebar Filters -->
        <div class="col-lg-3">
            <!-- Search -->
            <div class="card p-3 mb-3" style="border-top: 3px solid var(--sea);">
                <h6 class="fw-bold mb-3" style="color:var(--ocean);"><i class="bi bi-search me-1"></i>Rechercher</h6>
                <form method="GET" action="/products" id="search-form">
                    <?php if ($categoryId): ?>
                        <input type="hidden" name="category" value="<?= (int)$categoryId ?>">
                    <?php endif; ?>
                    <div class="input-group">
                        <input type="text" class="form-control" id="product-search" name="q" 
                               value="<?= e($search) ?>" placeholder="Nom du produit...">
                        <span class="input-group-text"><i class="bi bi-search"></i></span>
                    </div>
                </form>
            </div>
            
            <!-- Categories -->
            <div class="card p-3 mb-3">
                <h6 class="fw-bold mb-3" style="color:var(--ocean);"><i class="bi bi-tag me-1"></i>Catégories</h6>
                <a href="/products" class="d-flex align-items-center justify-content-between mb-2 text-decoration-none px-2 py-1 rounded <?= !$categoryId ? 'fw-bold' : '' ?>" 
                   style="color: <?= !$categoryId ? 'var(--ocean)' : 'var(--text-secondary)' ?>; <?= !$categoryId ? 'background:var(--sea-subtle);' : '' ?>">
                    <span>🌊 Toutes les catégories</span>
                    <span class="badge" style="background:var(--bg-surface); color:var(--text-muted); font-size:0.7rem;"><?= $total ?></span>
                </a>
                <?php 
                $catIcons = ['🐟', '🎣', '⚓', '🌊', '🪝', '🧭', '🐠', '🦈'];
                foreach ($categories as $ci => $cat): 
                ?>
                    <a href="/products?category=<?= $cat['id'] ?>" 
                       class="d-flex align-items-center justify-content-between mb-1 text-decoration-none px-2 py-1 rounded <?= $categoryId == $cat['id'] ? 'fw-bold' : '' ?>"
                       style="color: <?= $categoryId == $cat['id'] ? 'var(--ocean)' : 'var(--text-secondary)' ?>; <?= $categoryId == $cat['id'] ? 'background:var(--sea-subtle);' : '' ?> transition: all 0.2s;">
                        <span><?= $catIcons[$ci] ?? '🐠' ?> <?= e($cat['nom']) ?></span>
                    </a>
                <?php endforeach; ?>
            </div>

            <!-- Sort -->
            <div class="card p-3 mb-3">
                <h6 class="fw-bold mb-3" style="color:var(--ocean);"><i class="bi bi-sort-down me-1"></i>Trier par</h6>
                <form method="GET" action="/products" id="sort-form">
                    <?php if ($categoryId): ?><input type="hidden" name="category" value="<?= (int)$categoryId ?>"><?php endif; ?>
                    <?php if ($search): ?><input type="hidden" name="q" value="<?= e($search) ?>"><?php endif; ?>
                    <select class="form-select" name="sort" onchange="this.form.submit()">
                        <option value="newest" <?= $sort === 'newest' ? 'selected' : '' ?>>🕐 Plus récents</option>
                        <option value="price_asc" <?= $sort === 'price_asc' ? 'selected' : '' ?>>💰 Prix croissant</option>
                        <option value="price_desc" <?= $sort === 'price_desc' ? 'selected' : '' ?>>💎 Prix décroissant</option>
                        <option value="name" <?= $sort === 'name' ? 'selected' : '' ?>>🔤 Nom A-Z</option>
                    </select>
                </form>
            </div>

            <!-- Help Box -->
            <div class="card p-3 text-center" style="background: linear-gradient(135deg, var(--ocean), var(--ocean-light)); border:none;">
                <div style="font-size:1.5rem; margin-bottom:0.5rem;">🎣</div>
                <h6 class="fw-bold mb-1" style="color:#fff; font-size:0.88rem;">Besoin de conseils ?</h6>
                <p style="color:#bae6fd; font-size:0.78rem; margin-bottom:0.6rem;">Notre équipe vous aide à choisir le bon matériel</p>
                <a href="/contact" class="btn btn-sm" style="background:#fff; color:var(--ocean); font-weight:600; border-radius:6px;">Contactez-nous</a>
            </div>
        </div>

        <!-- Product Grid -->
        <div class="col-lg-9">
            <?php if (empty($products)): ?>
                <div class="empty-state">
                    <div class="icon">🐟</div>
                    <h5 style="color:var(--ocean);">Aucun produit trouvé</h5>
                    <p class="text-muted">Essayez avec d'autres critères de recherche</p>
                    <a href="/products" class="btn btn-primary">Voir tout le catalogue</a>
                </div>
            <?php else: ?>
                <div class="row g-3">
                    <?php foreach ($products as $product): ?>
                        <div class="col-6 col-md-4">
                            <div class="card product-card h-100">
                                <a href="/products/<?= $product['id'] ?>" style="position:relative; display:block; overflow:hidden;">
                                    <?php if (!empty($product['image'])): ?>
                                        <img src="/assets/images/products/<?= e($product['image']) ?>" class="card-img-top" alt="<?= e($product['nom']) ?>">
                                    <?php else: ?>
                                        <div class="product-img-placeholder"><i class="bi bi-image"></i></div>
                                    <?php endif; ?>
                                    <?php if ($product['quantite_stock'] == 0): ?>
                                        <span style="position:absolute;top:8px;right:8px;" class="badge bg-danger">Épuisé</span>
                                    <?php elseif ($product['quantite_stock'] <= 5): ?>
                                        <span style="position:absolute;top:8px;right:8px;" class="badge" style="background:var(--sand-subtle);color:var(--sand);">Dernières pièces</span>
                                    <?php endif; ?>
                                </a>
                                <div class="card-body d-flex flex-column">
                                    <span class="product-category"><?= e($product['categorie_nom'] ?? '') ?></span>
                                    <a href="/products/<?= $product['id'] ?>" class="product-name text-decoration-none"><?= e($product['nom']) ?></a>
                                    <div class="mt-auto pt-2">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span class="product-price"><?= number_format($product['prix'], 2) ?> DT</span>
                                            <?php if ($product['quantite_stock'] > 0): ?>
                                                <span class="badge" style="background:var(--sea-subtle); color:var(--ocean); font-size:0.68rem;">En stock</span>
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
                            <?php if ($page > 1): ?>
                                <li class="page-item">
                                    <a class="page-link" href="/products?page=<?= $page-1 ?><?= $categoryId ? '&category='.$categoryId : '' ?><?= $search ? '&q='.urlencode($search) : '' ?><?= $sort !== 'newest' ? '&sort='.$sort : '' ?>">
                                        <i class="bi bi-chevron-left"></i>
                                    </a>
                                </li>
                            <?php endif; ?>
                            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                                <li class="page-item <?= $i === $page ? 'active' : '' ?>">
                                    <a class="page-link" href="/products?page=<?= $i ?><?= $categoryId ? '&category='.$categoryId : '' ?><?= $search ? '&q='.urlencode($search) : '' ?><?= $sort !== 'newest' ? '&sort='.$sort : '' ?>">
                                        <?= $i ?>
                                    </a>
                                </li>
                            <?php endfor; ?>
                            <?php if ($page < $totalPages): ?>
                                <li class="page-item">
                                    <a class="page-link" href="/products?page=<?= $page+1 ?><?= $categoryId ? '&category='.$categoryId : '' ?><?= $search ? '&q='.urlencode($search) : '' ?><?= $sort !== 'newest' ? '&sort='.$sort : '' ?>">
                                        <i class="bi bi-chevron-right"></i>
                                    </a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </nav>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>
</div>
