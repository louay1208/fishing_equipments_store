<?php

class AuthController {
    public static function loginForm(): void {
        if (isLoggedIn()) redirect('/');
        $pageTitle = 'Connexion — Pêche Marine TN';
        require VIEW_PATH . '/layouts/header.php';
        require VIEW_PATH . '/auth/login.php';
        require VIEW_PATH . '/layouts/footer.php';
    }

    public static function login(): void {
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';

        if (!$email || !$password) {
            flash('error', 'Veuillez remplir tous les champs.');
            redirect('/login');
        }

        $db = Database::get();
        $stmt = $db->prepare("SELECT * FROM utilisateur WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if (!$user || !password_verify($password, $user['mot_de_passe'])) {
            flash('error', 'Email ou mot de passe incorrect.');
            redirect('/login');
        }

        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['prenom'];
        $_SESSION['user_role'] = $user['role'];
        
        flash('success', 'Bienvenue, ' . $user['prenom'] . ' !');
        redirect($user['role'] === 'admin' ? '/admin' : '/');
    }

    public static function registerForm(): void {
        if (isLoggedIn()) redirect('/');
        $pageTitle = 'Inscription — Pêche Marine TN';
        require VIEW_PATH . '/layouts/header.php';
        require VIEW_PATH . '/auth/register.php';
        require VIEW_PATH . '/layouts/footer.php';
    }

    public static function register(): void {
        $data = [
            'nom' => trim($_POST['nom'] ?? ''),
            'prenom' => trim($_POST['prenom'] ?? ''),
            'email' => trim($_POST['email'] ?? ''),
            'password' => $_POST['password'] ?? '',
            'password_confirm' => $_POST['password_confirm'] ?? '',
            'telephone' => trim($_POST['telephone'] ?? ''),
            'adresse' => trim($_POST['adresse'] ?? ''),
        ];

        // Validation
        if (!$data['nom'] || !$data['prenom'] || !$data['email'] || !$data['password']) {
            $_SESSION['old'] = $data;
            flash('error', 'Veuillez remplir tous les champs obligatoires.');
            redirect('/register');
        }
        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $_SESSION['old'] = $data;
            flash('error', 'Adresse email invalide.');
            redirect('/register');
        }
        if (strlen($data['password']) < 6) {
            $_SESSION['old'] = $data;
            flash('error', 'Le mot de passe doit contenir au moins 6 caractères.');
            redirect('/register');
        }
        if ($data['password'] !== $data['password_confirm']) {
            $_SESSION['old'] = $data;
            flash('error', 'Les mots de passe ne correspondent pas.');
            redirect('/register');
        }

        $db = Database::get();
        
        // Check email uniqueness
        $stmt = $db->prepare("SELECT id FROM utilisateur WHERE email = ?");
        $stmt->execute([$data['email']]);
        if ($stmt->fetch()) {
            $_SESSION['old'] = $data;
            flash('error', 'Cette adresse email est déjà utilisée.');
            redirect('/register');
        }

        // Insert user
        $stmt = $db->prepare("INSERT INTO utilisateur (nom, prenom, email, mot_de_passe, telephone, adresse) VALUES (?,?,?,?,?,?)");
        $stmt->execute([
            $data['nom'],
            $data['prenom'],
            $data['email'],
            password_hash($data['password'], PASSWORD_DEFAULT),
            $data['telephone'],
            $data['adresse'],
        ]);

        $userId = $db->lastInsertId();
        
        // Create cart for user
        $stmt = $db->prepare("INSERT INTO panier (utilisateur_id) VALUES (?)");
        $stmt->execute([$userId]);

        // Auto-login
        $_SESSION['user_id'] = $userId;
        $_SESSION['user_name'] = $data['prenom'];
        $_SESSION['user_role'] = 'client';
        unset($_SESSION['old']);

        flash('success', 'Inscription réussie ! Bienvenue, ' . $data['prenom'] . ' !');
        redirect('/');
    }

    public static function logout(): void {
        session_destroy();
        session_start();
        flash('success', 'Vous êtes déconnecté.');
        redirect('/');
    }
}
