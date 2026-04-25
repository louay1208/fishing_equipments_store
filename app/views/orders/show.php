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
        <h1>Commande #<?= $order['id'] ?></h1>
    </div>
</div>

<div class="container pb-5">
    <a href="/orders" class="btn btn-outline-secondary mb-4"><i class="bi bi-arrow-left me-1"></i>Retour</a>

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card p-4">
                <h5 class="fw-bold mb-3">Produits commandés</h5>
                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead><tr><th>Produit</th><th>Prix unitaire</th><th>Quantité</th><th>Total</th></tr></thead>
                        <tbody>
                            <?php foreach ($lines as $line): ?>
                                <tr>
                                    <td class="fw-semibold"><?= e($line['produit_nom']) ?></td>
                                    <td><?= number_format($line['prix_unitaire'], 2) ?> DT</td>
                                    <td><?= $line['quantite'] ?></td>
                                    <td class="fw-bold"><?= number_format($line['prix_unitaire'] * $line['quantite'], 2) ?> DT</td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card p-4 mb-3">
                <h5 class="fw-bold mb-3">Détails</h5>
                <div class="mb-2">
                    <span class="text-muted d-block" style="font-size: 0.85rem;">Statut</span>
                    <span class="badge status-<?= $order['statut'] ?>"><?= $statusLabels[$order['statut']] ?? $order['statut'] ?></span>
                </div>
                <div class="mb-2">
                    <span class="text-muted d-block" style="font-size: 0.85rem;">Date</span>
                    <?= date('d/m/Y à H:i', strtotime($order['date_commande'])) ?>
                </div>
                <div class="mb-2">
                    <span class="text-muted d-block" style="font-size: 0.85rem;">Adresse</span>
                    <?= e($order['adresse_livraison'] ?? '—') ?>
                </div>
                <div class="mb-2">
                    <span class="text-muted d-block" style="font-size: 0.85rem;">Téléphone</span>
                    <?= e($order['telephone'] ?? '—') ?>
                </div>
                <hr>
                <div class="d-flex justify-content-between">
                    <span class="fw-bold">Total</span>
                    <span class="fw-bold price-tag fs-5"><?= number_format($order['total'], 2) ?> DT</span>
                </div>
            </div>
        </div>
    </div>
</div>
