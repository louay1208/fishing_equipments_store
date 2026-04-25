<div class="page-header">
    <div class="container">
        <h1><i class="bi bi-envelope me-2"></i>Contactez-nous</h1>
        <p>Nous sommes là pour vous aider</p>
    </div>
</div>

<div class="container pb-5">
    <div class="row g-4 justify-content-center">
        <div class="col-lg-6">
            <div class="card p-4">
                <h5 class="fw-bold mb-3">Envoyez-nous un Message</h5>
                <form method="POST" action="/contact">
                    <div class="mb-3">
                        <label for="nom" class="form-label">Nom Complet *</label>
                        <input type="text" class="form-control" id="nom" name="nom" required placeholder="Votre nom">
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Adresse Email *</label>
                        <input type="email" class="form-control" id="email" name="email" required placeholder="votre@email.com">
                    </div>
                    <div class="mb-3">
                        <label for="sujet" class="form-label">Sujet *</label>
                        <input type="text" class="form-control" id="sujet" name="sujet" required placeholder="Sujet de votre message">
                    </div>
                    <div class="mb-3">
                        <label for="message" class="form-label">Message *</label>
                        <textarea class="form-control" id="message" name="message" rows="5" required placeholder="Votre message..."></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-send me-1"></i>Envoyer le Message
                    </button>
                </form>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card p-4 mb-3">
                <h6 class="fw-bold mb-2"><i class="bi bi-geo-alt me-1 text-primary"></i> Adresse</h6>
                <p class="text-muted mb-0">Rue Jilani Habib, Gabès 6002, Tunisie</p>
            </div>
            <div class="card p-4 mb-3">
                <h6 class="fw-bold mb-2"><i class="bi bi-telephone me-1 text-primary"></i> Téléphone</h6>
                <p class="text-muted mb-0">+216 75 000 000</p>
            </div>
            <div class="card p-4">
                <h6 class="fw-bold mb-2"><i class="bi bi-envelope me-1 text-primary"></i> Email</h6>
                <p class="text-muted mb-0">contact@pechemarine.tn</p>
            </div>
        </div>
    </div>
</div>
