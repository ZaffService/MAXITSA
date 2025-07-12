<?php

namespace App\core;

abstract class AbstractEntity
{
    /**
     * Identifiant unique de l'entité
     * @var int|null
     */
    protected ?int $id = null;

    /**
     * Date de création
     * @var string|null
     */
    protected ?string $created_at = null;

    /**
     * Date de mise à jour
     * @var string|null
     */
    protected ?string $updated_at = null;

    /**
     * Convertit un tableau en objet
     * @param array $data
     * @return static
     */
    abstract public static function toObject(array $data): static;

    /**
     * Convertit l'objet en tableau
     * @return array
     */
    abstract public function toArray(): array;

    /**
     * Convertit l'objet en JSON
     * @return string
     */
    public function toJson(): string
    {
        return json_encode($this->toArray(), JSON_PRETTY_PRINT);
    }

    /**
     * Récupère l'ID
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Définit l'ID
     * @param int|null $id
     */
    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    /**
     * Récupère la date de création
     * @return string|null
     */
    public function getCreatedAt(): ?string
    {
        return $this->created_at;
    }

    /**
     * Définit la date de création
     * @param string|null $created_at
     */
    public function setCreatedAt(?string $created_at): void
    {
        $this->created_at = $created_at;
    }

    /**
     * Récupère la date de mise à jour
     * @return string|null
     */
    public function getUpdatedAt(): ?string
    {
        return $this->updated_at;
    }

    /**
     * Définit la date de mise à jour
     * @param string|null $updated_at
     */
    public function setUpdatedAt(?string $updated_at): void
    {
        $this->updated_at = $updated_at;
    }
}
