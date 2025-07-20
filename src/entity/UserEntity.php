<?php
namespace App\Entity;

use App\Core\Abstract\AbstractEntity;

class UserEntity extends AbstractEntity {
    private int $id;
    private string $nom;
    private string $prenom;
    private string $login;
    private string $adresse;
    private string $password;
    private array $comptes;
    private string $photoRecto;
    private string $photoVerso;
    private string $numeroIdentite;
    private ProfilEntity $profil;

    public function __construct(
        int $id = 0,
        string $nom = "",
        string $prenom = "",
        string $login = "",
        string $password = "",
        string $photoRecto = "",
        string $photoVerso = "",
        string $numeroIdentite = ""
    ) {
        $this->id = $id;
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->login = $login;
        $this->password = $password;
        $this->comptes = [];
        $this->photoRecto = $photoRecto;
        $this->photoVerso = $photoVerso;
        $this->numeroIdentite = $numeroIdentite;
        $this->profil = new ProfilEntity();
    }


    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getAdresse(): string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): void
    {
        $this->adresse = $adresse;
    }

    public function getNom(): string
    {
        return $this->nom;
    }

    public function setNom(string $nom): void
    {
        $this->nom = $nom;
    }

    public function getPrenom(): string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): void
    {
        $this->prenom = $prenom;
    }

    public function getLogin(): string
    {
        return $this->login;
    }

    public function setLogin(string $login): void
    {
        $this->login = $login;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    public function getComptes(): array
    {
        return $this->comptes;
    }

    public function addCompte(CompteEntity $compte): void
    {
        $this->comptes[] = $compte;
    }

    public function getPhotoRecto(): string
    {
        return $this->photoRecto;
    }

    public function setPhotoRecto(string $photoRecto): void
    {
        $this->photoRecto = $photoRecto;
    }

    public function getPhotoVerso(): string
    {
        return $this->photoVerso;
    }

    public function setPhotoVerso(string $photoVerso): void
    {
        $this->photoVerso = $photoVerso;
    }

    public function getNumeroIdentite(): string
    {
        return $this->numeroIdentite;
    }

    public function setNumeroIdentite(string $numeroIdentite): void
    {
        $this->numeroIdentite = $numeroIdentite;
    }

    public function getProfil(): ProfilEntity
    {
        return $this->profil;
    }

    public function setProfil(ProfilEntity $profil): void
    {
        $this->profil = $profil;
    }

    public static function toObject(array $array): static
    {
        return new static(
            $array['id'] ?? 0,
            $array['nom'] ?? '',
            $array['prenom'] ?? '',
            $array['login'] ?? '',
            $array['password'] ?? '',
            $array['photorecto'] ?? '',
            $array['photoverso'] ?? '',
            $array['numeroidentite'] ?? ''

        );


    }

    public  function toArray(object $data): array
    {
        return [
            'id' => $this->getId(),
            'nom' => $this->getNom(),
            'prenom' => $this->getPrenom(),
            'login' => $this->getLogin(),
            'password' => $this->getPassword(),
            'comptes' => array_map(fn($compte) => $compte->toArray(), $this->getComptes()),
            'photoRecto' => $this->getPhotoRecto(),
            'photoVerso' => $this->getPhotoVerso(),
            'numeroIdentite' => $this->getNumeroIdentite(),
        ];
    }
}