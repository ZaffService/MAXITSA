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
    public function getTransactionForClient(int $compteId): ?array
    {
        $stmt = $this->pdo->prepare(
            "SELECT * FROM transaction WHERE compte_id = :compteId ORDER BY date DESC LIMIT 10"
        );
        $stmt->execute(['compteId' => $compteId]);
        $array = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        if (!$array) {
            return null;
        }

        $transactions = [];
        foreach ($array as $data) {
            $transactions[] = [
                'type' => $data['type'],
                'montant' => $data['montant'],
                'date' => $data['date'],
                'compte_id' => $data['compte_id'],
            ];
        }
        return $transactions;
    }
    public function depot(int $compteId, float $montant): bool
    {
        $stmt = $this->pdo->prepare(
            "INSERT INTO transaction (montant, date, type, compte_id) VALUES (:montant, NOW(), 'depot', :compteId)"
        );
        return $stmt->execute([
            'montant' => $montant,
            'compteId' => $compteId
        ]);
    }
    public function retrait(int $comptePrincipalId, int $compteSecondaireId, float $montant): bool
    {
        $this->pdo->beginTransaction();
        try {
            $stmt1 = $this->pdo->prepare(
                "INSERT INTO transaction (montant, date, type, compte_id) VALUES (:montant, NOW(), 'retrait', :compteId)"
            );
            $stmt1->execute([
                'montant' => $montant,
                'compteId' => $comptePrincipalId
            ]);

            $stmt2 = $this->pdo->prepare(
                "INSERT INTO transaction (montant, date, type, compte_id) VALUES (:montant, NOW(), 'depot', :compteId)"
            );
            $stmt2->execute([
                'montant' => $montant,
                'compteId' => $compteSecondaireId
            ]);

            $this->pdo->commit();
            return true;
        } catch (\Exception $e) {
            $this->pdo->rollBack();
            return false;
        }
    }

}