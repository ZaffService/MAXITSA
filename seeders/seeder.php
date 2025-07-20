<?php

require __DIR__ . '/../vendor/autoload.php';
use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

$pdo = new PDO($_ENV['DSN'], $_ENV['DB_USER'], $_ENV['DB_PASS']);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$pdo->exec("INSERT INTO profil (libelle) VALUES ('Client'), ('Service Client')");

$pdo->exec("
    INSERT INTO users (nom, prenom, login, password, photorecto, photoverso, numeroidentite, profil_id)
    VALUES 
    ('Seck', 'Moustapha', '784441909', 'passer', '', '', '1000000000001', 1),
    ('Fall', 'Aminata', '7811223344', 'pass456', '', '', '1000000000002', 1),
    ('Test', 'User', '770000000', 'password', '', '', '1000000000003', 1)
");

$pdo->exec("
    INSERT INTO compte (solde, telephone, type, client_id)
    VALUES 
    (100000, '784441909', 'principal', 1),
    (50000, '784441910', 'secondaire', 1),
    (75000, '7811223344', 'principal', 2),
    (20000, '770000000', 'principal', 3),
    (0, '771111111', 'secondaire', 1)
");

$pdo->exec("
    INSERT INTO transaction (montant, date, type, compte_id)
    VALUES 
    (2000, NOW(), 'depot', 1),
    (1500, NOW(), 'retrait', 1),
    (5000, NOW(), 'depot', 3),
    (10000, NOW(), 'retrait', 1),
    (10000, NOW(), 'depot', 2)
");

echo "Seed terminé.\n";