<?php

class ProfileController {
    public static function index(): void {
        requireAuth();
        $db = Database::get();
        $stmt = $db->prepare("SELECT * FROM utilisateur WHERE id = ?");
        $stmt->execute([$_SESSION['user_id']]);
        $user = $stmt->fetch();

        $pageTitle = 'Mon Profil — Pêche Marine TN';
        require VIEW_PATH . '/layouts/header.php';
        require VIEW_PATH . '/profile/index.php';
        require VIEW_PATH . '/layouts/footer.php';
    }

    public static function update(): void {
        requireAuth();
        $db = Database::get();
        $userId = $_SESSION['user_id'];

        $nom = trim($_POST['nom'] ?? '');
        $prenom = trim($_POST['prenom'] ?? '');
        $telephone = trim($_POST['telephone'] ?? '');
        $adresse = trim($_POST['adresse'] ?? '');
        $newPassword = $_POST['new_password'] ?? '';
        $currentPassword = $_POST['current_password'] ?? '';

        if (!$nom || !$prenom) {
            flash('error', 'Le nom et le prénom sont obligatoires.');
            redirect('/profile');
        }

        // Handle avatar upload
        if (!empty($_FILES['avatar']['name']) && $_FILES['avatar']['error'] === UPLOAD_ERR_OK) {
            $ext = strtolower(pathinfo($_FILES['avatar']['name'], PATHINFO_EXTENSION));
            $allowed = ['jpg', 'jpeg', 'png', 'webp'];
            if (in_array($ext, $allowed) && $_FILES['avatar']['size'] <= 2 * 1024 * 1024) {
                $avatarName = 'avatar_' . $userId . '.' . $ext;
                $dest = BASE_PATH . '/public/assets/images/avatars/' . $avatarName;
                move_uploaded_file($_FILES['avatar']['tmp_name'], $dest);
                $stmtAvatar = $db->prepare("UPDATE utilisateur SET avatar=? WHERE id=?");
                $stmtAvatar->execute([$avatarName, $userId]);
                $_SESSION['user_avatar'] = $avatarName;
            }
        }

        // Update basic info
        $stmt = $db->prepare("UPDATE utilisateur SET nom=?, prenom=?, telephone=?, adresse=? WHERE id=?");
        $stmt->execute([$nom, $prenom, $telephone, $adresse, $userId]);
        $_SESSION['user_name'] = $prenom;

        // Update password if requested
        if ($newPassword) {
            if (strlen($newPassword) < 6) {
                flash('error', 'Le nouveau mot de passe doit contenir au moins 6 caractères.');
                redirect('/profile');
            }
            $stmt = $db->prepare("SELECT mot_de_passe FROM utilisateur WHERE id = ?");
            $stmt->execute([$userId]);
            $user = $stmt->fetch();
            
            if (!password_verify($currentPassword, $user['mot_de_passe'])) {
                flash('error', 'Mot de passe actuel incorrect.');
                redirect('/profile');
            }
            $stmt = $db->prepare("UPDATE utilisateur SET mot_de_passe = ? WHERE id = ?");
            $stmt->execute([password_hash($newPassword, PASSWORD_DEFAULT), $userId]);
        }

        flash('success', 'Profil mis à jour avec succès !');
        redirect('/profile');
    }
}
