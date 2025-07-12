<?php

abstract class AbstractRepository
{
    protected Database $database;
    protected string $table;

    public function __construct(Database $database)
    {
        $this->database = $database;
    }

    /**
     * Trouve un enregistrement par ID (retourne un array brut)
     * @param int $id
     * @return array|null
     */
    public function findByIdRaw(int $id): ?array
    {
        $sql = "SELECT * FROM {$this->table} WHERE id = :id";
        $stmt = $this->database->getConnection()->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ?: null;
    }

    /**
     * Trouve tous les enregistrements
     * @return array
     */
    public function findAll(): array
    {
        $sql = "SELECT * FROM {$this->table} ORDER BY created_at DESC";
        $stmt = $this->database->getConnection()->prepare($sql);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Sauvegarde un enregistrement
     * @param array $data
     * @return int|null
     */
    public function save(array $data): ?int
    {
        if (isset($data['id']) && $data['id']) {
            return $this->update($data['id'], $data);
        } else {
            return $this->create($data);
        }
    }

    /**
     * Crée un nouvel enregistrement
     * @param array $data
     * @return int|null
     */
    protected function create(array $data): ?int
    {
        unset($data['id']);
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['updated_at'] = date('Y-m-d H:i:s');

        $columns = implode(', ', array_keys($data));
        $placeholders = ':' . implode(', :', array_keys($data));
        
        $sql = "INSERT INTO {$this->table} ({$columns}) VALUES ({$placeholders})";
        $stmt = $this->database->getConnection()->prepare($sql);
        
        foreach ($data as $key => $value) {
            $stmt->bindValue(":$key", $value);
        }
        
        if ($stmt->execute()) {
            return $this->database->getConnection()->lastInsertId();
        }
        
        return null;
    }

    /**
     * Met à jour un enregistrement
     * @param int $id
     * @param array $data
     * @return int|null
     */
    protected function update(int $id, array $data): ?int
    {
        unset($data['id'], $data['created_at']);
        $data['updated_at'] = date('Y-m-d H:i:s');

        $setParts = [];
        foreach (array_keys($data) as $key) {
            $setParts[] = "$key = :$key";
        }
        $setClause = implode(', ', $setParts);
        
        $sql = "UPDATE {$this->table} SET {$setClause} WHERE id = :id";
        $stmt = $this->database->getConnection()->prepare($sql);
        
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        foreach ($data as $key => $value) {
            $stmt->bindValue(":$key", $value);
        }
        
        if ($stmt->execute()) {
            return $id;
        }
        
        return null;
    }

    /**
     * Supprime un enregistrement
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        $sql = "DELETE FROM {$this->table} WHERE id = :id";
        $stmt = $this->database->getConnection()->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        
        return $stmt->execute();
    }
}
