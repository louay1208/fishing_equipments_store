<?php

class HomeController {
    public static function index(): void {
        $db = Database::get();
        $categories = $db->query("SELECT * FROM categorie ORDER BY id")->fetchAll();
        $featured = $db->query("SELECT p.*, c.nom as categorie_nom FROM produit p 
            LEFT JOIN categorie c ON c.id = p.categorie_id 
            ORDER BY p.created_at DESC LIMIT 8")->fetchAll();
        
        $pageTitle = 'Pêche Marine TN — Matériel de Pêche en Tunisie';
        require VIEW_PATH . '/layouts/header.php';
        require VIEW_PATH . '/home/index.php';
        require VIEW_PATH . '/layouts/footer.php';
    }
}
