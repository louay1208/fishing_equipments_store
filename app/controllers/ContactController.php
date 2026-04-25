<?php

class ContactController {
    public static function index(): void {
        $pageTitle = 'Contact — Pêche Marine TN';
        require VIEW_PATH . '/layouts/header.php';
        require VIEW_PATH . '/contact/index.php';
        require VIEW_PATH . '/layouts/footer.php';
    }

    public static function store(): void {
        $nom = trim($_POST['nom'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $sujet = trim($_POST['sujet'] ?? '');
        $message = trim($_POST['message'] ?? '');

        if (!$nom || !$email || !$sujet || !$message) {
            flash('error', 'Veuillez remplir tous les champs.');
            redirect('/contact');
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            flash('error', 'Adresse email invalide.');
            redirect('/contact');
        }

        $db = Database::get();
        $stmt = $db->prepare("INSERT INTO contact (nom, email, sujet, message) VALUES (?,?,?,?)");
        $stmt->execute([$nom, $email, $sujet, $message]);

        flash('success', 'Message envoyé avec succès ! Nous vous répondrons bientôt.');
        redirect('/contact');
    }
}
