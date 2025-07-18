<?php

namespace App\Repository;

use App\Core\abstract\AbstractRepository;

class CompteRepository extends AbstractRepository{

    private static ?CompteRepository $instance = null;
    public static function getInstance(): CompteRepository{
        if (is_null(self::$instance)) {
            self::$instance = new CompteRepository();
        }
        return self::$instance;
    }
    private function __construct()
    {
        parent::__construct();
    }
    public function getSoldeByClientId(int $clientId): ?float
    {
        $query = "SELECT solde FROM compte WHERE client_id = :clientId";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':clientId', $clientId);
        $stmt->execute();

        $result = $stmt->fetch(\PDO::FETCH_ASSOC);
        
        if ($result) {
            return (float)$result['solde'];
        }
        
        return null;
    }
    public function getCompteByClientId(int $clientId): ?array
    {
        $query = "SELECT * FROM compte WHERE client_id = :clientId";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':clientId', $clientId);
        $stmt->execute();

        $result = $stmt->fetch(\PDO::FETCH_ASSOC);
        
        if ($result) {
            return $result;
        }
        
        return null;
    }
}