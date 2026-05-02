<?php

class Database {
    private static ?PDO $instance = null;

    public static function get(): PDO {
        if (self::$instance === null) {
            // ═══ CHOOSE YOUR DATABASE MODE ═══
            // Option 1: SQLite (default — zero config)
            // Option 2: MySQL  (XAMPP / production)
            //
            // To switch to MySQL, set DB_MODE to 'mysql' in config/config.php
            // and configure the DB_HOST, DB_NAME, DB_USER, DB_PASS constants.

            $mode = defined('DB_MODE') ? DB_MODE : 'sqlite';

            if ($mode === 'mysql') {
                $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4';
                self::$instance = new PDO($dsn, DB_USER, DB_PASS, [
                    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE  => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES    => false,
                ]);
                self::$instance->exec("SET NAMES utf8mb4");
            } else {
                // SQLite (default)
                $dir = dirname(DB_PATH);
                if (!is_dir($dir)) mkdir($dir, 0777, true);

                self::$instance = new PDO('sqlite:' . DB_PATH, null, null, [
                    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE  => PDO::FETCH_ASSOC,
                ]);
                self::$instance->exec('PRAGMA journal_mode=WAL');
                self::$instance->exec('PRAGMA foreign_keys=ON');
            }
        }
        return self::$instance;
    }

    public static function init(): void {
        $db = self::get();
        $mode = defined('DB_MODE') ? DB_MODE : 'sqlite';

        if ($mode === 'mysql') {
            // MySQL: check if tables exist, create if not
            $result = $db->query("SHOW TABLES LIKE 'categorie'")->fetch();
            if (!$result) {
                $schema = file_get_contents(BASE_PATH . '/database/schema_mysql.sql');
                // Execute statement by statement (MySQL doesn't support multi-exec well)
                $statements = array_filter(array_map('trim', explode(';', $schema)));
                foreach ($statements as $stmt) {
                    if (!empty($stmt) && stripos($stmt, 'CREATE DATABASE') === false && stripos($stmt, 'USE ') === false) {
                        $db->exec($stmt);
                    }
                }
            }
            // Seed if empty
            $count = $db->query("SELECT COUNT(*) FROM categorie")->fetchColumn();
            if ((int)$count === 0) {
                $seed = file_get_contents(BASE_PATH . '/database/seed_mysql.sql');
                $statements = array_filter(array_map('trim', explode(';', $seed)));
                foreach ($statements as $stmt) {
                    if (!empty($stmt) && stripos($stmt, 'USE ') === false) {
                        $db->exec($stmt);
                    }
                }
            }
        } else {
            // SQLite: original behavior
            $schema = file_get_contents(BASE_PATH . '/database/schema.sql');
            $db->exec($schema);

            $count = $db->query("SELECT COUNT(*) FROM categorie")->fetchColumn();
            if ((int)$count === 0) {
                $seed = file_get_contents(BASE_PATH . '/database/seed.sql');
                $db->exec($seed);
            }
        }
    }
}
