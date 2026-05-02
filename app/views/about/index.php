<div class="page-header" style="background: linear-gradient(165deg, var(--sea-subtle) 0%, var(--bg) 100%);">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
            <div>
                <h1 style="color:var(--ocean);"><i class="bi bi-info-circle me-2"></i>À Propos</h1>
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
    <!-- Qui sommes-nous -->
    <div class="row g-4 mb-5 align-items-center reveal">
        <div class="col-lg-7">
            <h2 class="fw-bold mb-3" style="color:var(--ocean);">Qui sommes-nous ?</h2>
            <p class="text-muted" style="line-height:1.8;">
                <strong>Pêche Marine TN</strong> est une boutique en ligne tunisienne dédiée à la vente de matériel de pêche.
                Notre objectif est de rendre le bon équipement accessible à tous les pêcheurs, qu'ils soient débutants ou expérimentés.
            </p>
            <p class="text-muted" style="line-height:1.8;">
                Nous proposons une sélection de cannes, moulinets, leurres et accessoires adaptés à la pêche en Méditerranée, 
                avec livraison sur tout le territoire tunisien.
            </p>
        </div>
        <div class="col-lg-5">
            <div class="card p-4" style="border-left: 4px solid var(--ocean);">
                <h6 class="fw-bold mb-3" style="color:var(--ocean);"><i class="bi bi-geo-alt me-1"></i>Informations</h6>
                <ul class="list-unstyled text-muted mb-0" style="font-size:0.9rem; line-height:2;">
                    <li><i class="bi bi-pin-map me-2" style="color:var(--sea);"></i>Gabès, Tunisie</li>
                    <li><i class="bi bi-envelope me-2" style="color:var(--sea);"></i>contact@pechemarine.tn</li>
                    <li><i class="bi bi-clock me-2" style="color:var(--sea);"></i>Lun - Sam : 9h - 18h</li>
                    <li><i class="bi bi-truck me-2" style="color:var(--sea);"></i>Livraison : 7.00 DT partout en Tunisie</li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Chiffres -->
    <div class="row g-4 mb-5">
        <div class="col-6 col-md-3 reveal">
            <div class="card text-center p-4">
                <div style="font-size:2rem; color:var(--ocean); font-weight:800;"><?= $productCount ?></div>
                <div class="text-muted" style="font-size:0.85rem;">Produits</div>
            </div>
        </div>
        <div class="col-6 col-md-3 reveal">
            <div class="card text-center p-4">
                <div style="font-size:2rem; color:var(--sand); font-weight:800;"><?= $categoryCount ?></div>
                <div class="text-muted" style="font-size:0.85rem;">Catégories</div>
            </div>
        </div>
        <div class="col-6 col-md-3 reveal">
            <div class="card text-center p-4">
                <div style="font-size:2rem; color:var(--ocean); font-weight:800;">7 DT</div>
                <div class="text-muted" style="font-size:0.85rem;">Livraison fixe</div>
            </div>
        </div>
        <div class="col-6 col-md-3 reveal">
            <div class="card text-center p-4">
                <div style="font-size:2rem; color:var(--sand); font-weight:800;">24h</div>
                <div class="text-muted" style="font-size:0.85rem;">Réponse garantie</div>
            </div>
        </div>
    </div>

    <!-- Pourquoi nous -->
    <div class="mb-5 reveal">
        <h3 class="fw-bold mb-4" style="color:var(--ocean);">Pourquoi nous choisir ?</h3>
        <div class="row g-3">
            <div class="col-md-4">
                <div class="card p-3 h-100" style="border-top: 3px solid var(--ocean);">
                    <h6 class="fw-bold" style="color:var(--ocean);"><i class="bi bi-check2-circle me-1"></i>Qualité</h6>
                    <p class="text-muted mb-0" style="font-size:0.88rem;">
                        Du matériel sélectionné et adapté aux conditions de pêche en Méditerranée.
                    </p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card p-3 h-100" style="border-top: 3px solid var(--sand);">
                    <h6 class="fw-bold" style="color:var(--ocean);"><i class="bi bi-tag me-1"></i>Prix accessible</h6>
                    <p class="text-muted mb-0" style="font-size:0.88rem;">
                        Des prix justes sans intermédiaires, pour que la pêche reste un plaisir.
                    </p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card p-3 h-100" style="border-top: 3px solid var(--ocean);">
                    <h6 class="fw-bold" style="color:var(--ocean);"><i class="bi bi-headset me-1"></i>Support</h6>
                    <p class="text-muted mb-0" style="font-size:0.88rem;">
                        Une équipe disponible pour vous aider à choisir le bon matériel.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
