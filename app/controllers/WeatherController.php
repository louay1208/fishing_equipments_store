<?php

class WeatherController {

    public static function index(): void {
        $pageTitle = 'Météo Marine — Pêche Marine TN';
        require VIEW_PATH . '/layouts/header.php';
        require VIEW_PATH . '/weather/index.php';
        require VIEW_PATH . '/layouts/footer.php';
    }
}
