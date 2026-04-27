<div class="page-header" style="background: linear-gradient(165deg, var(--sea-subtle) 0%, var(--bg) 100%);">
    <div class="container">
        <h1 style="color:var(--ocean);"><i class="bi bi-cart3 me-2"></i>Mon Panier</h1>
    </div>
</div>

<div class="container pb-5">
    <?php if (empty($items)): ?>
        <div class="empty-state">
            <div class="icon">🌊</div>
            <h5 style="color:var(--ocean);">Votre panier est vide</h5>
            <p class="text-muted">Explorez notre catalogue et trouvez l'équipement parfait pour votre prochaine sortie</p>
            <a href="/products" class="btn btn-primary"><i class="bi bi-compass me-1"></i>Explorer le Catalogue</a>
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
                                                <?php if (!empty($item['image'])): ?>
                                                    <img src="/assets/images/products/<?= e($item['image']) ?>" style="width:50px;height:50px;object-fit:cover;border-radius:8px;">
                                                <?php else: ?>
                                                    <div style="width:50px;height:50px;border-radius:8px;background:var(--sea-subtle);display:flex;align-items:center;justify-content:center;color:var(--ocean);">
                                                        <i class="bi bi-box-seam"></i>
                                                    </div>
                                                <?php endif; ?>
                                                <div>
                                                    <a href="/products/<?= $item['produit_id'] ?>" class="fw-semibold text-decoration-none" style="color:var(--ocean);"><?= e($item['nom']) ?></a>
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
                                        <td class="fw-bold text-nowrap" style="color:var(--sand);"><?= number_format($item['prix'] * $item['quantite'], 2) ?> DT</td>
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
                <div class="card p-4" style="border-top: 3px solid var(--ocean);">
                    <h5 class="fw-bold mb-3" style="color:var(--ocean);">⚓ Résumé</h5>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Sous-total</span>
                        <span><?= number_format($subtotal, 2) ?> DT</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">🚚 Livraison</span>
                        <span><?= number_format($shipping, 2) ?> DT</span>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between mb-3">
                        <span class="fw-bold">Total</span>
                        <span class="fw-bold" style="font-size: 1.25rem; color:var(--sand);"><?= number_format($total, 2) ?> DT</span>
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
