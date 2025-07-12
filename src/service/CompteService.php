<?php

class CompteService
{
    private CompteRepository $compteRepository;

    public function __construct(CompteRepository $compteRepository)
    {
        $this->compteRepository = $compteRepository;
    }

    public function createPrincipalAccount(int $userId): ?Compte
    {
        $compte = new Compte();
        $compte->setUserId($userId);
        $compte->setTypeCompte('principal');
        $compte->setSolde(0.0);
        $compte->generateNumeroCompte();

        $data = [
            'userid' => $compte->getUserId(),
            'type_compte' => $compte->getTypeCompte(),
            'solde' => $compte->getSolde(),
            'numero_compte' => $compte->getNumeroCompte()
        ];

        $compteId = $this->compteRepository->save($data);
        
        if ($compteId) {
            return $this->compteRepository->findById($compteId);
        }

        return null;
    }

    public function getPrincipalAccount(int $userId): ?Compte
    {
        return $this->compteRepository->findPrincipalByUserId($userId);
    }

    public function getAccountsByUserId(int $userId): array
    {
        return $this->compteRepository->findByUserId($userId);
    }
}
