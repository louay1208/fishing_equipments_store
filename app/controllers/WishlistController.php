<?php

class WishlistController {
    public static function index(): void {
        requireAuth();
        $db = Database::get();

        $stmt = $db->prepare("SELECT p.*, c.nom as categorie_nom, f.created_at as fav_date
            FROM favori f
            JOIN produit p ON p.id = f.produit_id
            LEFT JOIN categorie c ON c.id = p.categorie_id
            WHERE f.utilisateur_id = ?
            ORDER BY f.created_at DESC");
        $stmt->execute([$_SESSION['user_id']]);
        $favorites = $stmt->fetchAll();

        $pageTitle = 'Mes Favoris — Pêche Marine TN';
        require VIEW_PATH . '/layouts/header.php';
        require VIEW_PATH . '/wishlist/index.php';
        require VIEW_PATH . '/layouts/footer.php';
    }

    public static function toggle(): void {
        requireAuth();
        $db = Database::get();

        $productId = (int)($_POST['product_id'] ?? 0);
        if (!$productId) {
            redirect('/products');
        }

        // Check if already in wishlist
        $stmt = $db->prepare("SELECT id FROM favori WHERE utilisateur_id = ? AND produit_id = ?");
        $stmt->execute([$_SESSION['user_id'], $productId]);
        $existing = $stmt->fetch();

        if ($existing) {
            $stmt = $db->prepare("DELETE FROM favori WHERE id = ?");
            $stmt->execute([$existing['id']]);
            flash('success', 'Produit retiré des favoris.');
        } else {
            $stmt = $db->prepare("INSERT INTO favori (utilisateur_id, produit_id) VALUES (?, ?)");
            $stmt->execute([$_SESSION['user_id'], $productId]);
            flash('success', 'Produit ajouté aux favoris ❤️');
        }

        // Redirect back
        $referer = $_SERVER['HTTP_REFERER'] ?? '/products';
        redirect($referer);
    }
}
