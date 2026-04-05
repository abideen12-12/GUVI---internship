<?php
require __DIR__ . '/../vendor/autoload.php';

if (file_exists(__DIR__ . '/../.env')) {
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
    $dotenv->load();
}

// MongoDB URI
define("MONGO_URI", $_ENV['MONGO_URL'] ?? 'mongodb://localhost:27017');

// MySQL Config
define("DB_HOST", $_ENV['MYSQLHOST'] ?? 'localhost');
define("DB_USER", $_ENV['MYSQLUSER'] ?? 'root');
define("DB_PASS", $_ENV['MYSQLPASSWORD'] ?? '');
define("DB_NAME", $_ENV['MYSQLDATABASE'] ?? 'user_auth');
define("DB_PORT", $_ENV['MYSQLPORT'] ?? 3306);

// Redis Config
define("REDIS_URL", $_ENV['REDIS_URL'] ?? 'tcp://127.0.0.1:6379');
