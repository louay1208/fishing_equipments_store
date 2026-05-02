<?php
$statusLabels = [
    'en_attente' => 'En attente',
    'confirmee' => 'Confirmée',
    'expediee' => 'Expédiée',
    'livree' => 'Livrée',
    'annulee' => 'Annulée',
];
$statusIcons = [
    'en_attente' => 'bi-clock',
    'confirmee' => 'bi-check-circle',
    'expediee' => 'bi-truck',
    'livree' => 'bi-house-check',
    'annulee' => 'bi-x-circle',
];
$statusSteps = ['en_attente', 'confirmee', 'expediee', 'livree'];
$currentStep = array_search($order['statut'], $statusSteps);
$isAnnulee = $order['statut'] === 'annulee';
$subtotal = $order['total'] - 7.00;
?>

<div class="page-header" style="background: linear-gradient(165deg, var(--sea-subtle) 0%, var(--bg) 100%);">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
            <div>
                <h1 style="color:var(--ocean);"><i class="bi bi-receipt me-2"></i>Commande #<?= $order['id'] ?></h1>
                <p class="text-muted mb-0">Passée le <?= date('d/m/Y à H:i', strtotime($order['date_commande'])) ?></p>
            </div>
            <a href="/orders" class="btn btn-outline-secondary"><i class="bi bi-arrow-left me-1"></i>Retour</a>
        </div>
    </div>
</div>

<div class="container pb-5">
    <!-- Status Timeline -->
    <div class="card p-4 mb-4 reveal">
        <h6 class="fw-bold mb-4" style="color:var(--ocean);"><i class="bi bi-geo-alt me-1"></i>Suivi de commande</h6>
        <?php if ($isAnnulee): ?>
            <div class="text-center py-3">
                <span class="badge bg-danger fs-6 px-3 py-2"><i class="bi bi-x-circle me-1"></i>Commande Annulée</span>
            </div>
        <?php else: ?>
            <div class="d-flex justify-content-between align-items-start position-relative" style="padding: 0 2rem;">
                <!-- Progress bar -->
                <div style="position:absolute; top:18px; left:calc(2rem + 18px); right:calc(2rem + 18px); height:3px; background:var(--border); z-index:0;">
                    <div style="width:<?= $currentStep !== false ? ($currentStep / 3 * 100) : 0 ?>%; height:100%; background:var(--sea); transition:width 0.5s;"></div>
                </div>
                <?php foreach ($statusSteps as $i => $step): ?>
                    <?php
                    $isActive = $currentStep !== false && $i <= $currentStep;
                    $isCurrent = $currentStep !== false && $i === $currentStep;
                    ?>
                    <div class="text-center" style="z-index:1; flex:1;">
                        <div style="width:36px; height:36px; border-radius:50%; margin:0 auto 8px;
                            background:<?= $isActive ? 'var(--sea)' : 'var(--bg-surface)' ?>;
                            color:<?= $isActive ? '#fff' : 'var(--text-muted)' ?>;
                            display:flex; align-items:center; justify-content:center; font-size:1rem;
                            <?= $isCurrent ? 'box-shadow:0 0 0 4px rgba(14,165,233,0.25);' : '' ?>">
                            <i class="bi <?= $statusIcons[$step] ?>"></i>
                        </div>
                        <div style="font-size:0.75rem; font-weight:<?= $isActive ? '700' : '400' ?>; color:<?= $isActive ? 'var(--ocean)' : 'var(--text-muted)' ?>;">
                            <?= $statusLabels[$step] ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card p-4 reveal">
                <h5 class="fw-bold mb-3" style="color:var(--ocean);"><i class="bi bi-bag me-1"></i>Produits commandés</h5>
                <div class="d-flex flex-column gap-3">
                    <?php foreach ($lines as $line): ?>
                        <div class="d-flex align-items-center gap-3 p-2" style="border-bottom:1px solid var(--border);">
                            <?php if (!empty($line['produit_image'])): ?>
                                <img src="/assets/images/products/<?= e($line['produit_image']) ?>" 
                                     style="width:60px;height:60px;border-radius:8px;object-fit:cover;">
                            <?php else: ?>
                                <div style="width:60px;height:60px;border-radius:8px;background:var(--sea-subtle);display:flex;align-items:center;justify-content:center;">
                                    <i class="bi bi-image text-muted"></i>
                                </div>
                            <?php endif; ?>
                            <div class="flex-grow-1">
                                <div class="fw-semibold"><?= e($line['produit_nom']) ?></div>
                                <div class="text-muted" style="font-size:0.8rem;">
                                    <?= number_format($line['prix_unitaire'], 2) ?> DT × <?= $line['quantite'] ?>
                                </div>
                            </div>
                            <div class="fw-bold" style="color:var(--sand);">
                                <?= number_format($line['prix_unitaire'] * $line['quantite'], 2) ?> DT
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card p-4 mb-3 reveal">
                <h5 class="fw-bold mb-3" style="color:var(--ocean);"><i class="bi bi-info-circle me-1"></i>Détails</h5>
                <div class="mb-3">
                    <span class="text-muted d-block" style="font-size: 0.8rem;">Statut</span>
                    <span class="badge status-<?= $order['statut'] ?>"><?= $statusLabels[$order['statut']] ?? $order['statut'] ?></span>
                </div>
                <div class="mb-3">
                    <span class="text-muted d-block" style="font-size: 0.8rem;">Adresse de livraison</span>
                    <span><i class="bi bi-geo-alt me-1" style="color:var(--sea);"></i><?= e($order['adresse_livraison'] ?? '—') ?></span>
                </div>
                <div class="mb-3">
                    <span class="text-muted d-block" style="font-size: 0.8rem;">Téléphone</span>
                    <span><i class="bi bi-telephone me-1" style="color:var(--sea);"></i><?= e($order['telephone'] ?? '—') ?></span>
                </div>
                <hr>
                <div class="d-flex justify-content-between mb-1" style="font-size:0.9rem;">
                    <span class="text-muted">Sous-total</span>
                    <span><?= number_format(max(0, $subtotal), 2) ?> DT</span>
                </div>
                <div class="d-flex justify-content-between mb-2" style="font-size:0.9rem;">
                    <span class="text-muted">Livraison</span>
                    <span>7.00 DT</span>
                </div>
                <hr>
                <div class="d-flex justify-content-between">
                    <span class="fw-bold fs-5">Total</span>
                    <span class="fw-bold fs-5" style="color:var(--sand);"><?= number_format($order['total'], 2) ?> DT</span>
                </div>
            </div>
        </div>
    </div>
</div>
