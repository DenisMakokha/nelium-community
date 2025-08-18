<?php

$envFile = '.env';
$envContent = file_get_contents($envFile);

// Update database name
$envContent = preg_replace('/DB_DATABASE=.*/', 'DB_DATABASE=nelium_community', $envContent);

// Update frontend URL
$envContent = preg_replace('/FRONTEND_URL=.*/', 'FRONTEND_URL=http://localhost:3001', $envContent);

// Update app name
$envContent = preg_replace('/APP_NAME=.*/', 'APP_NAME="Nelium Community"', $envContent);

file_put_contents($envFile, $envContent);

echo "✅ .env file updated with correct database configuration\n";
echo "Database: nelium_community\n";
echo "Frontend URL: http://localhost:3001\n";
