<div class="page-header" style="background: linear-gradient(165deg, var(--sea-subtle) 0%, var(--bg) 100%);">
    <div class="container">
        <h1 style="color:var(--ocean);"><i class="bi bi-envelope me-2"></i>Contact</h1>
        <p class="text-muted">Envoyez-nous un message</p>
    </div>
</div>

<div class="container pb-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card p-4">
                <form method="POST" action="/contact">
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label for="nom" class="form-label">Nom *</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-person"></i></span>
                                <input type="text" class="form-control" id="nom" name="nom" required placeholder="Votre nom">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="email" class="form-label">Email *</label>
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
                        <textarea class="form-control" id="message" name="message" rows="5" required placeholder="Votre message..."></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-send me-1"></i>Envoyer
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
