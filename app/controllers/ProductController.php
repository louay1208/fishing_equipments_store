<?php

class ProductController {
    public static function index(): void {
        $db = Database::get();
        $categories = $db->query("SELECT * FROM categorie ORDER BY nom")->fetchAll();

        // Build query with filters
        $where = [];
        $params = [];
        
        $categoryId = $_GET['category'] ?? null;
        if ($categoryId) {
            $where[] = "p.categorie_id = ?";
            $params[] = (int)$categoryId;
        }

        $search = trim($_GET['q'] ?? '');
        if ($search) {
            $where[] = "(p.nom LIKE ? OR p.description LIKE ?)";
            $params[] = "%$search%";
            $params[] = "%$search%";
        }

        $whereClause = $where ? 'WHERE ' . implode(' AND ', $where) : '';
        
        // Sort
        $sort = $_GET['sort'] ?? 'newest';
        $orderBy = match($sort) {
            'price_asc' => 'p.prix ASC',
            'price_desc' => 'p.prix DESC',
            'name' => 'p.nom ASC',
            default => 'p.created_at DESC',
        };

        // Pagination
        $page = max(1, (int)($_GET['page'] ?? 1));
        $perPage = 12;
        $offset = ($page - 1) * $perPage;

        $countStmt = $db->prepare("SELECT COUNT(*) FROM produit p $whereClause");
        $countStmt->execute($params);
        $total = (int)$countStmt->fetchColumn();
        $totalPages = max(1, ceil($total / $perPage));

        $sql = "SELECT p.*, c.nom as categorie_nom FROM produit p 
                LEFT JOIN categorie c ON c.id = p.categorie_id 
                $whereClause ORDER BY $orderBy LIMIT $perPage OFFSET $offset";
        $stmt = $db->prepare($sql);
        $stmt->execute($params);
        $products = $stmt->fetchAll();

        $pageTitle = 'Catalogue — Pêche Marine TN';
        require VIEW_PATH . '/layouts/header.php';
        require VIEW_PATH . '/products/index.php';
        require VIEW_PATH . '/layouts/footer.php';
    }

    public static function show(int $id): void {
        $db = Database::get();
        $stmt = $db->prepare("SELECT p.*, c.nom as categorie_nom FROM produit p 
            LEFT JOIN categorie c ON c.id = p.categorie_id WHERE p.id = ?");
        $stmt->execute([$id]);
        $product = $stmt->fetch();

        if (!$product) {
            flash('error', 'Produit introuvable.');
            redirect('/products');
        }

        // Related products
        $stmt = $db->prepare("SELECT * FROM produit WHERE categorie_id = ? AND id != ? LIMIT 4");
        $stmt->execute([$product['categorie_id'], $id]);
        $related = $stmt->fetchAll();

        $pageTitle = $product['nom'] . ' — Pêche Marine TN';
        require VIEW_PATH . '/layouts/header.php';
        require VIEW_PATH . '/products/show.php';
        require VIEW_PATH . '/layouts/footer.php';
    }
}
