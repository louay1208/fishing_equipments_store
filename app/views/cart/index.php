<div class="page-header">
    <div class="container">
        <h1><i class="bi bi-cart3 me-2"></i>Mon Panier</h1>
    </div>
</div>

<div class="container pb-5">
    <?php if (empty($items)): ?>
        <div class="empty-state">
            <div class="icon">🛒</div>
            <h5>Votre panier est vide</h5>
            <p class="text-muted">Explorez notre catalogue et ajoutez des produits</p>
            <a href="/products" class="btn btn-primary">Voir le Catalogue</a>
        </div>
    <?php else: ?>
        <div class="row g-4">
            <!-- Cart Items -->
            <div class="col-lg-8">
                <div class="card">
                    <div class="table-responsive">
                        <table class="table cart-table mb-0 align-middle">
                            <thead>
                                <tr>
                                    <th>Produit</th>
                                    <th>Prix</th>
                                    <th>Quantité</th>
                                    <th>Total</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($items as $item): ?>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center gap-3">
                                                <div class="cart-item-img d-flex align-items-center justify-content-center" style="background: var(--gray-100); color: var(--gray-300);">
                                                    <i class="bi bi-image"></i>
                                                </div>
                                                <div>
                                                    <a href="/products/<?= $item['produit_id'] ?>" class="fw-semibold text-decoration-none text-dark"><?= e($item['nom']) ?></a>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-nowrap"><?= number_format($item['prix'], 2) ?> DT</td>
                                        <td>
                                            <form method="POST" action="/cart/update" class="qty-control">
                                                <input type="hidden" name="line_id" value="<?= $item['id'] ?>">
                                                <button type="submit" name="quantity" value="<?= $item['quantite'] - 1 ?>" class="btn btn-outline-secondary btn-sm qty-btn" data-action="minus">−</button>
                                                <input type="text" value="<?= $item['quantite'] ?>" readonly>
                                                <button type="submit" name="quantity" value="<?= $item['quantite'] + 1 ?>" class="btn btn-outline-secondary btn-sm qty-btn" data-action="plus">+</button>
                                            </form>
                                        </td>
                                        <td class="fw-bold text-nowrap"><?= number_format($item['prix'] * $item['quantite'], 2) ?> DT</td>
                                        <td>
                                            <form method="POST" action="/cart/remove">
                                                <input type="hidden" name="line_id" value="<?= $item['id'] ?>">
                                                <button type="submit" class="btn btn-sm text-danger" title="Supprimer">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Order Summary -->
            <div class="col-lg-4">
                <div class="card p-4">
                    <h5 class="fw-bold mb-3">Résumé</h5>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Sous-total</span>
                        <span><?= number_format($subtotal, 2) ?> DT</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Livraison</span>
                        <span><?= number_format($shipping, 2) ?> DT</span>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between mb-3">
                        <span class="fw-bold">Total</span>
                        <span class="fw-bold price-tag" style="font-size: 1.25rem;"><?= number_format($total, 2) ?> DT</span>
                    </div>
                    <a href="/checkout" class="btn btn-primary w-100">
                        <i class="bi bi-credit-card me-1"></i>Passer la Commande
                    </a>
                    <a href="/products" class="btn btn-outline-secondary w-100 mt-2">
                        <i class="bi bi-arrow-left me-1"></i>Continuer les Achats
                    </a>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>
