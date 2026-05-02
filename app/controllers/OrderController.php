<?php

class OrderController {
    public static function checkout(): void {
        requireAuth();
        $db = Database::get();
        
        $stmt = $db->prepare("SELECT lp.*, p.nom, p.prix, p.quantite_stock
            FROM ligne_panier lp
            JOIN panier pa ON pa.id = lp.panier_id
            JOIN produit p ON p.id = lp.produit_id
            WHERE pa.utilisateur_id = ?");
        $stmt->execute([$_SESSION['user_id']]);
        $items = $stmt->fetchAll();

        if (empty($items)) {
            flash('error', 'Votre panier est vide.');
            redirect('/cart');
        }

        // Get user info for pre-fill
        $stmt = $db->prepare("SELECT * FROM utilisateur WHERE id = ?");
        $stmt->execute([$_SESSION['user_id']]);
        $user = $stmt->fetch();

        $subtotal = array_reduce($items, fn($s, $i) => $s + ($i['prix'] * $i['quantite']), 0);
        $shipping = 7.00;
        $total = $subtotal + $shipping;

        $pageTitle = 'Passer la Commande — Pêche Marine TN';
        require VIEW_PATH . '/layouts/header.php';
        require VIEW_PATH . '/orders/checkout.php';
        require VIEW_PATH . '/layouts/footer.php';
    }

    public static function store(): void {
        requireAuth();
        $db = Database::get();
        $userId = $_SESSION['user_id'];

        $adresse = trim($_POST['adresse'] ?? '');
        $telephone = trim($_POST['telephone'] ?? '');

        if (!$adresse || !$telephone) {
            flash('error', 'Veuillez remplir tous les champs.');
            redirect('/checkout');
        }

        // Get cart items
        $stmt = $db->prepare("SELECT lp.*, p.prix, p.quantite_stock
            FROM ligne_panier lp
            JOIN panier pa ON pa.id = lp.panier_id
            JOIN produit p ON p.id = lp.produit_id
            WHERE pa.utilisateur_id = ?");
        $stmt->execute([$userId]);
        $items = $stmt->fetchAll();

        if (empty($items)) {
            flash('error', 'Panier vide.');
            redirect('/cart');
        }

        // Verify stock
        foreach ($items as $item) {
            if ($item['quantite'] > $item['quantite_stock']) {
                flash('error', 'Stock insuffisant pour certains produits.');
                redirect('/cart');
            }
        }

        $subtotal = array_reduce($items, fn($s, $i) => $s + ($i['prix'] * $i['quantite']), 0);
        $total = $subtotal + 7.00;

        $db->beginTransaction();
        try {
            // Create order
            $stmt = $db->prepare("INSERT INTO commande (utilisateur_id, total, adresse_livraison, telephone) VALUES (?,?,?,?)");
            $stmt->execute([$userId, $total, $adresse, $telephone]);
            $orderId = $db->lastInsertId();

            // Create order lines and update stock
            foreach ($items as $item) {
                $stmt = $db->prepare("INSERT INTO ligne_commande (commande_id, produit_id, quantite, prix_unitaire) VALUES (?,?,?,?)");
                $stmt->execute([$orderId, $item['produit_id'], $item['quantite'], $item['prix']]);

                $stmt = $db->prepare("UPDATE produit SET quantite_stock = quantite_stock - ? WHERE id = ?");
                $stmt->execute([$item['quantite'], $item['produit_id']]);
            }

            // Clear cart
            $stmt = $db->prepare("DELETE FROM ligne_panier WHERE panier_id IN (SELECT id FROM panier WHERE utilisateur_id = ?)");
            $stmt->execute([$userId]);

            $db->commit();
            flash('success', 'Commande #' . $orderId . ' passée avec succès !');
            redirect('/orders/' . $orderId);
        } catch (Exception $e) {
            $db->rollBack();
            flash('error', 'Erreur lors de la commande. Veuillez réessayer.');
            redirect('/cart');
        }
    }

    public static function history(): void {
        requireAuth();
        $db = Database::get();
        $stmt = $db->prepare("SELECT * FROM commande WHERE utilisateur_id = ? ORDER BY date_commande DESC");
        $stmt->execute([$_SESSION['user_id']]);
        $orders = $stmt->fetchAll();

        $pageTitle = 'Mes Commandes — Pêche Marine TN';
        require VIEW_PATH . '/layouts/header.php';
        require VIEW_PATH . '/orders/history.php';
        require VIEW_PATH . '/layouts/footer.php';
    }

    public static function show(int $id): void {
        requireAuth();
        $db = Database::get();
        
        $where = isAdmin() ? "c.id = ?" : "c.id = ? AND c.utilisateur_id = " . (int)$_SESSION['user_id'];
        $stmt = $db->prepare("SELECT c.*, u.nom, u.prenom, u.email FROM commande c JOIN utilisateur u ON u.id = c.utilisateur_id WHERE $where");
        $stmt->execute([$id]);
        $order = $stmt->fetch();

        if (!$order) {
            flash('error', 'Commande introuvable.');
            redirect('/orders');
        }

        $stmt = $db->prepare("SELECT lc.*, p.nom as produit_nom, p.image as produit_image FROM ligne_commande lc JOIN produit p ON p.id = lc.produit_id WHERE lc.commande_id = ?");
        $stmt->execute([$id]);
        $lines = $stmt->fetchAll();

        $pageTitle = 'Commande #' . $id . ' — Pêche Marine TN';
        require VIEW_PATH . '/layouts/header.php';
        require VIEW_PATH . '/orders/show.php';
        require VIEW_PATH . '/layouts/footer.php';
    }
}
