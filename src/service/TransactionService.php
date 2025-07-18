<?php

namespace App\Service;
use App\Repository\TransactionRepository;

class TransactionService
{
    private static ?TransactionService $instance = null;

    public static function getInstance(): TransactionService
    {
        if (is_null(self::$instance)) {
            self::$instance = new TransactionService();
        }
        return self::$instance;
    }

    private function __construct()
    {
        $this->transactionRepository = TransactionRepository::getInstance();
      
    }
    
    public function getTransactionForClient(int $compteId): ?array
    {
        return $this->transactionRepository->getTransactionForClient($compteId);
    }

    
}