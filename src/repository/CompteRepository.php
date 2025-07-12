<?php

class CompteRepository extends AbstractRepository
{
  protected string $table = 'comptes';
  
  public function findByUserId(int $userId): array
  {
      $results = $this->findAllByField('userid', $userId);
      return array_map(fn($data) => Compte::toObject($data), $results);
  }
  
  public function findPrincipalByUserId(int $userId): ?Compte
  {
      $sql = "SELECT * FROM {$this->table} WHERE userid = :user_id ORDER BY id ASC LIMIT 1";
      $stmt = $this->database->getConnection()->prepare($sql);
      $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
      $stmt->execute();
      
      $result = $stmt->fetch(PDO::FETCH_ASSOC);
      return $result ? Compte::toObject($result) : null;
  }
  
  public function findById(int $id): ?Compte
  {
      $data = $this->findByIdRaw($id);
      return $data ? Compte::toObject($data) : null;
  }

  /**
   * Met à jour un enregistrement de compte.
   * Rend la méthode update du parent accessible publiquement pour les comptes.
   * @param int $id
   * @param array $data
   * @return int|null
   */
  public function updateCompte(int $id, array $data): ?int
  {
      return parent::update($id, $data);
  }
  
  private function findAllByField(string $field, $value): array
  {
      $sql = "SELECT * FROM {$this->table} WHERE {$field} = :value ORDER BY id DESC";
      $stmt = $this->database->getConnection()->prepare($sql);
      $stmt->bindParam(':value', $value);
      $stmt->execute();
      
      return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }
}
