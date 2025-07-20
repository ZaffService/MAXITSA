<?php

require __DIR__ . '/../vendor/autoload.php';
use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

$pdo = new PDO($_ENV['DSN'], $_ENV['DB_USER'], $_ENV['DB_PASS']);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

echo "Suppression des tables existantes...\n";

$pdo->exec("DROP TABLE IF EXISTS transaction CASCADE;");
$pdo->exec("DROP TABLE IF EXISTS compte CASCADE;");
$pdo->exec("DROP TABLE IF EXISTS users CASCADE;");
$pdo->exec("DROP TABLE IF EXISTS profil CASCADE;");

echo "Tables supprimées.\n";
echo "Création des nouvelles tables...\n";

// Table profil
$pdo->exec("
    CREATE TABLE profil (
        id SERIAL PRIMARY KEY,
        libelle VARCHAR(50) NOT NULL
    );
");

// Table users
$pdo->exec("
    CREATE TABLE users (
        id SERIAL PRIMARY KEY,
        nom VARCHAR(100) NOT NULL,
        prenom VARCHAR(100) NOT NULL,
        login VARCHAR(100) NOT NULL,
        password VARCHAR(255) NOT NULL,
        photorecto VARCHAR(255),
        photoverso VARCHAR(255),
        numeroidentite VARCHAR(20),
        profil_id INT,
        FOREIGN KEY (profil_id) REFERENCES profil(id)
    );
");

// Table compte
$pdo->exec("
    CREATE TABLE compte (
        id SERIAL PRIMARY KEY,
        solde NUMERIC(15,2) NOT NULL DEFAULT 0,
        telephone VARCHAR(20) NOT NULL,
        type VARCHAR(50) NOT NULL, -- 'principal' ou 'secondaire'
        client_id INT NOT NULL,
        FOREIGN KEY (client_id) REFERENCES users(id)
    );
");

// Table transaction
$pdo->exec("
    CREATE TABLE transaction (
        id SERIAL PRIMARY KEY,
        montant NUMERIC(15,2) NOT NULL,
        date TIMESTAMP NOT NULL DEFAULT NOW(),
        type VARCHAR(50) NOT NULL, -- 'depot' ou 'retrait'
        compte_id INT NOT NULL,
        FOREIGN KEY (compte_id) REFERENCES compte(id)
    );
");

echo "Migration terminée avec succès.\n";