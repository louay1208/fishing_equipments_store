<?php
$statusLabels = [
    'en_attente' => 'En attente', 'confirmee' => 'Confirmée',
    'expediee' => 'Expédiée', 'livree' => 'Livrée', 'annulee' => 'Annulée',
];
$statusFilter = $_GET['status'] ?? '';
?>

<div class="page-header">
    <div class="container">
        <h1><i class="bi bi-receipt me-2"></i>Commandes</h1>
    </div>
</div>

<div class="container pb-5">
    <a href="/admin" class="btn btn-outline-secondary btn-sm mb-3"><i class="bi bi-arrow-left me-1"></i>Dashboard</a>

    <!-- Status Filter -->
    <div class="mb-3 d-flex gap-2 flex-wrap">
        <a href="/admin/orders" class="btn btn-sm <?= !$statusFilter ? 'btn-ocean' : 'btn-outline-secondary' ?>">Toutes</a>
        <?php foreach ($statusLabels as $key => $label): ?>
            <a href="/admin/orders?status=<?= $key ?>" class="btn btn-sm <?= $statusFilter === $key ? 'btn-ocean' : 'btn-outline-secondary' ?>"><?= $label ?></a>
        <?php endforeach; ?>
    </div>

    <?php if (empty($orders)): ?>
        <div class="empty-state">
            <div class="icon">📦</div>
            <h5>Aucune commande</h5>
        </div>
    <?php else: ?>
        <div class="card">
            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead><tr><th>#</th><th>Client</th><th>Total</th><th>Statut</th><th>Date</th><th>Action</th></tr></thead>
                    <tbody>
                        <?php foreach ($orders as $o): ?>
                            <tr>
                                <td class="fw-bold">#<?= $o['id'] ?></td>
                                <td>
                                    <div class="fw-semibold"><?= e($o['prenom'] . ' ' . $o['nom']) ?></div>
                                    <div class="text-muted" style="font-size: 0.8rem;"><?= e($o['email']) ?></div>
                                </td>
                                <td class="fw-bold price-tag"><?= number_format($o['total'], 2) ?> DT</td>
                                <td><span class="badge status-<?= $o['statut'] ?>"><?= $statusLabels[$o['statut']] ?? $o['statut'] ?></span></td>
                                <td class="text-muted"><?= date('d/m/Y H:i', strtotime($o['date_commande'])) ?></td>
                                <td>
                                    <div class="d-flex gap-1">
                                        <a href="/orders/<?= $o['id'] ?>" class="btn btn-sm btn-outline-secondary"><i class="bi bi-eye"></i></a>
                                        <form method="POST" action="/admin/orders/status" class="d-inline">
                                            <input type="hidden" name="id" value="<?= $o['id'] ?>">
                                            <select name="statut" class="form-select form-select-sm" style="width: auto;" onchange="this.form.submit()">
                                                <?php foreach ($statusLabels as $key => $label): ?>
                                                    <option value="<?= $key ?>" <?= $o['statut'] === $key ? 'selected' : '' ?>><?= $label ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    <?php endif; ?>
</div>
