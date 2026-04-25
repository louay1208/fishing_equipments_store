<?php
$pageTitle = 'Page non trouvée — Pêche Marine TN';
require VIEW_PATH . '/layouts/header.php';
?>
<div class="container py-5 text-center">
    <div class="empty-state">
        <div style="font-size: 5rem; margin-bottom: 1rem;">🐟</div>
        <h2 class="fw-bold">404 — Page non trouvée</h2>
        <p class="text-muted mb-4">Cette page n'existe pas ou a été déplacée</p>
        <a href="/" class="btn btn-primary"><i class="bi bi-house me-1"></i>Retour à l'Accueil</a>
    </div>
</div>
<?php require VIEW_PATH . '/layouts/footer.php'; ?>
