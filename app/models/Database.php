<?php

class Database {
    private static ?PDO $instance = null;

    public static function get(): PDO {
        if (self::$instance === null) {
            $dir = dirname(DB_PATH);
            if (!is_dir($dir)) mkdir($dir, 0777, true);
            
            self::$instance = new PDO('sqlite:' . DB_PATH, null, null, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ]);
            self::$instance->exec('PRAGMA journal_mode=WAL');
            self::$instance->exec('PRAGMA foreign_keys=ON');
        }
        return self::$instance;
    }

    public static function init(): void {
        $db = self::get();
        $schema = file_get_contents(BASE_PATH . '/database/schema.sql');
        $db->exec($schema);

        // Seed if empty
        $count = $db->query("SELECT COUNT(*) FROM categorie")->fetchColumn();
        if ((int)$count === 0) {
            $seed = file_get_contents(BASE_PATH . '/database/seed.sql');
            $db->exec($seed);
        }
    }
}
