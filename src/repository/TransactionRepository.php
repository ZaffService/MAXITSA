<?php

class TransactionRepository extends AbstractRepository
{
    protected string $table = 'transactions';
    
    public function findByUserId(int $userId, int $limit = 10): array
    {
        $sql = "SELECT t.*, c.numero_compte, u.nom, u.prenom 
                FROM {$this->table} t
                JOIN comptes c ON t.compte_id = c.id
                JOIN users u ON c.userid = u.id
                WHERE u.id = :user_id 
                ORDER BY t.created_at DESC 
                LIMIT :limit";
        
        $stmt = $this->database->getConnection()->prepare($sql);
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return array_map(fn($data) => Transaction::toObject($data), $results);
    }
    
    public function findByCompteId(int $compteId, int $limit = 10): array
    {
        $results = $this->findAllByField('compte_id', $compteId, $limit);
        return array_map(fn($data) => Transaction::toObject($data), $results);
    }

    /**
     * Trouve une transaction par ID et la retourne sous forme d'objet Transaction.
     * @param int $id
     * @return Transaction|null
     */
    public function findById(int $id): ?Transaction
    {
        $data = $this->findByIdRaw($id);
        return $data ? Transaction::toObject($data) : null;
    }
    
    // Correction ici : ?int $limit = null
    private function findAllByField(string $field, $value, ?int $limit = null): array
    {
        $sql = "SELECT * FROM {$this->table} WHERE {$field} = :value ORDER BY created_at DESC";
        if ($limit !== null) { // Utiliser !== null pour vérifier explicitement si la limite est définie
            $sql .= " LIMIT :limit";
        }
        
        $stmt = $this->database->getConnection()->prepare($sql);
        $stmt->bindParam(':value', $value);
        if ($limit !== null) {
            $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        }
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
