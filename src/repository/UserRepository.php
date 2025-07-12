<?php

class UserRepository extends AbstractRepository
{
    protected string $table = 'users';
    
    public function findByTelephone(string $telephone): ?User
    {
        $data = $this->findByField('login', $telephone);
        return $data ? User::toObject($data) : null;
    }
    
    public function telephoneExists(string $telephone): bool
    {
        return $this->countByField('login', $telephone) > 0;
    }
    
    public function findById(int $id): ?User
    {
        $data = $this->findByIdRaw($id);
        return $data ? User::toObject($data) : null;
    }
    
    public function findAll(): array
    {
        $results = parent::findAll();
        return array_map(fn($data) => User::toObject($data), $results);
    }
    
    private function findByField(string $field, $value): ?array
    {
        $sql = "SELECT * FROM {$this->table} WHERE {$field} = :value";
        $stmt = $this->database->getConnection()->prepare($sql);
        $stmt->bindParam(':value', $value);
        $stmt->execute();
        
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }
    
    private function countByField(string $field, $value): int
    {
        $sql = "SELECT COUNT(*) FROM {$this->table} WHERE {$field} = :value";
        $stmt = $this->database->getConnection()->prepare($sql);
        $stmt->bindParam(':value', $value);
        $stmt->execute();
        
        return $stmt->fetchColumn();
    }
}
