<?php
$initials = strtoupper(mb_substr($user['prenom'],0,1) . mb_substr($user['nom'],0,1));
?>

<div class="page-header" style="background: linear-gradient(165deg, var(--sea-subtle) 0%, var(--bg) 100%);">
    <div class="container">
        <div class="d-flex align-items-center gap-3">
            <?php if (!empty($user['avatar'])): ?>
                <img src="/assets/images/avatars/<?= e($user['avatar']) ?>" style="width:56px;height:56px;border-radius:50%;object-fit:cover;border:3px solid var(--sea);">
            <?php else: ?>
                <div style="width:56px;height:56px;border-radius:50%;background:linear-gradient(135deg,var(--ocean),var(--sea));color:#fff;display:flex;align-items:center;justify-content:center;font-size:1.3rem;font-weight:700;">
                    <?= $initials ?>
                </div>
            <?php endif; ?>
            <div>
                <h1 class="mb-0" style="color:var(--ocean); font-size:1.5rem;"><i class="bi bi-person me-2"></i>Mon Profil</h1>
                <p class="text-muted mb-0" style="font-size:0.88rem;"><?= e($user['email']) ?></p>
            </div>
        </div>
    </div>
</div>

<div class="container pb-5">
    <div class="row g-4 justify-content-center">
        <div class="col-lg-8">
            <form method="POST" action="/profile" enctype="multipart/form-data">
                <!-- Avatar Section -->
                <div class="card p-4 mb-4 text-center" style="border-top: 3px solid var(--sea);">
                    <h5 class="fw-bold mb-3" style="color:var(--ocean);">Photo de Profil</h5>
                    <div class="d-flex flex-column align-items-center gap-3">
                        <?php if (!empty($user['avatar'])): ?>
                            <img src="/assets/images/avatars/<?= e($user['avatar']) ?>" style="width:100px;height:100px;border-radius:50%;object-fit:cover;border:3px solid var(--sea);">
                        <?php else: ?>
                            <div style="width:100px;height:100px;border-radius:50%;background:linear-gradient(135deg,var(--ocean),var(--sea));color:#fff;display:flex;align-items:center;justify-content:center;font-size:2.2rem;font-weight:700;">
                                <?= $initials ?>
                            </div>
                        <?php endif; ?>
                        <div>
                            <label class="btn btn-outline-primary btn-sm" style="cursor:pointer;">
                                <i class="bi bi-camera me-1"></i>Changer la photo
                                <input type="file" name="avatar" accept="image/*" hidden onchange="previewAvatar(this)">
                            </label>
                            <div class="form-text mt-1">JPG, PNG ou WebP • Max 2 Mo</div>
                        </div>
                    </div>
                </div>

                <!-- Personal Info -->
                <div class="card p-4" style="border-top: 3px solid var(--sea);">
                    <h5 class="fw-bold mb-3" style="color:var(--ocean);">Informations Personnelles</h5>
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label for="nom" class="form-label">Nom</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-person"></i></span>
                                <input type="text" class="form-control" id="nom" name="nom" value="<?= e($user['nom']) ?>" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="prenom" class="form-label">Prénom</label>
                            <input type="text" class="form-control" id="prenom" name="prenom" value="<?= e($user['prenom']) ?>" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                            <input type="email" class="form-control" value="<?= e($user['email']) ?>" disabled>
                        </div>
                        <div class="form-text">L'email ne peut pas être modifié.</div>
                    </div>
                    <div class="mb-3">
                        <label for="telephone" class="form-label">Téléphone</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-telephone"></i></span>
                            <input type="tel" class="form-control" id="telephone" name="telephone" value="<?= e($user['telephone'] ?? '') ?>">
                        </div>
                    </div>
                    <div class="mb-4">
                        <label for="adresse" class="form-label">Adresse</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-geo-alt"></i></span>
                            <input type="text" class="form-control" id="adresse" name="adresse" value="<?= e($user['adresse'] ?? '') ?>">
                        </div>
                    </div>

                    <hr>
                    <h5 class="fw-bold mb-3" style="color:var(--ocean);"><i class="bi bi-lock me-1"></i>Changer le Mot de Passe</h5>
                    <p class="text-muted" style="font-size: 0.85rem;">Laissez vide si vous ne souhaitez pas changer le mot de passe.</p>
                    <div class="mb-3">
                        <label for="current_password" class="form-label">Mot de passe actuel</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-lock"></i></span>
                            <input type="password" class="form-control" id="current_password" name="current_password">
                        </div>
                    </div>
                    <div class="mb-4">
                        <label for="new_password" class="form-label">Nouveau mot de passe</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-shield-lock"></i></span>
                            <input type="password" class="form-control" id="new_password" name="new_password" placeholder="Min. 6 caractères">
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-lg me-1"></i>Enregistrer les Modifications
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function previewAvatar(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const img = input.closest('.card').querySelector('img, div[style*="border-radius:50%"]');
            if (img.tagName === 'IMG') {
                img.src = e.target.result;
            } else {
                const newImg = document.createElement('img');
                newImg.src = e.target.result;
                newImg.style = 'width:100px;height:100px;border-radius:50%;object-fit:cover;border:3px solid var(--sea);';
                img.replaceWith(newImg);
            }
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
