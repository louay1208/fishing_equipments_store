<?php
$statusLabels = [
    'en_attente' => 'En attente',
    'confirmee' => 'Confirmée',
    'expediee' => 'Expédiée',
    'livree' => 'Livrée',
    'annulee' => 'Annulée',
];
?>

<div class="page-header">
    <div class="container">
        <h1><i class="bi bi-box-seam me-2"></i>Mes Commandes</h1>
    </div>
</div>

<div class="container pb-5">
    <?php if (empty($orders)): ?>
        <div class="empty-state">
            <div class="icon">📦</div>
            <h5>Aucune commande</h5>
            <p class="text-muted">Vous n'avez pas encore passé de commande</p>
            <a href="/products" class="btn btn-primary">Découvrir nos Produits</a>
        </div>
    <?php else: ?>
        <div class="row g-3">
            <?php foreach ($orders as $order): ?>
                <div class="col-12">
                    <a href="/orders/<?= $order['id'] ?>" class="card p-3 text-decoration-none text-dark d-block">
                        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                            <div>
                                <h6 class="fw-bold mb-1">Commande #<?= $order['id'] ?></h6>
                                <span class="text-muted" style="font-size: 0.85rem;">
                                    <i class="bi bi-calendar me-1"></i><?= date('d/m/Y à H:i', strtotime($order['date_commande'])) ?>
                                </span>
                            </div>
                            <div class="text-end">
                                <span class="badge status-<?= $order['statut'] ?> mb-1"><?= $statusLabels[$order['statut']] ?? $order['statut'] ?></span>
                                <div class="fw-bold price-tag"><?= number_format($order['total'], 2) ?> DT</div>
                            </div>
                        </div>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>
