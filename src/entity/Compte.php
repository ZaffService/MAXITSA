<?php

use App\core\AbstractEntity;

class Compte extends AbstractEntity
{
    private float $solde = 0.0;
    private ?int $user_id = null;
    private string $type_compte = 'principal';
    private ?string $numero_compte = null;

    public static function toObject(array $data): static
    {
        $compte = new static();
        $compte->setId($data['id'] ?? null);
        $compte->setSolde((float)($data['solde'] ?? 0));
        $compte->setUserId($data['userid'] ?? $data['user_id'] ?? null);
        $compte->setTypeCompte($data['type_compte'] ?? 'principal');
        $compte->setNumeroCompte($data['numero_compte'] ?? null);
        $compte->setCreatedAt($data['created_at'] ?? null);
        $compte->setUpdatedAt($data['updated_at'] ?? null);
        
        return $compte;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'solde' => $this->solde,
            'user_id' => $this->user_id,
            'type_compte' => $this->type_compte,
            'numero_compte' => $this->numero_compte,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }

    // Getters et Setters
    public function getSolde(): float { return $this->solde; }
    public function setSolde(float $solde): void { $this->solde = $solde; }
    
    public function getUserId(): ?int { return $this->user_id; }
    public function setUserId(?int $user_id): void { $this->user_id = $user_id; }
    
    public function getTypeCompte(): string { return $this->type_compte; }
    public function setTypeCompte(string $type_compte): void { $this->type_compte = $type_compte; }
    
    public function getNumeroCompte(): ?string { return $this->numero_compte; }
    public function setNumeroCompte(?string $numero_compte): void { $this->numero_compte = $numero_compte; }

    public function isPrincipal(): bool
    {
        return $this->type_compte === 'principal';
    }

    public function isSecondaire(): bool
    {
        return $this->type_compte === 'secondaire';
    }

    public function generateNumeroCompte(): void
    {
        $this->numero_compte = 'MAXIT' . str_pad(rand(0, 999999999), 9, '0', STR_PAD_LEFT);
    }

    public function getFormattedSolde(): string
    {
        return number_format($this->solde, 0, ',', ' ') . ' CFA';
    }
}
