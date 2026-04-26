<div class="auth-container" style="max-width: 520px;">
    <div class="auth-card card">
        <div class="text-center mb-3">
            <span style="font-size: 2.5rem;">🎣</span>
        </div>
        <h2 class="text-center">Créer un Compte</h2>
        <p class="subtitle text-center">Rejoignez la communauté Pêche Marine TN</p>

        <form method="POST" action="/register">
            <div class="row g-3 mb-3">
                <div class="col-6">
                    <label for="nom" class="form-label">Nom *</label>
                    <input type="text" class="form-control" id="nom" name="nom" value="<?= old('nom') ?>" required>
                </div>
                <div class="col-6">
                    <label for="prenom" class="form-label">Prénom *</label>
                    <input type="text" class="form-control" id="prenom" name="prenom" value="<?= old('prenom') ?>" required>
                </div>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Adresse Email *</label>
                <input type="email" class="form-control" id="email" name="email" value="<?= old('email') ?>" placeholder="votre@email.com" required>
            </div>
            <div class="mb-3">
                <label for="telephone" class="form-label">Téléphone</label>
                <input type="tel" class="form-control" id="telephone" name="telephone" value="<?= old('telephone') ?>" placeholder="XX XXX XXX">
            </div>
            <div class="mb-3">
                <label for="adresse" class="form-label">Adresse</label>
                <input type="text" class="form-control" id="adresse" name="adresse" value="<?= old('adresse') ?>" placeholder="Ville, Tunisie">
            </div>
            <div class="row g-3 mb-3">
                <div class="col-6">
                    <label for="password" class="form-label">Mot de passe *</label>
                    <div class="input-group">
                        <input type="password" class="form-control" id="password" name="password" placeholder="Min. 6 caractères" required>
                        <button class="btn btn-outline-secondary toggle-password" type="button" data-target="password" tabindex="-1">
                            <i class="bi bi-eye"></i>
                        </button>
                    </div>
                </div>
                <div class="col-6">
                    <label for="password_confirm" class="form-label">Confirmer *</label>
                    <div class="input-group">
                        <input type="password" class="form-control" id="password_confirm" name="password_confirm" placeholder="••••••••" required>
                        <button class="btn btn-outline-secondary toggle-password" type="button" data-target="password_confirm" tabindex="-1">
                            <i class="bi bi-eye"></i>
                        </button>
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-primary w-100 mb-3">
                <i class="bi bi-person-plus me-1"></i>S'inscrire
            </button>
        </form>

        <p class="text-center text-muted mb-0">
            Déjà inscrit ? <a href="/login" class="text-decoration-none" style="color: var(--teal-500);">Se connecter</a>
        </p>
    </div>
</div>
