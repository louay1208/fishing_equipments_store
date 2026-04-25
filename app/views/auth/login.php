<div class="auth-container">
    <div class="auth-card card">
        <div class="text-center mb-3">
            <span style="font-size: 2.5rem;">🎣</span>
        </div>
        <h2 class="text-center">Connexion</h2>
        <p class="subtitle text-center">Connectez-vous à votre compte Pêche Marine TN</p>

        <form method="POST" action="/login">
            <div class="mb-3">
                <label for="email" class="form-label">Adresse Email</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="votre@email.com" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Mot de passe</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="••••••••" required>
            </div>
            <button type="submit" class="btn btn-primary w-100 mb-3">
                <i class="bi bi-box-arrow-in-right me-1"></i>Se Connecter
            </button>
        </form>

        <p class="text-center text-muted mb-0">
            Pas encore de compte ? <a href="/register" class="text-decoration-none" style="color: var(--teal-500);">S'inscrire</a>
        </p>
    </div>
</div>
