<?php

class AdminController {
    public static function dashboard(): void {
        requireAdmin();
        $db = Database::get();

        $stats = [
            'products' => $db->query("SELECT COUNT(*) FROM produit")->fetchColumn(),
            'orders' => $db->query("SELECT COUNT(*) FROM commande")->fetchColumn(),
            'pending' => $db->query("SELECT COUNT(*) FROM commande WHERE statut='en_attente'")->fetchColumn(),
            'users' => $db->query("SELECT COUNT(*) FROM utilisateur WHERE role='client'")->fetchColumn(),
            'revenue' => $db->query("SELECT COALESCE(SUM(total),0) FROM commande WHERE statut != 'annulee'")->fetchColumn(),
        ];

        $recentOrders = $db->query("SELECT c.*, u.nom, u.prenom FROM commande c JOIN utilisateur u ON u.id = c.utilisateur_id ORDER BY c.date_commande DESC LIMIT 5")->fetchAll();

        $pageTitle = 'Admin — Pêche Marine TN';
        require VIEW_PATH . '/layouts/header.php';
        require VIEW_PATH . '/admin/dashboard.php';
        require VIEW_PATH . '/layouts/footer.php';
    }

    public static function products(): void {
        requireAdmin();
        $db = Database::get();
        $products = $db->query("SELECT p.*, c.nom as categorie_nom FROM produit p LEFT JOIN categorie c ON c.id = p.categorie_id ORDER BY p.id DESC")->fetchAll();
        $categories = $db->query("SELECT * FROM categorie ORDER BY nom")->fetchAll();

        $pageTitle = 'Gestion des Produits — Admin';
        require VIEW_PATH . '/layouts/header.php';
        require VIEW_PATH . '/admin/products.php';
        require VIEW_PATH . '/layouts/footer.php';
    }

    public static function storeProduct(): void {
        requireAdmin();
        $db = Database::get();
        $stmt = $db->prepare("INSERT INTO produit (nom, description, prix, quantite_stock, categorie_id) VALUES (?,?,?,?,?)");
        $stmt->execute([
            trim($_POST['nom'] ?? ''),
            trim($_POST['description'] ?? ''),
            (float)($_POST['prix'] ?? 0),
            (int)($_POST['quantite_stock'] ?? 0),
            (int)($_POST['categorie_id'] ?? null) ?: null,
        ]);
        flash('success', 'Produit ajouté avec succès.');
        redirect('/admin/products');
    }

    public static function updateProduct(): void {
        requireAdmin();
        $db = Database::get();
        $stmt = $db->prepare("UPDATE produit SET nom=?, description=?, prix=?, quantite_stock=?, categorie_id=? WHERE id=?");
        $stmt->execute([
            trim($_POST['nom'] ?? ''),
            trim($_POST['description'] ?? ''),
            (float)($_POST['prix'] ?? 0),
            (int)($_POST['quantite_stock'] ?? 0),
            (int)($_POST['categorie_id'] ?? null) ?: null,
            (int)($_POST['id'] ?? 0),
        ]);
        flash('success', 'Produit mis à jour.');
        redirect('/admin/products');
    }

    public static function deleteProduct(): void {
        requireAdmin();
        $db = Database::get();
        $stmt = $db->prepare("DELETE FROM produit WHERE id = ?");
        $stmt->execute([(int)($_POST['id'] ?? 0)]);
        flash('success', 'Produit supprimé.');
        redirect('/admin/products');
    }

    public static function categories(): void {
        requireAdmin();
        $db = Database::get();
        $categories = $db->query("SELECT c.*, (SELECT COUNT(*) FROM produit WHERE categorie_id = c.id) as product_count FROM categorie c ORDER BY c.nom")->fetchAll();

        $pageTitle = 'Gestion des Catégories — Admin';
        require VIEW_PATH . '/layouts/header.php';
        require VIEW_PATH . '/admin/categories.php';
        require VIEW_PATH . '/layouts/footer.php';
    }

    public static function storeCategory(): void {
        requireAdmin();
        $db = Database::get();
        $stmt = $db->prepare("INSERT INTO categorie (nom, description) VALUES (?,?)");
        $stmt->execute([trim($_POST['nom'] ?? ''), trim($_POST['description'] ?? '')]);
        flash('success', 'Catégorie ajoutée.');
        redirect('/admin/categories');
    }

    public static function deleteCategory(): void {
        requireAdmin();
        $db = Database::get();
        $id = (int)($_POST['id'] ?? 0);
        // Check if category has products
        $count = $db->prepare("SELECT COUNT(*) FROM produit WHERE categorie_id = ?");
        $count->execute([$id]);
        if ((int)$count->fetchColumn() > 0) {
            flash('error', 'Impossible de supprimer : cette catégorie contient des produits.');
            redirect('/admin/categories');
        }
        $stmt = $db->prepare("DELETE FROM categorie WHERE id = ?");
        $stmt->execute([$id]);
        flash('success', 'Catégorie supprimée.');
        redirect('/admin/categories');
    }

    public static function orders(): void {
        requireAdmin();
        $db = Database::get();
        $statusFilter = $_GET['status'] ?? '';
        $where = $statusFilter ? "WHERE c.statut = '" . e($statusFilter) . "'" : '';
        $orders = $db->query("SELECT c.*, u.nom, u.prenom, u.email FROM commande c JOIN utilisateur u ON u.id = c.utilisateur_id $where ORDER BY c.date_commande DESC")->fetchAll();

        $pageTitle = 'Gestion des Commandes — Admin';
        require VIEW_PATH . '/layouts/header.php';
        require VIEW_PATH . '/admin/orders.php';
        require VIEW_PATH . '/layouts/footer.php';
    }

    public static function updateStatus(): void {
        requireAdmin();
        $db = Database::get();
        $stmt = $db->prepare("UPDATE commande SET statut = ? WHERE id = ?");
        $stmt->execute([
            $_POST['statut'] ?? 'en_attente',
            (int)($_POST['id'] ?? 0),
        ]);
        flash('success', 'Statut mis à jour.');
        redirect($_SERVER['HTTP_REFERER'] ?? '/admin/orders');
    }
}
