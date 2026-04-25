<div class="page-header">
    <div class="container">
        <h1><i class="bi bi-credit-card me-2"></i>Passer la Commande</h1>
    </div>
</div>

<div class="container pb-5">
    <div class="row g-4">
        <!-- Delivery Form -->
        <div class="col-lg-7">
            <div class="card p-4">
                <h5 class="fw-bold mb-3">Informations de Livraison</h5>
                <form method="POST" action="/orders">
                    <div class="mb-3">
                        <label for="adresse" class="form-label">Adresse de livraison *</label>
                        <textarea class="form-control" id="adresse" name="adresse" rows="3" required placeholder="Rue, ville, code postal..."><?= e($user['adresse'] ?? '') ?></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="telephone" class="form-label">Téléphone *</label>
                        <input type="tel" class="form-control" id="telephone" name="telephone" value="<?= e($user['telephone'] ?? '') ?>" required placeholder="XX XXX XXX">
                    </div>
                    <div class="mb-4 p-3 rounded" style="background: var(--sand-50); border: 1px solid var(--gray-200);">
                        <h6 class="fw-bold mb-2"><i class="bi bi-cash-coin me-1"></i>Mode de Paiement</h6>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="payment" id="cod" value="cod" checked>
                            <label class="form-check-label" for="cod">Paiement à la livraison</label>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary btn-lg w-100">
                        <i class="bi bi-check-circle me-1"></i>Confirmer la Commande
                    </button>
                </form>
            </div>
        </div>

        <!-- Order Summary -->
        <div class="col-lg-5">
            <div class="card p-4">
                <h5 class="fw-bold mb-3">Récapitulatif</h5>
                <?php foreach ($items as $item): ?>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted"><?= e($item['nom']) ?> × <?= $item['quantite'] ?></span>
                        <span><?= number_format($item['prix'] * $item['quantite'], 2) ?> DT</span>
                    </div>
                <?php endforeach; ?>
                <hr>
                <div class="d-flex justify-content-between mb-1">
                    <span class="text-muted">Sous-total</span>
                    <span><?= number_format($subtotal, 2) ?> DT</span>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted">Livraison</span>
                    <span><?= number_format($shipping, 2) ?> DT</span>
                </div>
                <hr>
                <div class="d-flex justify-content-between">
                    <span class="fw-bold fs-5">Total</span>
                    <span class="fw-bold fs-5 price-tag"><?= number_format($total, 2) ?> DT</span>
                </div>
            </div>
        </div>
    </div>
</div>
