<?php

namespace App\Service;
use App\Repository\TransactionRepository;
use App\Service\CompteService;

class TransactionService
{
    private CompteService $compteService;
    private static ?TransactionService $instance = null;
    private TransactionRepository $transactionRepository;

    public static function getInstance(): TransactionService
    {
        if (is_null(self::$instance)) {
            self::$instance = new TransactionService();
        }
        return self::$instance;
    }

    public function __construct() {
        $this->compteService = CompteService::getInstance();
        $this->transactionRepository = TransactionRepository::getInstance();
    }
    
    public function getTransactionForClient(int $compteId): ?array
    {
        return $this->transactionRepository->getTransactionForClient($compteId);
    }

    public function depot(int $compteId, float $montant): bool
    {
        $ok = $this->transactionRepository->depot($compteId, $montant);
        if ($ok) {
            $this->compteService->incrementSolde($compteId, $montant);
        }
        return $ok;
    }
    public function retrait(int $comptePrincipalId, int $compteSecondaireId, float $montant): bool
    {
        $ok = $this->transactionRepository->retrait($comptePrincipalId, $compteSecondaireId, $montant);
        if ($ok) {
            $this->compteService->transfererSolde($comptePrincipalId, $compteSecondaireId, $montant);
        }
        return $ok;
    }
}