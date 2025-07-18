<?php

namespace App\Repository;
use App\Core\abstract\AbstractRepository;



class TransactionRepository extends AbstractRepository 
{
    private static ?TransactionRepository $instance = null;
    public static function getInstance(): TransactionRepository{
        if (is_null(self::$instance)){
            self::$instance = new TransactionRepository();
        }
        return self::$instance;
    }
    private function __construct()
    {
        parent::__construct();
    }
    public function getTransactionForClient(int $compteId) :?array
    {
        $query = "SELECT * FROM transaction WHERE compte_id = :compteId LIMIT 10";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':compteId', $compteId);
        $stmt->execute();
        
        $array = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        
        if (empty($array)) {
            return null;
        }
        $transactions = [];
        foreach ($array as $data) {
            $transactions[] = [
                'id' => $data['id'],
                'montant' => $data['montant'],
                'type' => $data['type'],
                'date' => $data['date'],
                'compte_id' => $data['compte_id'],
            ]; 
        }
        return $transactions;
        
    }

}