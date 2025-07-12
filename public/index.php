<?php

// Point d'entrée unique de l'application
require_once __DIR__ . '/../app/config/bootstrap.php';

// Chargement de l'autoloader Composer
require_once __DIR__ . '/../vendor/autoload.php';

// Chargement des variables d'environnement si fichier .env existe
if (file_exists(__DIR__ . '/../.env')) {
    $lines = file(__DIR__ . '/../.env', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (strpos($line, '=') !== false && !str_starts_with($line, '#')) {
            putenv($line);
        }
    }
}

// Configuration des erreurs selon l'environnement
if (!APP_DEBUG) {
    error_reporting(0);
    ini_set('display_errors', 0);
}

// Démarrage de l'application
App::run();
