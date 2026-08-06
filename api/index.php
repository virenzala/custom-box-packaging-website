<?php

// Check if running in a serverless environment (Vercel)
$isVercel = getenv('VERCEL') ?: ($_ENV['VERCEL'] ?? null);

if ($isVercel) {
    $dbDir = '/tmp';
    $dbPath = $dbDir . '/database.sqlite';
    $sourceDb = __DIR__ . '/../database/database.sqlite';

    // Copy the seeded database to the writable /tmp directory if missing or 0 bytes
    if (!file_exists($dbPath) || filesize($dbPath) === 0) {
        if (file_exists($sourceDb) && filesize($sourceDb) > 0) {
            copy($sourceDb, $dbPath);
            chmod($dbPath, 0666);
        } else {
            touch($dbPath);
            chmod($dbPath, 0666);
        }
    }

    // Ensure database connection variables point to writable /tmp SQLite database
    putenv('DB_CONNECTION=sqlite');
    $_ENV['DB_CONNECTION'] = 'sqlite';
    $_SERVER['DB_CONNECTION'] = 'sqlite';
    putenv('DB_DATABASE=' . $dbPath);
    $_ENV['DB_DATABASE'] = $dbPath;
    $_SERVER['DB_DATABASE'] = $dbPath;
}

// Forward the request to the main public index.php
require __DIR__ . '/../public/index.php';
