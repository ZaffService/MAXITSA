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

}

 