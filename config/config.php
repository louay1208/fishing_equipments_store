<?php
// Application configuration
define('APP_NAME', 'Pêche Marine TN');
define('APP_URL', 'http://localhost:8000');

// ═══════════════════════════════════════════
// DATABASE CONFIGURATION
// ═══════════════════════════════════════════
//
// DB_MODE = 'sqlite' → Zero config, uses local file (default)
// DB_MODE = 'mysql'  → XAMPP / production MySQL server
//
// To use MySQL (XAMPP), change 'sqlite' to 'mysql' below:
define('DB_MODE', 'sqlite');

// MySQL settings (only used when DB_MODE = 'mysql')
define('DB_HOST', 'localhost');
define('DB_NAME', 'peche_marine');
define('DB_USER', 'root');
define('DB_PASS', '');    // XAMPP default = empty

// Paths (may already be defined by front controller)
if (!defined('BASE_PATH')) define('BASE_PATH', dirname(__DIR__));
if (!defined('APP_PATH'))  define('APP_PATH', BASE_PATH . '/app');
if (!defined('VIEW_PATH')) define('VIEW_PATH', APP_PATH . '/views');
if (!defined('DB_PATH'))   define('DB_PATH', BASE_PATH . '/database/peche_marine.db');
if (!defined('UPLOAD_PATH')) define('UPLOAD_PATH', BASE_PATH . '/public/assets/images/products');

// Session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Helper functions
function redirect(string $path): void {
    header("Location: $path");
    exit;
}

function old(string $key, string $default = ''): string {
    return htmlspecialchars($_SESSION['old'][$key] ?? $default);
}

function flash(string $key, ?string $value = null): ?string {
    if ($value !== null) {
        $_SESSION['flash'][$key] = $value;
        return null;
    }
    $msg = $_SESSION['flash'][$key] ?? null;
    unset($_SESSION['flash'][$key]);
    return $msg;
}

function isLoggedIn(): bool {
    return isset($_SESSION['user_id']);
}

function isAdmin(): bool {
    return ($_SESSION['user_role'] ?? '') === 'admin';
}

function requireAuth(): void {
    if (!isLoggedIn()) {
        flash('error', 'Veuillez vous connecter.');
        redirect('/login');
    }
}

function requireAdmin(): void {
    if (!isAdmin()) {
        flash('error', 'Accès non autorisé.');
        redirect('/');
    }
}

function e(string $str): string {
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}
