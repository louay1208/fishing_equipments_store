<?php

class ReviewController {
    public static function store(): void {
        requireAuth();
        $db = Database::get();
        
        $productId = (int)($_POST['product_id'] ?? 0);
        $note = (int)($_POST['note'] ?? 0);
        $commentaire = trim($_POST['commentaire'] ?? '');

        if (!$productId || $note < 1 || $note > 5) {
            flash('error', 'Veuillez donner une note entre 1 et 5.');
            redirect('/products/' . $productId);
        }

        // Check if user already reviewed this product
        $stmt = $db->prepare("SELECT id FROM avis WHERE utilisateur_id = ? AND produit_id = ?");
        $stmt->execute([$_SESSION['user_id'], $productId]);
        if ($stmt->fetch()) {
            flash('error', 'Vous avez déjà donné votre avis sur ce produit.');
            redirect('/products/' . $productId);
        }

        $stmt = $db->prepare("INSERT INTO avis (utilisateur_id, produit_id, note, commentaire) VALUES (?, ?, ?, ?)");
        $stmt->execute([$_SESSION['user_id'], $productId, $note, $commentaire ?: null]);

        flash('success', 'Merci pour votre avis !');
        redirect('/products/' . $productId);
    }

    public static function delete(): void {
        requireAuth();
        $db = Database::get();
        
        $reviewId = (int)($_POST['review_id'] ?? 0);
        $productId = (int)($_POST['product_id'] ?? 0);

        // Only allow deleting own reviews (or admin)
        $where = isAdmin() ? "id = ?" : "id = ? AND utilisateur_id = " . (int)$_SESSION['user_id'];
        $stmt = $db->prepare("DELETE FROM avis WHERE $where");
        $stmt->execute([$reviewId]);

        flash('success', 'Avis supprimé.');
        redirect('/products/' . $productId);
    }
}
