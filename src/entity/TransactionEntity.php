<?php

namespace App\Entity;

class TransactionEntity extends AbstractEntity
{
    private int $id;
    private float $montant;
    private string $date;
    private string $type; 
    private int $compteId;

    public function __construct(int $id = 0, float $montant = 0.0, string $date = '', string $type = '')
    {
        $this->id = $id;
        $this->montant = $montant;
        $this->date = $date;
        $this->type = $type;
        $this->compteId = $compteId;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getMontant(): float
    {
        return $this->montant;
    }

    public function setMontant(float $montant): void
    {
        $this->montant = $montant;
    }

    public function getDate(): string
    {
        return $this->date;
    }

    public function setDate(string $date): void
    {
        $this->date = $date;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function setType(string $type): void
    {
        $this->type = $type;
    }

    public function getCompteId(): int
    {
        return $this->compteId;
    }

    public function setCompteId(int $compteId): void
    {
        $this->compteId = $compteId;
    }

    public static function toObject(array $data): static 
    {
        return new static(
            $data['id'] ?? 0,
            $data['montant'] ?? '',
            $data['date'] ?? '',
            $data['type'] ?? '',
            $data['compte_id'] ?? 0,
        );
    }

    public  function toArray(object $data): array
    {
        return [
            'id' => $this->getId(),
            'montant' => $this->getMontant(),
            'date' => $this->getDate(),
            'type' => $this->getType(),
            'compte_id' => $this->getCompteId(),
        ];
    }
}