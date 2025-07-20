<?php

namespace App\Core;

use PDO;
use Dotenv\Dotenv;

class App
{
    private array $dependencies = [];

    public function __construct()
    {
        $this->dependencies['dotenv'] = Dotenv::createImmutable(__DIR__ . '/../');
        $this->dependencies['dotenv']->load();

        $this->dependencies['pdo'] = new PDO(
            $_ENV['DSN'],
            $_ENV['DB_USER'],
            $_ENV['DB_PASS']
        );
        $this->dependencies['pdo']->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function getDependency(string $key)
    {
        return $this->dependencies[$key] ?? null;
    }
}