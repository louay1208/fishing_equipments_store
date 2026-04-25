<?php

class CartController {
    public static function index(): void {
        requireAuth();
        $db = Database::get();
        
        $stmt = $db->prepare("SELECT lp.*, p.nom, p.prix, p.image, p.quantite_stock
            FROM ligne_panier lp
            JOIN panier pa ON pa.id = lp.panier_id
            JOIN produit p ON p.id = lp.produit_id
            WHERE pa.utilisateur_id = ?");
        $stmt->execute([$_SESSION['user_id']]);
        $items = $stmt->fetchAll();

        $subtotal = array_reduce($items, fn($sum, $item) => $sum + ($item['prix'] * $item['quantite']), 0);
        $shipping = $subtotal > 0 ? 7.00 : 0;
        $total = $subtotal + $shipping;

        $pageTitle = 'Mon Panier — Pêche Marine TN';
        require VIEW_PATH . '/layouts/header.php';
        require VIEW_PATH . '/cart/index.php';
        require VIEW_PATH . '/layouts/footer.php';
    }

    private static function getOrCreateCart(int $userId): int {
        $db = Database::get();
        $stmt = $db->prepare("SELECT id FROM panier WHERE utilisateur_id = ?");
        $stmt->execute([$userId]);
        $cart = $stmt->fetch();
        if ($cart) return $cart['id'];

        $stmt = $db->prepare("INSERT INTO panier (utilisateur_id) VALUES (?)");
        $stmt->execute([$userId]);
        return (int)$db->lastInsertId();
    }

    public static function add(): void {
        requireAuth();
        $productId = (int)($_POST['product_id'] ?? 0);
        $quantity = max(1, (int)($_POST['quantity'] ?? 1));

        $db = Database::get();

        // Check product exists and has stock
        $stmt = $db->prepare("SELECT * FROM produit WHERE id = ?");
        $stmt->execute([$productId]);
        $product = $stmt->fetch();
        if (!$product || $product['quantite_stock'] < 1) {
            flash('error', 'Produit non disponible.');
            redirect('/products');
        }

        $cartId = self::getOrCreateCart($_SESSION['user_id']);

        // Check if already in cart
        $stmt = $db->prepare("SELECT * FROM ligne_panier WHERE panier_id = ? AND produit_id = ?");
        $stmt->execute([$cartId, $productId]);
        $existing = $stmt->fetch();

        if ($existing) {
            $newQty = min($existing['quantite'] + $quantity, $product['quantite_stock']);
            $stmt = $db->prepare("UPDATE ligne_panier SET quantite = ? WHERE id = ?");
            $stmt->execute([$newQty, $existing['id']]);
        } else {
            $qty = min($quantity, $product['quantite_stock']);
            $stmt = $db->prepare("INSERT INTO ligne_panier (panier_id, produit_id, quantite) VALUES (?,?,?)");
            $stmt->execute([$cartId, $productId, $qty]);
        }

        flash('success', 'Produit ajouté au panier !');
        redirect($_SERVER['HTTP_REFERER'] ?? '/cart');
    }

    public static function update(): void {
        requireAuth();
        $lineId = (int)($_POST['line_id'] ?? 0);
        $quantity = (int)($_POST['quantity'] ?? 0);
        $db = Database::get();

        if ($quantity < 1) {
            $stmt = $db->prepare("DELETE FROM ligne_panier WHERE id = ? AND panier_id IN (SELECT id FROM panier WHERE utilisateur_id = ?)");
            $stmt->execute([$lineId, $_SESSION['user_id']]);
        } else {
            $stmt = $db->prepare("UPDATE ligne_panier SET quantite = ? WHERE id = ? AND panier_id IN (SELECT id FROM panier WHERE utilisateur_id = ?)");
            $stmt->execute([$quantity, $lineId, $_SESSION['user_id']]);
        }

        redirect('/cart');
    }

    public static function remove(): void {
        requireAuth();
        $lineId = (int)($_POST['line_id'] ?? 0);
        $db = Database::get();
        $stmt = $db->prepare("DELETE FROM ligne_panier WHERE id = ? AND panier_id IN (SELECT id FROM panier WHERE utilisateur_id = ?)");
        $stmt->execute([$lineId, $_SESSION['user_id']]);

        flash('success', 'Produit retiré du panier.');
        redirect('/cart');
    }
}
