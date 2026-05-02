<div class="page-header" style="background: linear-gradient(165deg, var(--sea-subtle) 0%, var(--bg) 100%);">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
            <div>
                <h1 style="color:var(--ocean);"><i class="bi bi-info-circle me-2"></i>À Propos</h1>
                <p class="text-muted mb-0">Découvrez l'histoire de Pêche Marine TN 🌊</p>
            </div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0" style="font-size:0.85rem;">
                    <li class="breadcrumb-item"><a href="/">Accueil</a></li>
                    <li class="breadcrumb-item active">À Propos</li>
                </ol>
            </nav>
        </div>
    </div>
</div>

<div class="container pb-5">
    <!-- Mission Section -->
    <div class="row g-4 mb-5 align-items-center reveal">
        <div class="col-lg-6">
            <span class="badge mb-2" style="background:var(--sea-subtle); color:var(--ocean); font-weight:600;">
                <i class="bi bi-compass me-1"></i>Notre Mission
            </span>
            <h2 class="fw-bold mb-3" style="color:var(--ocean);">La passion de la pêche, accessible à tous</h2>
            <p class="text-muted" style="line-height:1.8;">
                <strong>Pêche Marine TN</strong> est née d'une passion profonde pour la mer Méditerranée et la pêche côtière tunisienne.
                Notre mission est simple : offrir aux pêcheurs — débutants et confirmés — du matériel de qualité 
                professionnelle à des prix accessibles, avec un service client personnalisé.
            </p>
            <p class="text-muted" style="line-height:1.8;">
                Basés à <strong>Gabès</strong>, au cœur du littoral tunisien, nous sélectionnons chaque produit 
                avec soin pour garantir performance et durabilité face aux conditions marines méditerranéennes.
            </p>
        </div>
        <div class="col-lg-6 text-center">
            <div style="background:linear-gradient(135deg, var(--sea-subtle) 0%, var(--sand-subtle) 100%); border-radius:var(--radius-lg); padding:3rem; font-size:5rem;">
                ⚓🎣🐟
                <p class="mt-3 mb-0 text-muted" style="font-size:0.9rem;">Pêche · Passion · Méditerranée</p>
            </div>
        </div>
    </div>

    <!-- Stats -->
    <div class="row g-4 mb-5">
        <div class="col-6 col-md-3 reveal">
            <div class="card text-center p-4">
                <div style="font-size:2.5rem; color:var(--ocean); font-weight:800;"><?= $productCount ?>+</div>
                <div class="text-muted" style="font-size:0.85rem;">Produits disponibles</div>
            </div>
        </div>
        <div class="col-6 col-md-3 reveal">
            <div class="card text-center p-4">
                <div style="font-size:2.5rem; color:var(--sand); font-weight:800;"><?= $categoryCount ?></div>
                <div class="text-muted" style="font-size:0.85rem;">Catégories</div>
            </div>
        </div>
        <div class="col-6 col-md-3 reveal">
            <div class="card text-center p-4">
                <div style="font-size:2.5rem; color:var(--ocean); font-weight:800;">24/7</div>
                <div class="text-muted" style="font-size:0.85rem;">Service en ligne</div>
            </div>
        </div>
        <div class="col-6 col-md-3 reveal">
            <div class="card text-center p-4">
                <div style="font-size:2.5rem; color:var(--sand); font-weight:800;"><?= $orderCount ?>+</div>
                <div class="text-muted" style="font-size:0.85rem;">Commandes livrées</div>
            </div>
        </div>
    </div>

    <!-- Values -->
    <div class="mb-5 reveal">
        <h3 class="section-title text-center mb-4" style="color:var(--ocean);">🌊 Nos Valeurs</h3>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="card p-4 h-100 text-center" style="border-top: 3px solid var(--ocean);">
                    <div style="font-size:2.5rem; margin-bottom:0.5rem;">🎯</div>
                    <h5 class="fw-bold" style="color:var(--ocean);">Qualité</h5>
                    <p class="text-muted mb-0" style="font-size:0.9rem;">
                        Nous sélectionnons uniquement du matériel testé et approuvé par des pêcheurs professionnels.
                        Chaque produit est vérifié pour sa résistance aux conditions marines.
                    </p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card p-4 h-100 text-center" style="border-top: 3px solid var(--sand);">
                    <div style="font-size:2.5rem; margin-bottom:0.5rem;">💰</div>
                    <h5 class="fw-bold" style="color:var(--ocean);">Prix Juste</h5>
                    <p class="text-muted mb-0" style="font-size:0.9rem;">
                        Pas d'intermédiaires inutiles. Nous travaillons directement avec les fabricants pour 
                        offrir les meilleurs prix en Tunisie.
                    </p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card p-4 h-100 text-center" style="border-top: 3px solid var(--ocean);">
                    <div style="font-size:2.5rem; margin-bottom:0.5rem;">🤝</div>
                    <h5 class="fw-bold" style="color:var(--ocean);">Conseil Expert</h5>
                    <p class="text-muted mb-0" style="font-size:0.9rem;">
                        Notre équipe de passionnés vous accompagne dans le choix de votre matériel. 
                        Contactez-nous pour des recommandations personnalisées.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- CTA -->
    <div class="text-center reveal">
        <div class="card p-5" style="background:linear-gradient(135deg, var(--ocean) 0%, var(--sea) 100%); border:none; color:#fff;">
            <h3 class="fw-bold mb-2">Prêt à pêcher ? 🎣</h3>
            <p class="mb-4 opacity-75">Découvrez notre catalogue complet et équipez-vous comme un pro.</p>
            <div class="d-flex gap-3 justify-content-center flex-wrap">
                <a href="/products" class="btn btn-light btn-lg fw-bold" style="color:var(--ocean);">
                    <i class="bi bi-grid me-1"></i>Voir le Catalogue
                </a>
                <a href="/contact" class="btn btn-outline-light btn-lg fw-bold">
                    <i class="bi bi-envelope me-1"></i>Nous Contacter
                </a>
            </div>
        </div>
    </div>
</div>
