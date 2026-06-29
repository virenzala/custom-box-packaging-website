<?php

// Check if running in a serverless environment (Vercel)
$isVercel = getenv('VERCEL') ?: ($_ENV['VERCEL'] ?? null);

if ($isVercel) {
    $dbDir = '/tmp';
    $dbPath = $dbDir . '/database.sqlite';
    $sourceDb = __DIR__ . '/../database/database.sqlite';

    // Copy the seeded database to the writable /tmp directory if it doesn't exist
    if (!file_exists($dbPath) || filesize($dbPath) === 0) {
        if (file_exists($sourceDb)) {
            copy($sourceDb, $dbPath);
            chmod($dbPath, 0666);
        } else {
            // Create a blank sqlite database if source is missing
            touch($dbPath);
            chmod($dbPath, 0666);
        }
    }
}

// Forward the request to the main public index.php
require __DIR__ . '/../public/index.php';
