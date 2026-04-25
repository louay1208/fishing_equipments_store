<div class="page-header">
    <div class="container d-flex justify-content-between align-items-center">
        <h1><i class="bi bi-tags me-2"></i>Catégories</h1>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCatModal">
            <i class="bi bi-plus-lg me-1"></i>Ajouter
        </button>
    </div>
</div>

<div class="container pb-5">
    <a href="/admin" class="btn btn-outline-secondary btn-sm mb-3"><i class="bi bi-arrow-left me-1"></i>Dashboard</a>

    <div class="row g-3">
        <?php foreach ($categories as $cat): ?>
            <div class="col-md-6 col-lg-4">
                <div class="card p-3">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <h6 class="fw-bold mb-1"><?= e($cat['nom']) ?></h6>
                            <p class="text-muted mb-1" style="font-size: 0.85rem;"><?= e($cat['description'] ?? '') ?></p>
                            <span class="badge bg-light text-dark"><?= $cat['product_count'] ?> produit<?= $cat['product_count'] > 1 ? 's' : '' ?></span>
                        </div>
                        <form method="POST" action="/admin/categories/delete" class="confirm-delete">
                            <input type="hidden" name="id" value="<?= $cat['id'] ?>">
                            <button type="submit" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                        </form>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<!-- Add Category Modal -->
<div class="modal fade" id="addCatModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="/admin/categories/store">
                <div class="modal-header">
                    <h5 class="modal-title">Nouvelle Catégorie</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nom *</label>
                        <input type="text" class="form-control" name="nom" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea class="form-control" name="description" rows="2"></textarea>
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
