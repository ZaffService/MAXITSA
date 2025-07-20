<?php

namespace App\Repository;

use App\Core\abstract\AbstractRepository;
use App\Entity\UserEntity;

class UserRepository extends AbstractRepository
{

    private static ?UserRepository $instance = null;
    public static function getInstance(): UserRepository
    {
        if (is_null(self::$instance)) {
            self::$instance = new UserRepository();
        }
        return self::$instance;
    }

    private function __construct()
    {
        parent::__construct();
    }

    public function seConnecter(string $login, string $password): ?UserEntity
    {
        $query = "SELECT u.*, c.telephone FROM users u
                  JOIN compte c ON u.id = c.client_id
                  WHERE c.telephone = :login";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':login', $login);
        $stmt->execute();

        $array = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        if (empty($array)) {
            error_log("Aucun utilisateur trouvé pour le login : " . $login);
            return null;
        }
        $userdata = $array[0];

        if (!password_verify($password, $userdata['password'])) {
            error_log("Mot de passe incorrect pour le login : " . $login);
            error_log("Mot de passe saisi : " . $password);
            error_log("Hash en base : " . $userdata['password']);
            return null;
        }

        $user = UserEntity::toObject($userdata);
        return $user ?: null;
    }

    public function create(array $data): bool
    {
        $data['profil_id'] = 1;

        $stmtUser = $this->pdo->prepare(
            "INSERT INTO users (nom, prenom, login, password, photorecto, photoverso, numeroidentite, profil_id, adresse) 
            VALUES (:nom, :prenom, :login, :password, :photorecto, :photoverso, :numeroidentite, :profil_id, :adresse)"
        );
        $successUser = $stmtUser->execute([
            'nom' => $data['nom'],
            'prenom' => $data['prenom'],
            'login' => $data['login'],
            'password' => password_hash($data['password'], PASSWORD_DEFAULT),
            'photorecto' => $data['photorecto'],
            'photoverso' => $data['photoverso'],
            'numeroidentite' => $data['numeroidentite'],
            'adresse' => $data['adresse'],
            'profil_id' => $data['profil_id']
        ]);

        if (!$successUser) {
            return false;
        }

        $userId = $this->pdo->lastInsertId();

        $stmtCompte = $this->pdo->prepare(
            "INSERT INTO compte (solde, telephone, type, client_id) VALUES (:solde, :telephone, :type, :client_id)"
        );
        $successCompte = $stmtCompte->execute([
            'solde' => 0, 
            'telephone' => $data['login'],
            'type' => 'principal', 
            'client_id' => $userId
        ]);

        return $successCompte;
    }
}