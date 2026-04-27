<div class="page-header" style="background: linear-gradient(165deg, var(--sea-subtle) 0%, var(--bg) 100%);">
    <div class="container">
        <h1 style="color:var(--ocean);"><i class="bi bi-envelope me-2"></i>Contactez-nous</h1>
        <p class="text-muted">Notre équipe de passionnés est là pour vous conseiller 🎣</p>
    </div>
</div>

<div class="container pb-5">
    <!-- Info Cards Row -->
    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="card p-3 text-center h-100" style="border-top: 3px solid var(--sea);">
                <div style="font-size:1.8rem; margin-bottom:0.5rem;">📍</div>
                <h6 class="fw-bold mb-1">Adresse</h6>
                <p class="text-muted mb-0" style="font-size:0.88rem;">Rue Jilani Habib<br>Gabès 6002, Tunisie</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card p-3 text-center h-100" style="border-top: 3px solid var(--sea);">
                <div style="font-size:1.8rem; margin-bottom:0.5rem;">📞</div>
                <h6 class="fw-bold mb-1">Téléphone</h6>
                <p class="text-muted mb-0" style="font-size:0.88rem;">+216 75 000 000<br>Lun-Sam, 8h-18h</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card p-3 text-center h-100" style="border-top: 3px solid var(--sea);">
                <div style="font-size:1.8rem; margin-bottom:0.5rem;">✉️</div>
                <h6 class="fw-bold mb-1">Email</h6>
                <p class="text-muted mb-0" style="font-size:0.88rem;">contact@pechemarine.tn<br>Réponse sous 24h</p>
            </div>
        </div>
    </div>

    <!-- Contact Form -->
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card p-4">
                <h5 class="fw-bold mb-1" style="color:var(--ocean);">🌊 Envoyez-nous un Message</h5>
                <p class="text-muted mb-3" style="font-size:0.88rem;">Remplissez le formulaire ci-dessous et nous vous répondrons rapidement</p>
                <form method="POST" action="/contact">
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label for="nom" class="form-label">Nom Complet *</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-person"></i></span>
                                <input type="text" class="form-control" id="nom" name="nom" required placeholder="Votre nom">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="email" class="form-label">Adresse Email *</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                                <input type="email" class="form-control" id="email" name="email" required placeholder="votre@email.com">
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="sujet" class="form-label">Sujet *</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-chat-dots"></i></span>
                            <input type="text" class="form-control" id="sujet" name="sujet" required placeholder="Sujet de votre message">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="message" class="form-label">Message *</label>
                        <textarea class="form-control" id="message" name="message" rows="5" required placeholder="Décrivez votre question ou demande..."></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-send me-1"></i>Envoyer le Message
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
