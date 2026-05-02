<?php

class AboutController {
    public static function index(): void {
        $db = Database::get();
        
        // Get some stats for the about page
        $productCount = (int)$db->query("SELECT COUNT(*) FROM produit")->fetchColumn();
        $categoryCount = (int)$db->query("SELECT COUNT(*) FROM categorie")->fetchColumn();
        $orderCount = (int)$db->query("SELECT COUNT(*) FROM commande WHERE statut = 'livree'")->fetchColumn();

        $pageTitle = 'À Propos — Pêche Marine TN';
        require VIEW_PATH . '/layouts/header.php';
        require VIEW_PATH . '/about/index.php';
        require VIEW_PATH . '/layouts/footer.php';
    }
}
