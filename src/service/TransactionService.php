<?php
/**
 * Service pour la gestion des transactions
 */
class TransactionService
{
    private TransactionRepository $transactionRepository;
    private CompteRepository $compteRepository;
    private Database $database; // Ajout de la dépendance Database

    public function __construct(TransactionRepository $transactionRepository, CompteRepository $compteRepository, Database $database)
    {
        $this->transactionRepository = $transactionRepository;
        $this->compteRepository = $compteRepository;
        $this->database = $database; // Initialisation de la dépendance Database
    }

    /**
     * Récupère les dernières transactions d'un utilisateur
     * @param int $userId
     * @param int $limit
     * @return array
     */
    public function getLastTransactionsByUserId(int $userId, int $limit = 10): array
    {
        return $this->transactionRepository->findByUserId($userId, $limit);
    }

    public function getLastTransactionsByCompteId(int $compteId, int $limit = 10): array
    {
        return $this->transactionRepository->findByCompteId($compteId, $limit);
    }

    /**
     * Crée une transaction de dépôt et met à jour le solde du compte.
     * @param int $compteId
     * @param float $montant
     * @param string|null $description
     * @return Transaction|null
     * @throws Exception
     */
    public function createDeposit(int $compteId, float $montant, ?string $description = null): ?Transaction
    {
        if ($montant <= 0) {
            throw new Exception(MessageEnum::ERROR_INVALID_AMOUNT);
        }

        // Utilise l'instance de Database pour gérer la transaction
        $this->database->getConnection()->beginTransaction();

        try {
            // 1. Mettre à jour le solde du compte
            $compte = $this->compteRepository->findByIdRaw($compteId);
            if (!$compte) {
                throw new Exception(MessageEnum::ERROR_ACCOUNT_NOT_FOUND);
            }
            $nouveauSolde = $compte['solde'] + $montant;
            $this->compteRepository->updateCompte($compteId, ['solde' => $nouveauSolde]);

            // 2. Enregistrer la transaction
            $transactionData = [
                'compte_id' => $compteId,
                'montant' => $montant,
                'type_transaction' => 'Depot',
                'description' => $description ?? 'Dépôt d\'argent'
            ];
            $transactionId = $this->transactionRepository->save($transactionData);

            if (!$transactionId) {
                throw new Exception(MessageEnum::ERROR_TRANSACTION_SAVE_FAILED);
            }

            $this->database->getConnection()->commit(); // Valide la transaction DB
            return $this->transactionRepository->findById($transactionId); // Corrected: returns a Transaction object
        } catch (Exception $e) {
            $this->database->getConnection()->rollBack(); // Annule la transaction DB en cas d'erreur
            throw $e; // Relance l'exception pour être gérée par le contrôleur
        }
    }
}
