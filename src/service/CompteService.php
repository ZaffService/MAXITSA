<?php

namespace App\Service;

use App\Repository\CompteRepository;

class CompteService {

    private CompteRepository $compteRepository;
    private static ?CompteService $instance = null;

    public static function getInstance(): CompteService {
        if (is_null(self::$instance)) {
            self::$instance = new CompteService();
        }
        return self::$instance;
    }

    private function __construct() {
        $this->compteRepository = CompteRepository::getInstance();
    }

    public function getSoldeByClientId(int $clientId): ?float {
        return $this->compteRepository->getSoldeByClientId($clientId);
    }

    public function getCompteByClientId(int $clientId): ?array {
        return $this->compteRepository->getCompteByClientId($clientId);
    }

    public function getClientAccounts(int $clientId): array
    {
        return $this->compteRepository->getAccountsByClientId($clientId) ?? [];
    }

    public function addSecondaryAccount(int $clientId, string $telephone, float $solde): bool
    {
        return $this->compteRepository->addSecondaryAccount($clientId, $telephone, $solde);
    }

    public function getComptePrincipalByClientId(int $clientId): ?array
    {
        return $this->compteRepository->getComptePrincipalByClientId($clientId);
    }

    public function incrementSolde(int $compteId, float $montant): bool
    {
        return $this->compteRepository->incrementSolde($compteId, $montant);
    }

    public function transfererSolde(int $comptePrincipalId, int $compteSecondaireId, float $montant): bool
    {
        return $this->compteRepository->transfererSolde($comptePrincipalId, $compteSecondaireId, $montant);
    }

    public function getComptesSecondairesByClientId(int $clientId): array
    {
        return $this->compteRepository->getComptesSecondairesByClientId($clientId) ?? [];
    }

}

