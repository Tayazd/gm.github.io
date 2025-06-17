<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// 1. Сначала устанавливаем ВСЕ настройки сессии
ini_set('session.cookie_httponly', 1);
ini_set('session.use_strict_mode', 1);
ini_set('session.cookie_secure', 0); // 1 если используете HTTPS
ini_set('session.gc_maxlifetime', 14400); // 4 часа

// 2. Только потом запускаем сессию
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 3. Настройки БД (после сессии)
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '1234');
define('DB_NAME', 'auth_system');

try {
    $pdo = new PDO(
        "mysql:host=".DB_HOST.";dbname=".DB_NAME.";charset=utf8mb4",
        DB_USER,
        DB_PASS,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false
        ]
    );
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>