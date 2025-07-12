<?php

use App\core\AbstractEntity;

class User extends AbstractEntity
{
    private ?string $nom = null;
    private ?string $prenom = null;
    private ?string $telephone = null;
    private ?string $password = null;
    private ?string $adresse = null;
    private ?string $numero_identite = null;
    private ?string $photo_recto = null;
    private ?string $photo_verso = null;
    private string $profil = 'Client';

    public static function toObject(array $data): static
    {
        $user = new static();
        $user->setId($data['id'] ?? null);
        $user->setNom($data['nom'] ?? null);
        $user->setPrenom($data['prenom'] ?? null);
        // Mappe 'login' de la DB à 'telephone' de l'entité
        $user->setTelephone($data['login'] ?? $data['telephone'] ?? null);
        $user->setPassword($data['password'] ?? null);
        $user->setAdresse($data['adresse'] ?? null);
        // Mappe 'numeroidentite' de la DB à 'numero_identite' de l'entité
        $user->setNumeroIdentite($data['numeroidentite'] ?? $data['numero_identite'] ?? null);
        $user->setPhotoRecto($data['photo_recto'] ?? null);
        $user->setPhotoVerso($data['photo_verso'] ?? null);
        $user->setProfil($data['profil'] ?? 'Client');
        $user->setCreatedAt($data['created_at'] ?? null);
        $user->setUpdatedAt($data['updated_at'] ?? null);
        
        return $user;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'nom' => $this->nom,
            'prenom' => $this->prenom,
            'telephone' => $this->telephone,
            'password' => $this->password,
            'adresse' => $this->adresse,
            'numero_identite' => $this->numero_identite,
            'photo_recto' => $this->photo_recto,
            'photo_verso' => $this->photo_verso,
            'profil' => $this->profil,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }

    // Getters et Setters
    public function getNom(): ?string { return $this->nom; }
    public function setNom(?string $nom): void { $this->nom = $nom; }
    
    public function getPrenom(): ?string { return $this->prenom; }
    public function setPrenom(?string $prenom): void { $this->prenom = $prenom; }
    
    public function getTelephone(): ?string { return $this->telephone; }
    public function setTelephone(?string $telephone): void { $this->telephone = $telephone; }
    
    public function getPassword(): ?string { return $this->password; }
    public function setPassword(?string $password): void { $this->password = $password; }
    
    public function getAdresse(): ?string { return $this->adresse; }
    public function setAdresse(?string $adresse): void { $this->adresse = $adresse; }
    
    public function getNumeroIdentite(): ?string { return $this->numero_identite; }
    public function setNumeroIdentite(?string $numero_identite): void { $this->numero_identite = $numero_identite; }
    
    public function getPhotoRecto(): ?string { return $this->photo_recto; }
    public function setPhotoRecto(?string $photo_recto): void { $this->photo_recto = $photo_recto; }
    
    public function getPhotoVerso(): ?string { return $this->photo_verso; }
    public function setPhotoVerso(?string $photo_verso): void { $this->photo_verso = $photo_verso; }
    
    public function getProfil(): string { return $this->profil; }
    public function setProfil(string $profil): void { $this->profil = $profil; }

    public function getFullName(): string
    {
        return trim($this->prenom . ' ' . $this->nom);
    }

    public function verifyPassword(string $password): bool
    {
        return password_verify($password, $this->password);
    }

    public function hashPassword(string $password): void
    {
        $this->password = password_hash($password, PASSWORD_DEFAULT);
    }
}
