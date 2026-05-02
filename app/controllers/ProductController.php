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

        $sql = "SELECT p.*, c.nom as categorie_nom,
                COALESCE((SELECT ROUND(AVG(a.note),1) FROM avis a WHERE a.produit_id = p.id), 0) as avg_rating,
                (SELECT COUNT(*) FROM avis a WHERE a.produit_id = p.id) as review_count
                FROM produit p 
                LEFT JOIN categorie c ON c.id = p.categorie_id 
                $whereClause ORDER BY $orderBy LIMIT $perPage OFFSET $offset";
        $stmt = $db->prepare($sql);
        $stmt->execute($params);
        $products = $stmt->fetchAll();

        // Get user's wishlist product IDs
        $wishlistIds = [];
        if (isLoggedIn()) {
            $stmt = $db->prepare("SELECT produit_id FROM favori WHERE utilisateur_id = ?");
            $stmt->execute([$_SESSION['user_id']]);
            $wishlistIds = $stmt->fetchAll(PDO::FETCH_COLUMN);
        }

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

        // Reviews
        $stmt = $db->prepare("SELECT a.*, u.nom as user_nom, u.prenom as user_prenom, u.avatar as user_avatar
            FROM avis a JOIN utilisateur u ON u.id = a.utilisateur_id
            WHERE a.produit_id = ? ORDER BY a.created_at DESC");
        $stmt->execute([$id]);
        $reviews = $stmt->fetchAll();

        $avgRating = 0;
        if (!empty($reviews)) {
            $avgRating = round(array_sum(array_column($reviews, 'note')) / count($reviews), 1);
        }

        // Check if user already reviewed
        $userReviewed = false;
        if (isLoggedIn()) {
            $stmt = $db->prepare("SELECT id FROM avis WHERE utilisateur_id = ? AND produit_id = ?");
            $stmt->execute([$_SESSION['user_id'], $id]);
            $userReviewed = (bool)$stmt->fetch();
        }

        // Check if in wishlist
        $inWishlist = false;
        if (isLoggedIn()) {
            $stmt = $db->prepare("SELECT id FROM favori WHERE utilisateur_id = ? AND produit_id = ?");
            $stmt->execute([$_SESSION['user_id'], $id]);
            $inWishlist = (bool)$stmt->fetch();
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

    public static function search(): void {
        $db = Database::get();
        $q = trim($_GET['q'] ?? '');
        
        if (strlen($q) < 2) {
            header('Content-Type: application/json');
            echo json_encode([]);
            return;
        }

        $stmt = $db->prepare("SELECT p.id, p.nom, p.prix, p.image, c.nom as categorie_nom
            FROM produit p LEFT JOIN categorie c ON c.id = p.categorie_id
            WHERE p.nom LIKE ? OR p.description LIKE ?
            ORDER BY p.nom LIMIT 6");
        $stmt->execute(["%$q%", "%$q%"]);
        $results = $stmt->fetchAll();

        header('Content-Type: application/json');
        echo json_encode($results);
    }
}
