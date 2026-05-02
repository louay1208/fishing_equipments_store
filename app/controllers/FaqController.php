<?php

class FaqController {
    public static function index(): void {
        $pageTitle = 'FAQ — Pêche Marine TN';
        require VIEW_PATH . '/layouts/header.php';
        require VIEW_PATH . '/faq/index.php';
        require VIEW_PATH . '/layouts/footer.php';
    }
}
