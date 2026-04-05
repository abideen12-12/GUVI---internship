<?php
require __DIR__ . '/../vendor/autoload.php';

// Only load .env if it exists (useful for local dev)
// In production, variables are usually injected directly into $_ENV
if (file_exists(__DIR__ . '/../.env')) {
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
    $dotenv->load();
}

/** * MongoDB Configuration
 * Note: Changed from MONGO_URI to MONGO_URL to match your screenshot
 */
define("MONGO_URI", $_ENV['MONGO_URL'] ?? '');

/**
 * MySQL Configuration
 */
define("DB_HOST", $_ENV['MYSQLHOST'] ?? 'localhost');
define("DB_NAME", $_ENV['MYSQLDATABASE'] ?? '');
define("DB_USER", $_ENV['MYSQLUSER'] ?? 'root'); // Note: Add MYSQLUSER to your dashboard if missing
define("DB_PASS", $_ENV['MYSQLPASSWORD'] ?? '');
define("DB_PORT", $_ENV['MYSQLPORT'] ?? '3306');

/**
 * Redis Configuration
 */
define("REDIS_HOST", $_ENV['REDISHOST'] ?? '127.0.0.1');
define("REDIS_PASS", $_ENV['REDISPASSWORD'] ?? null);
define("REDIS_PORT", $_ENV['REDISPORT'] ?? 6379);
