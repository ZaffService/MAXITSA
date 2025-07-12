<?php
/**
 * Initialisation de l'application
 */

// Charger l'autoloader Composer
require_once __DIR__ . '/../../vendor/autoload.php';

// Charger la configuration
require_once __DIR__ . '/env.php';
require_once __DIR__ . '/helpers.php';

// Configuration des erreurs
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Démarrer la session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
