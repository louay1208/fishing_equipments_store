<?php
$statusLabels = [
    'en_attente' => 'En attente', 'confirmee' => 'Confirmée',
    'expediee' => 'Expédiée', 'livree' => 'Livrée', 'annulee' => 'Annulée',
];
$statusColors = [
    'en_attente' => '#b45309', 'confirmee' => '#2563eb',
    'expediee' => '#7c3aed', 'livree' => '#16a34a', 'annulee' => '#dc2626',
];
$totalOrders = max((int)$stats['orders'], 1);
$adminName = $_SESSION['user_name'] ?? 'Admin';
?>

<!-- Welcome Header -->
<div class="admin-welcome">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div>
                <h1 class="admin-greeting">Bonjour, <?= e($adminName) ?> 👋</h1>
                <p class="admin-date">
                    <?= strftime('%A %d %B %Y') ?: date('l d F Y') ?>
                    <?php if ($stats['pending'] > 0): ?>
                        · <span class="admin-pending-badge"><?= $stats['pending'] ?> commande<?= $stats['pending'] > 1 ? 's' : '' ?> en attente</span>
                    <?php endif; ?>
                </p>
            </div>
            <a href="/admin/products" class="btn btn-primary">
                <i class="bi bi-plus-lg me-1"></i>Ajouter un Produit
            </a>
        </div>
    </div>
</div>

<div class="container admin-content pb-5">

    <!-- KPI Stats -->
    <div class="row g-3 mb-4">
        <div class="col-6 col-lg">
            <div class="admin-stat-card">
                <div class="admin-stat-icon" style="background:#edf7f1;color:#16a34a;">
                    <i class="bi bi-currency-dollar"></i>
                </div>
                <div class="admin-stat-value"><?= number_format($stats['revenue'], 0) ?> <small>DT</small></div>
                <div class="admin-stat-label">Revenus Total</div>
            </div>
        </div>
        <div class="col-6 col-lg">
            <div class="admin-stat-card">
                <div class="admin-stat-icon" style="background:#eff4ff;color:#2563eb;">
                    <i class="bi bi-receipt"></i>
                </div>
                <div class="admin-stat-value"><?= $stats['orders'] ?></div>
                <div class="admin-stat-label">Commandes</div>
            </div>
        </div>
        <div class="col-6 col-lg">
            <div class="admin-stat-card">
                <div class="admin-stat-icon" style="background:#f3f0ff;color:#7c3aed;">
                    <i class="bi bi-box-seam"></i>
                </div>
                <div class="admin-stat-value"><?= $stats['products'] ?></div>
                <div class="admin-stat-label">Produits</div>
            </div>
        </div>
        <div class="col-6 col-lg">
            <div class="admin-stat-card">
                <div class="admin-stat-icon" style="background:#edf7f1;color:#1a6b4a;">
                    <i class="bi bi-people"></i>
                </div>
                <div class="admin-stat-value"><?= $stats['users'] ?></div>
                <div class="admin-stat-label">Clients</div>
            </div>
        </div>
        <div class="col-6 col-lg">
            <div class="admin-stat-card <?= $stats['pending'] > 0 ? 'admin-stat-alert' : '' ?>">
                <div class="admin-stat-icon" style="background:#fef9ec;color:#b45309;">
                    <i class="bi bi-clock-history"></i>
                </div>
                <div class="admin-stat-value"><?= $stats['pending'] ?></div>
                <div class="admin-stat-label">En Attente</div>
            </div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="row g-3 mb-4">
        <!-- Revenue & Orders Chart -->
        <div class="col-lg-8">
            <div class="admin-panel">
                <div class="admin-panel-header">
                    <h6><i class="bi bi-graph-up me-2"></i>Chiffre d'Affaires & Commandes</h6>
                </div>
                <div style="padding:1rem;">
                    <canvas id="revenueChart" height="260"></canvas>
                </div>
            </div>
        </div>
        <!-- Order Status Doughnut -->
        <div class="col-lg-4">
            <div class="admin-panel">
                <div class="admin-panel-header">
                    <h6><i class="bi bi-pie-chart-fill me-2"></i>Statut Commandes</h6>
                </div>
                <div style="padding:1rem; display:flex; align-items:center; justify-content:center;">
                    <canvas id="statusChart" height="220"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Top Products Chart -->
    <div class="row g-3 mb-4">
        <div class="col-12">
            <div class="admin-panel">
                <div class="admin-panel-header">
                    <h6><i class="bi bi-trophy me-2"></i>Top 5 Produits les Plus Vendus</h6>
                </div>
                <div style="padding:1rem;">
                    <canvas id="topProductsChart" height="180"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Script -->
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const isDark = document.documentElement.getAttribute('data-theme') === 'dark';
        const gridColor = isDark ? 'rgba(255,255,255,0.08)' : 'rgba(0,0,0,0.06)';
        const textColor = isDark ? '#94a3b8' : '#64748b';
        const monthNames = ['Jan','Fév','Mar','Avr','Mai','Jun','Jul','Aoû','Sep','Oct','Nov','Déc'];

        Chart.defaults.color = textColor;
        Chart.defaults.borderColor = gridColor;

        // Revenue & Orders Chart
        const revenueData = <?= json_encode($monthlyRevenue) ?>;
        const labels = revenueData.map(d => {
            const [y, m] = d.month.split('-');
            return monthNames[parseInt(m)-1] + ' ' + y.slice(2);
        });

        new Chart(document.getElementById('revenueChart'), {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [
                    {
                        label: 'Revenus (DT)',
                        data: revenueData.map(d => d.revenue),
                        backgroundColor: 'rgba(14,165,233,0.6)',
                        borderColor: '#0ea5e9',
                        borderWidth: 2,
                        borderRadius: 6,
                        order: 2,
                    },
                    {
                        label: 'Commandes',
                        data: revenueData.map(d => d.orders),
                        type: 'line',
                        borderColor: '#d97706',
                        backgroundColor: 'rgba(217,119,6,0.1)',
                        borderWidth: 3,
                        pointRadius: 5,
                        pointBackgroundColor: '#d97706',
                        fill: true,
                        tension: 0.3,
                        yAxisID: 'y1',
                        order: 1,
                    }
                ]
            },
            options: {
                responsive: true,
                interaction: { mode: 'index', intersect: false },
                plugins: { legend: { position: 'top' } },
                scales: {
                    y: { beginAtZero: true, title: { display: true, text: 'DT' }, grid: { color: gridColor } },
                    y1: { beginAtZero: true, position: 'right', title: { display: true, text: 'Commandes' }, grid: { display: false } },
                    x: { grid: { display: false } }
                }
            }
        });

        // Order Status Doughnut
        const statusData = <?= json_encode($ordersByStatus) ?>;
        const statusLabels = { en_attente: 'En attente', confirmee: 'Confirmée', expediee: 'Expédiée', livree: 'Livrée', annulee: 'Annulée' };
        const statusColors = { en_attente: '#f59e0b', confirmee: '#3b82f6', expediee: '#8b5cf6', livree: '#22c55e', annulee: '#ef4444' };
        const sLabels = Object.keys(statusData).map(k => statusLabels[k] || k);
        const sValues = Object.values(statusData).map(Number);
        const sColors = Object.keys(statusData).map(k => statusColors[k] || '#94a3b8');

        new Chart(document.getElementById('statusChart'), {
            type: 'doughnut',
            data: {
                labels: sLabels,
                datasets: [{
                    data: sValues,
                    backgroundColor: sColors,
                    borderWidth: 2,
                    borderColor: isDark ? '#1e293b' : '#fff',
                }]
            },
            options: {
                responsive: true,
                cutout: '60%',
                plugins: {
                    legend: { position: 'bottom', labels: { padding: 12, usePointStyle: true, pointStyle: 'circle' } }
                }
            }
        });

        // Top Products Bar
        const topData = <?= json_encode($topProducts) ?>;
        new Chart(document.getElementById('topProductsChart'), {
            type: 'bar',
            data: {
                labels: topData.map(p => p.nom.length > 25 ? p.nom.substring(0,25)+'…' : p.nom),
                datasets: [{
                    label: 'Unités vendues',
                    data: topData.map(p => p.total_sold),
                    backgroundColor: ['#0ea5e9','#06b6d4','#14b8a6','#22c55e','#84cc16'],
                    borderRadius: 6,
                    borderSkipped: false,
                }]
            },
            options: {
                indexAxis: 'y',
                responsive: true,
                plugins: { legend: { display: false } },
                scales: {
                    x: { beginAtZero: true, grid: { color: gridColor }, title: { display: true, text: 'Quantité vendue' } },
                    y: { grid: { display: false } }
                }
            }
        });
    });
    </script>

    <!-- Two-column: Low Stock + Order Breakdown -->
    <div class="row g-3 mb-4">
        <!-- Low Stock Alerts -->
        <div class="col-lg-6">
            <div class="admin-panel">
                <div class="admin-panel-header">
                    <h6><i class="bi bi-exclamation-triangle me-2"></i>Alertes Stock Faible</h6>
                    <a href="/admin/products" class="admin-panel-link">Gérer <i class="bi bi-arrow-right"></i></a>
                </div>
                <?php if (empty($lowStock)): ?>
                    <div class="admin-empty-small">
                        <i class="bi bi-check-circle text-success"></i>
                        <span>Tous les produits sont bien approvisionnés</span>
                    </div>
                <?php else: ?>
                    <div class="admin-stock-list">
                        <?php foreach ($lowStock as $item): ?>
                            <div class="admin-stock-item">
                                <div>
                                    <div class="fw-semibold" style="font-size:0.88rem;"><?= e($item['nom']) ?></div>
                                    <div class="text-muted" style="font-size:0.75rem;"><?= e($item['categorie_nom'] ?? '—') ?></div>
                                </div>
                                <span class="admin-stock-badge <?= $item['quantite_stock'] == 0 ? 'out' : 'low' ?>">
                                    <?= $item['quantite_stock'] == 0 ? 'Épuisé' : $item['quantite_stock'] . ' restant' . ($item['quantite_stock'] > 1 ? 's' : '') ?>
                                </span>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Order Breakdown -->
        <div class="col-lg-6">
            <div class="admin-panel">
                <div class="admin-panel-header">
                    <h6><i class="bi bi-pie-chart me-2"></i>Répartition des Commandes</h6>
                    <a href="/admin/orders" class="admin-panel-link">Détails <i class="bi bi-arrow-right"></i></a>
                </div>
                <?php if (empty($ordersByStatus)): ?>
                    <div class="admin-empty-small">
                        <i class="bi bi-inbox"></i>
                        <span>Aucune commande pour le moment</span>
                    </div>
                <?php else: ?>
                    <div class="admin-status-breakdown">
                        <?php foreach ($statusLabels as $key => $label):
                            $count = (int)($ordersByStatus[$key] ?? 0);
                            if ($count === 0) continue;
                            $pct = round(($count / $totalOrders) * 100);
                            $color = $statusColors[$key];
                        ?>
                            <div class="admin-status-row">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <span class="admin-status-label">
                                        <span class="admin-status-dot" style="background:<?= $color ?>;"></span>
                                        <?= $label ?>
                                    </span>
                                    <span class="admin-status-count"><?= $count ?></span>
                                </div>
                                <div class="admin-progress">
                                    <div class="admin-progress-bar" style="width:<?= $pct ?>%;background:<?= $color ?>;"></div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Recent Orders -->
    <div class="admin-panel mb-4">
        <div class="admin-panel-header">
            <h6><i class="bi bi-receipt-cutoff me-2"></i>Dernières Commandes</h6>
            <a href="/admin/orders" class="admin-panel-link">Voir tout <i class="bi bi-arrow-right"></i></a>
        </div>
        <?php if (empty($recentOrders)): ?>
            <div class="admin-empty-small">
                <i class="bi bi-inbox"></i>
                <span>Aucune commande pour le moment</span>
            </div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead><tr><th>Commande</th><th>Client</th><th>Total</th><th>Statut</th><th>Date</th><th></th></tr></thead>
                    <tbody>
                        <?php foreach ($recentOrders as $o):
                            $initials = strtoupper(mb_substr($o['prenom'],0,1) . mb_substr($o['nom'],0,1));
                        ?>
                            <tr>
                                <td><span class="fw-bold text-muted">#<?= $o['id'] ?></span></td>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="avatar-initials"><?= $initials ?></div>
                                        <span class="fw-semibold"><?= e($o['prenom'] . ' ' . $o['nom']) ?></span>
                                    </div>
                                </td>
                                <td class="fw-bold" style="color:var(--accent);"><?= number_format($o['total'], 2) ?> DT</td>
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

    <!-- Recent Contact Messages -->
    <div class="admin-panel mb-4">
        <div class="admin-panel-header">
            <h6><i class="bi bi-envelope-open me-2"></i>Messages Récents</h6>
        </div>
        <?php if (empty($recentContacts)): ?>
            <div class="admin-empty-small">
                <i class="bi bi-chat-dots"></i>
                <span>Aucun message reçu</span>
            </div>
        <?php else: ?>
            <div class="admin-messages">
                <?php foreach ($recentContacts as $msg): ?>
                    <div class="admin-message-item">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <div class="fw-semibold" style="font-size:0.9rem;"><?= e($msg['nom']) ?></div>
                                <div class="text-muted" style="font-size:0.78rem;"><?= e($msg['email']) ?></div>
                            </div>
                            <span class="text-muted" style="font-size:0.75rem;"><?= date('d/m H:i', strtotime($msg['created_at'])) ?></span>
                        </div>
                        <p class="admin-message-subject"><?= e($msg['sujet']) ?></p>
                        <p class="admin-message-preview"><?= e(mb_strimwidth($msg['message'], 0, 120, '...')) ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>

    <!-- Quick Actions -->
    <div class="row g-3">
        <div class="col-md-4">
            <a href="/admin/products" class="admin-action-card">
                <div class="admin-action-icon" style="background:#eff4ff;color:#2563eb;"><i class="bi bi-box-seam"></i></div>
                <div>
                    <div class="admin-action-title">Gérer les Produits</div>
                    <div class="admin-action-desc">Ajouter, modifier, supprimer</div>
                </div>
                <i class="bi bi-chevron-right ms-auto text-muted"></i>
            </a>
        </div>
        <div class="col-md-4">
            <a href="/admin/categories" class="admin-action-card">
                <div class="admin-action-icon" style="background:#f3f0ff;color:#7c3aed;"><i class="bi bi-tags"></i></div>
                <div>
                    <div class="admin-action-title">Gérer les Catégories</div>
                    <div class="admin-action-desc">Organiser le catalogue</div>
                </div>
                <i class="bi bi-chevron-right ms-auto text-muted"></i>
            </a>
        </div>
        <div class="col-md-4">
            <a href="/admin/orders" class="admin-action-card">
                <div class="admin-action-icon" style="background:#fef9ec;color:#b45309;"><i class="bi bi-receipt"></i></div>
                <div>
                    <div class="admin-action-title">Gérer les Commandes</div>
                    <div class="admin-action-desc">Suivi et mise à jour</div>
                </div>
                <i class="bi bi-chevron-right ms-auto text-muted"></i>
            </a>
        </div>
    </div>
</div>
