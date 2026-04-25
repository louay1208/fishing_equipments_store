<div class="page-header">
    <div class="container">
        <h1><i class="bi bi-person me-2"></i>Mon Profil</h1>
    </div>
</div>

<div class="container pb-5">
    <div class="row g-4 justify-content-center">
        <div class="col-lg-8">
            <div class="card p-4">
                <h5 class="fw-bold mb-3">Informations Personnelles</h5>
                <form method="POST" action="/profile">
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label for="nom" class="form-label">Nom</label>
                            <input type="text" class="form-control" id="nom" name="nom" value="<?= e($user['nom']) ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label for="prenom" class="form-label">Prénom</label>
                            <input type="text" class="form-control" id="prenom" name="prenom" value="<?= e($user['prenom']) ?>" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control" value="<?= e($user['email']) ?>" disabled>
                        <div class="form-text">L'email ne peut pas être modifié.</div>
                    </div>
                    <div class="mb-3">
                        <label for="telephone" class="form-label">Téléphone</label>
                        <input type="tel" class="form-control" id="telephone" name="telephone" value="<?= e($user['telephone'] ?? '') ?>">
                    </div>
                    <div class="mb-4">
                        <label for="adresse" class="form-label">Adresse</label>
                        <input type="text" class="form-control" id="adresse" name="adresse" value="<?= e($user['adresse'] ?? '') ?>">
                    </div>

                    <hr>
                    <h5 class="fw-bold mb-3">Changer le Mot de Passe</h5>
                    <p class="text-muted" style="font-size: 0.85rem;">Laissez vide si vous ne souhaitez pas changer le mot de passe.</p>
                    <div class="mb-3">
                        <label for="current_password" class="form-label">Mot de passe actuel</label>
                        <input type="password" class="form-control" id="current_password" name="current_password">
                    </div>
                    <div class="mb-4">
                        <label for="new_password" class="form-label">Nouveau mot de passe</label>
                        <input type="password" class="form-control" id="new_password" name="new_password" placeholder="Min. 6 caractères">
                    </div>

                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-lg me-1"></i>Enregistrer les Modifications
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
