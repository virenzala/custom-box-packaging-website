<?php

// Check if running in a serverless environment (Vercel)
$isVercel = getenv('VERCEL') ?: ($_ENV['VERCEL'] ?? null);

if ($isVercel) {
    $dbDir = '/tmp';
    $dbPath = $dbDir . '/database.sqlite';
    
    // Check multiple potential source locations in Vercel function bundle
    $possibleSources = [
        __DIR__ . '/../database/database.sqlite',
        dirname(__DIR__) . '/database/database.sqlite',
        '/var/task/database/database.sqlite',
    ];

    $sourceDb = null;
    foreach ($possibleSources as $possible) {
        if (file_exists($possible) && filesize($possible) > 0) {
            $sourceDb = $possible;
            break;
        }
    }

    // Always ensure /tmp/database.sqlite has the full seeded data from source
    if ($sourceDb && (!file_exists($dbPath) || filesize($dbPath) < filesize($sourceDb))) {
        copy($sourceDb, $dbPath);
        chmod($dbPath, 0666);
    } elseif (!file_exists($dbPath)) {
        touch($dbPath);
        chmod($dbPath, 0666);
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
