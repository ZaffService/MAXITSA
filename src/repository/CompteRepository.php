<?php

namespace App\Repository;

use App\Core\abstract\AbstractRepository;
use App\Entity\CompteEntity; 

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

     public function getAccountsByClientId(int $clientId): ?array
    {
        $query = "SELECT * FROM compte WHERE client_id = :clientId";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':clientId', $clientId, \PDO::PARAM_INT);
        $stmt->execute();

        $accountsData = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        if ($accountsData) {
            $accounts = [];
            foreach ($accountsData as $accountData) {
                $accounts[] = CompteEntity::toObject($accountData);
            }
            return $accounts;
        }
        
        return [];
    }

    public function addSecondaryAccount(int $clientId, string $telephone, float $solde): bool
    {
        $stmt = $this->pdo->prepare(
            "INSERT INTO compte (solde, telephone, type, client_id) VALUES (:solde, :telephone, 'secondaire', :clientId)"
        );
        return $stmt->execute([
            'solde' => $solde,
            'telephone' => $telephone,
            'clientId' => $clientId
        ]);
    }
    public function getComptePrincipalByClientId(int $clientId): ?array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM compte WHERE client_id = :clientId AND type = 'principal' LIMIT 1");
        $stmt->execute(['clientId' => $clientId]);
        return $stmt->fetch(\PDO::FETCH_ASSOC) ?: null;
    }
    public function incrementSolde(int $compteId, float $montant): bool
    {
        $stmt = $this->pdo->prepare("UPDATE compte SET solde = solde + :montant WHERE id = :compteId");
        return $stmt->execute([
            'montant' => $montant,
            'compteId' => $compteId
        ]);
    }
    public function transfererSolde(int $comptePrincipalId, int $compteSecondaireId, float $montant): bool
    {
        $this->pdo->beginTransaction();
        try {
            $stmt1 = $this->pdo->prepare(
                "UPDATE compte SET solde = solde - :montant WHERE id = :id"
            );
            $stmt1->execute(['montant' => $montant, 'id' => $comptePrincipalId]);

            $stmt2 = $this->pdo->prepare(
                "UPDATE compte SET solde = solde + :montant WHERE id = :id"
            );
            $stmt2->execute(['montant' => $montant, 'id' => $compteSecondaireId]);

            $this->pdo->commit();
            return true;
        } catch (\Exception $e) {
            $this->pdo->rollBack();
            return false;
        }
    }
    public function getComptesSecondairesByClientId(int $clientId): array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM compte WHERE client_id = :clientId AND type = 'secondaire'");
        $stmt->execute(['clientId' => $clientId]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}