<div class="auth-container">
    <div class="auth-card card">
        <div class="text-center mb-3">
            <span style="font-size: 2.5rem;">⚓</span>
        </div>
        <h2 class="text-center" style="color:var(--ocean);">Connexion</h2>
        <p class="subtitle text-center">Connectez-vous à votre compte Pêche Marine TN</p>

        <form method="POST" action="/login">
            <div class="mb-3">
                <label for="email" class="form-label">Adresse Email</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                    <input type="email" class="form-control" id="email" name="email" placeholder="votre@email.com" required>
                </div>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Mot de passe</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-lock"></i></span>
                    <input type="password" class="form-control" id="password" name="password" placeholder="••••••••" required>
                    <button class="btn btn-outline-secondary toggle-password" type="button" data-target="password" tabindex="-1">
                        <i class="bi bi-eye"></i>
                    </button>
                </div>
            </div>
            <button type="submit" class="btn btn-primary w-100 mb-3">
                <i class="bi bi-box-arrow-in-right me-1"></i>Se Connecter
            </button>
        </form>

        <p class="text-center text-muted mb-0">
            Pas encore de compte ? <a href="/register" class="text-decoration-none" style="color: var(--sea); font-weight:600;">S'inscrire</a>
        </p>
    </div>
</div>
