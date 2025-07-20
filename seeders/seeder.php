<?php

require __DIR__ . '/../vendor/autoload.php';
use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

$pdo = new PDO($_ENV['DSN'], $_ENV['DB_USER'], $_ENV['DB_PASS']);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Ajout de profils
$pdo->exec("INSERT INTO profil (libelle) VALUES ('Client'), ('Service Client')");

// Ajout d'utilisateurs
$pdo->exec("
    INSERT INTO users (nom, prenom, login, password, photorecto, photoverso, numeroidentite, profil_id)
    VALUES 
    ('Seck', 'Moustapha', '784441909', 'passer', '', '', '1000000000001', 1),
    ('Fall', 'Aminata', '7811223344', 'pass456', '', '', '1000000000002', 1)
");

// Ajout de comptes (le premier compte est principal, les autres secondaires)
$pdo->exec("
    INSERT INTO compte (solde, telephone, type, client_id)
    VALUES 
    (100000, '784441909', 'principal', 1),
    (50000, '784441909', 'secondaire', 1),
    (75000, '7811223344', 'principal', 2)
");

// Ajout de transactions
$pdo->exec("
    INSERT INTO transaction (montant, date, type, compte_id)
    VALUES 
    (2000, NOW(), 'depot', 1),
    (1500, NOW(), 'paiement', 2),
    (5000, NOW(), 'depot', 3)
");

echo "Seed terminé.\n";