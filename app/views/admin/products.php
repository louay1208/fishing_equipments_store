<div class="page-header">
    <div class="container d-flex justify-content-between align-items-center">
        <h1><i class="bi bi-box me-2"></i>Produits</h1>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addProductModal">
            <i class="bi bi-plus-lg me-1"></i>Ajouter un Produit
        </button>
    </div>
</div>

<div class="container pb-5">
    <a href="/admin" class="btn btn-outline-secondary btn-sm mb-3"><i class="bi bi-arrow-left me-1"></i>Dashboard</a>
    
    <div class="card">
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead>
                    <tr><th>ID</th><th>Nom</th><th>Catégorie</th><th>Prix</th><th>Stock</th><th>Actions</th></tr>
                </thead>
                <tbody>
                    <?php foreach ($products as $p): ?>
                        <tr>
                            <td class="text-muted">#<?= $p['id'] ?></td>
                            <td class="fw-semibold"><?= e($p['nom']) ?></td>
                            <td><span class="badge bg-light text-dark"><?= e($p['categorie_nom'] ?? '—') ?></span></td>
                            <td class="price-tag"><?= number_format($p['prix'], 2) ?> DT</td>
                            <td>
                                <?php if ($p['quantite_stock'] > 5): ?>
                                    <span class="badge bg-success"><?= $p['quantite_stock'] ?></span>
                                <?php elseif ($p['quantite_stock'] > 0): ?>
                                    <span class="badge bg-warning text-dark"><?= $p['quantite_stock'] ?></span>
                                <?php else: ?>
                                    <span class="badge bg-danger">0</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <button class="btn btn-sm btn-outline-primary me-1" 
                                    data-bs-toggle="modal" data-bs-target="#editProduct<?= $p['id'] ?>">
                                    <i class="bi bi-pencil"></i>
                                </button>
                                <form method="POST" action="/admin/products/delete" class="d-inline confirm-delete">
                                    <input type="hidden" name="id" value="<?= $p['id'] ?>">
                                    <button type="submit" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                                </form>
                            </td>
                        </tr>

                        <!-- Edit Modal -->
                        <div class="modal fade" id="editProduct<?= $p['id'] ?>" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form method="POST" action="/admin/products/update" enctype="multipart/form-data">
                                        <input type="hidden" name="id" value="<?= $p['id'] ?>">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Modifier le Produit</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label class="form-label">Nom</label>
                                                <input type="text" class="form-control" name="nom" value="<?= e($p['nom']) ?>" required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Description</label>
                                                <textarea class="form-control" name="description" rows="3"><?= e($p['description'] ?? '') ?></textarea>
                                            </div>
                                            <div class="row g-3 mb-3">
                                                <div class="col-6">
                                                    <label class="form-label">Prix (DT)</label>
                                                    <input type="number" class="form-control" name="prix" step="0.01" value="<?= $p['prix'] ?>" required>
                                                </div>
                                                <div class="col-6">
                                                    <label class="form-label">Stock</label>
                                                    <input type="number" class="form-control" name="quantite_stock" value="<?= $p['quantite_stock'] ?>" required>
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Catégorie</label>
                                                <select class="form-select" name="categorie_id">
                                                    <option value="">— Aucune —</option>
                                                    <?php foreach ($categories as $c): ?>
                                                        <option value="<?= $c['id'] ?>" <?= $c['id'] == $p['categorie_id'] ? 'selected' : '' ?>><?= e($c['nom']) ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Image</label>
                                                <?php if (!empty($p['image'])): ?>
                                                    <div class="mb-2">
                                                        <img src="/assets/images/products/<?= e($p['image']) ?>" style="height:60px;border-radius:6px;" alt="">
                                                        <span class="text-muted" style="font-size:0.78rem;">Image actuelle</span>
                                                    </div>
                                                <?php endif; ?>
                                                <input type="file" class="form-control" name="image" accept="image/*">
                                                <div class="form-text">Laisser vide pour garder l'image actuelle</div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Annuler</button>
                                            <button type="submit" class="btn btn-primary">Enregistrer</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Add Product Modal -->
<div class="modal fade" id="addProductModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="/admin/products/store" enctype="multipart/form-data">
                <div class="modal-header">
                    <h5 class="modal-title">Ajouter un Produit</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nom *</label>
                        <input type="text" class="form-control" name="nom" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea class="form-control" name="description" rows="3"></textarea>
                    </div>
                    <div class="row g-3 mb-3">
                        <div class="col-6">
                            <label class="form-label">Prix (DT) *</label>
                            <input type="number" class="form-control" name="prix" step="0.01" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label">Stock *</label>
                            <input type="number" class="form-control" name="quantite_stock" value="0" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Catégorie</label>
                        <select class="form-select" name="categorie_id">
                            <option value="">— Aucune —</option>
                            <?php foreach ($categories as $c): ?>
                                <option value="<?= $c['id'] ?>"><?= e($c['nom']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Image du Produit</label>
                        <input type="file" class="form-control" name="image" accept="image/*">
                        <div class="form-text">JPG, PNG, WebP ou GIF</div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-primary">Ajouter</button>
                </div>
            </form>
        </div>
    </div>
</div>
