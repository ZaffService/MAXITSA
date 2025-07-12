<?php

use App\core\AbstractEntity;

class Transaction extends AbstractEntity
{
    private float $montant = 0.0;
    private string $type_transaction = 'Depot';
    private ?int $compte_id = null;
    private ?string $description = null;
    private ?string $numero_compte = null;
    private ?string $nom_client = null;

    public static function toObject(array $data): static
    {
        $transaction = new static();
        $transaction->setId($data['id'] ?? null);
        $transaction->setMontant((float)($data['montant'] ?? 0));
        $transaction->setTypeTransaction($data['type_transaction'] ?? 'Depot');
        $transaction->setCompteId($data['compte_id'] ?? null);
        $transaction->setDescription($data['description'] ?? null);
        $transaction->setNumeroCompte($data['numero_compte'] ?? null);
        $transaction->setNomClient(($data['prenom'] ?? '') . ' ' . ($data['nom'] ?? ''));
        $transaction->setCreatedAt($data['created_at'] ?? null);
        $transaction->setUpdatedAt($data['updated_at'] ?? null);
        
        return $transaction;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'montant' => $this->montant,
            'type_transaction' => $this->type_transaction,
            'compte_id' => $this->compte_id,
            'description' => $this->description,
            'numero_compte' => $this->numero_compte,
            'nom_client' => $this->nom_client,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }

    // Getters et Setters
    public function getMontant(): float { return $this->montant; }
    public function setMontant(float $montant): void { $this->montant = $montant; }
    
    public function getTypeTransaction(): string { return $this->type_transaction; }
    public function setTypeTransaction(string $type_transaction): void { $this->type_transaction = $type_transaction; }
    
    public function getCompteId(): ?int { return $this->compte_id; }
    public function setCompteId(?int $compte_id): void { $this->compte_id = $compte_id; }
    
    public function getDescription(): ?string { return $this->description; }
    public function setDescription(?string $description): void { $this->description = $description; }
    
    public function getNumeroCompte(): ?string { return $this->numero_compte; }
    public function setNumeroCompte(?string $numero_compte): void { $this->numero_compte = $numero_compte; }
    
    public function getNomClient(): ?string { return $this->nom_client; }
    public function setNomClient(?string $nom_client): void { $this->nom_client = $nom_client; }

    public function getFormattedMontant(): string
    {
        $sign = $this->type_transaction === 'Retrait' ? '-' : '+';
        return $sign . number_format($this->montant, 0, ',', ' ') . ' CFA';
    }

    public function getColorClass(): string
    {
        return match($this->type_transaction) {
            'Depot' => 'text-green-600',
            'Retrait' => 'text-red-600',
            'Paiement' => 'text-orange-600',
            default => 'text-gray-600'
        };
    }

    public function getFormattedDate(): string
    {
        if ($this->created_at) {
            return date('d/m/Y', strtotime($this->created_at));
        }
        return '';
    }
}
