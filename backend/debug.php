<?php
// Crear este archivo como backend/debug.php

echo "=== DEBUG LARAVEL ===\n";

// 1. Verificar si existe .env
echo "1. Checking .env file...\n";
if (file_exists(__DIR__ . '/.env')) {
    echo "   ✓ .env file exists\n";
} else {
    echo "   ✗ .env file missing\n";
    echo "   Creating .env from .env.example...\n";
    if (file_exists(__DIR__ . '/.env.example')) {
        copy(__DIR__ . '/.env.example', __DIR__ . '/.env');
        echo "   ✓ .env created\n";
    } else {
        echo "   ✗ .env.example also missing!\n";
    }
}

// 2. Verificar autoload
echo "2. Checking autoload...\n";
if (file_exists(__DIR__ . '/vendor/autoload.php')) {
    echo "   ✓ Autoload exists\n";
    require_once __DIR__ . '/vendor/autoload.php';
} else {
    echo "   ✗ Autoload missing - run composer install\n";
    exit(1);
}

// 3. Verificar bootstrap
echo "3. Checking bootstrap...\n";
if (file_exists(__DIR__ . '/bootstrap/app.php')) {
    echo "   ✓ Bootstrap exists\n";
} else {
    echo "   ✗ Bootstrap missing\n";
    exit(1);
}

// 4. Intentar cargar la aplicación
echo "4. Attempting to load Laravel app...\n";
try {
    $app = require_once __DIR__ . '/bootstrap/app.php';
    echo "   ✓ App loaded successfully\n";

    // 5. Verificar variables de entorno
    echo "5. Checking environment variables...\n";
    echo "   APP_KEY: " . (env('APP_KEY') ? 'SET' : 'NOT SET') . "\n";
    echo "   APP_ENV: " . (env('APP_ENV', 'NOT SET')) . "\n";
    echo "   DB_CONNECTION: " . (env('DB_CONNECTION', 'NOT SET')) . "\n";

} catch (Exception $e) {
    echo "   ✗ Error loading app: " . $e->getMessage() . "\n";
    echo "   File: " . $e->getFile() . "\n";
    echo "   Line: " . $e->getLine() . "\n";

    // Mostrar el stack trace para más información
    echo "\nStack trace:\n";
    echo $e->getTraceAsString() . "\n";
}

echo "\n=== END DEBUG ===\n";
?>