<?php

try {
    $pdo = new PDO('mysql:host=127.0.0.1;port=3306', 'root', '');
    $pdo->exec('CREATE DATABASE IF NOT EXISTS nelium_community CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci');
    echo "✅ Database 'nelium_community' created successfully\n";
} catch(Exception $e) {
    echo "❌ Error creating database: " . $e->getMessage() . "\n";
}
