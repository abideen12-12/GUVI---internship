<?php
require __DIR__ . '/../vendor/autoload.php';

// Railway doesn't always use .env files, so we check first
if (file_exists(__DIR__ . '/../.env')) {
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
    $dotenv->load();
}

// Use the exact name from your Railway 'Variables' tab
define("MONGO_URI", $_ENV['MONGO_URL'] ?? '');
