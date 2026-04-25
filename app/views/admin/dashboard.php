<?php
$statusLabels = [
    'en_attente' => 'En attente', 'confirmee' => 'Confirmée',
    'expediee' => 'Expédiée', 'livree' => 'Livrée', 'annulee' => 'Annulée',
];
?>

<div class="page-header">
    <div class="container">
        <h1><i class="bi bi-speedometer2 me-2"></i>Tableau de Bord</h1>
    </div>
</div>

<div class="container pb-5">
    <!-- Stats -->
    <div class="row g-3 mb-4">
        <div class="col-6 col-md-3">
            <div class="stat-card blue">
                <div class="stat-value"><?= $stats['products'] ?></div>
                <div class="stat-label"><i class="bi bi-box me-1"></i>Produits</div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="stat-card emerald">
                <div class="stat-value"><?= $stats['orders'] ?></div>
                <div class="stat-label"><i class="bi bi-receipt me-1"></i>Commandes</div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="stat-card amber">
                <div class="stat-value"><?= $stats['pending'] ?></div>
                <div class="stat-label"><i class="bi bi-clock me-1"></i>En Attente</div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="stat-card purple">
                <div class="stat-value"><?= number_format($stats['revenue'], 0) ?> DT</div>
                <div class="stat-label"><i class="bi bi-currency-dollar me-1"></i>Revenus</div>
            </div>
        </div>
    </div>

    <!-- Quick Links -->
    <div class="row g-3 mb-4">
        <div class="col-md-4"><a href="/admin/products" class="btn btn-ocean w-100 py-3"><i class="bi bi-box me-2"></i>Gérer les Produits</a></div>
        <div class="col-md-4"><a href="/admin/categories" class="btn btn-ocean w-100 py-3"><i class="bi bi-tags me-2"></i>Gérer les Catégories</a></div>
        <div class="col-md-4"><a href="/admin/orders" class="btn btn-ocean w-100 py-3"><i class="bi bi-receipt me-2"></i>Gérer les Commandes</a></div>
    </div>

    <!-- Recent Orders -->
    <div class="card">
        <div class="card-body">
            <h5 class="fw-bold mb-3">Dernières Commandes</h5>
            <?php if (empty($recentOrders)): ?>
                <p class="text-muted">Aucune commande pour le moment.</p>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead><tr><th>#</th><th>Client</th><th>Total</th><th>Statut</th><th>Date</th><th></th></tr></thead>
                        <tbody>
                            <?php foreach ($recentOrders as $o): ?>
                                <tr>
                                    <td class="fw-bold">#<?= $o['id'] ?></td>
                                    <td><?= e($o['prenom'] . ' ' . $o['nom']) ?></td>
                                    <td class="fw-bold"><?= number_format($o['total'], 2) ?> DT</td>
                                    <td><span class="badge status-<?= $o['statut'] ?>"><?= $statusLabels[$o['statut']] ?? $o['statut'] ?></span></td>
                                    <td class="text-muted"><?= date('d/m/Y', strtotime($o['date_commande'])) ?></td>
                                    <td><a href="/orders/<?= $o['id'] ?>" class="btn btn-sm btn-outline-secondary">Voir</a></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
