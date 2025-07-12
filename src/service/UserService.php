<?php

class UserService
{
    private UserRepository $userRepository;
    private TwilioService $twilioService;

    public function __construct(UserRepository $userRepository, TwilioService $twilioService)
    {
        $this->userRepository = $userRepository;
        $this->twilioService = $twilioService;
    }

    /**
     * Crée un nouvel utilisateur
     * @param array $data
     * @return User|null
     */
    public function createUser(array $data): ?User
    {
        $originalPhoneNumber = $data['telephone'] ?? null;
        $originalNumeroIdentite = $data['numero_identite'] ?? null;

        // Préparer les données pour la base de données avec les noms de colonnes corrects
        $dbData = [
            'nom' => $data['nom'] ?? null,
            'prenom' => $data['prenom'] ?? null,
            'login' => $originalPhoneNumber, // Mappe 'telephone' à 'login' pour la DB
            'password' => $data['password'] ?? null,
            'adresse' => $data['adresse'] ?? null,
            'numeroidentite' => $originalNumeroIdentite, // Mappe 'numero_identite' à 'numeroidentite' pour la DB
            'photorecto' => $data['photo_recto'] ?? null,
            'photoverso' => $data['photo_verso'] ?? null,
            'profil' => $data['profil'] ?? 'Client'
        ];

        // Filtrer les valeurs nulles si la base de données n'accepte pas les insertions de null pour des colonnes non nullables
        $dbData = array_filter($dbData, fn($value) => $value !== null);

        // --- LIGNE DE DÉBOGAGE AJOUTÉE ICI ---
        error_log("DEBUG: Données envoyées à la base de données: " . print_r($dbData, true));
        // --- FIN DE LA LIGNE DE DÉBOGAGE ---

        $userId = $this->userRepository->save($dbData);

        if ($userId) {
            $user = $this->userRepository->findById($userId);

            // --- Début de l'ajout pour Twilio ---
            if ($user && APP_DEBUG && $originalPhoneNumber) {
                $message = "Bienvenue chez MAXITSA, " . $user->getPrenom() . " ! Votre compte a été créé avec succès.";
                
                error_log("Tentative d'envoi de SMS à: " . $originalPhoneNumber);
                error_log("Message: " . $message);

                try {
                    $smsSent = $this->twilioService->sendSms($originalPhoneNumber, $message);
                    if ($smsSent) {
                        error_log("SMS Twilio envoyé avec succès à " . $originalPhoneNumber);
                    } else {
                        error_log("Échec de l'envoi du SMS Twilio à " . $originalPhoneNumber);
                    }
                } catch (Exception $e) {
                    error_log("Erreur lors de l'envoi du SMS Twilio: " . $e->getMessage());
                }
            }
            // --- Fin de l'ajout pour Twilio ---

            return $user;
        }

        return null;
    }

    /**
     * Authentifie un utilisateur
     * @param string $telephone
     * @param string $password
     * @return User|null
     */
    public function authenticate(string $telephone, string $password): ?User
    {
        $user = $this->userRepository->findByTelephone($telephone);
        
        if ($user && password_verify($password, $user->getPassword())) {
            return $user;
        }

        return null;
    }

    /**
     * Récupère un utilisateur par son ID
     * @param int $id
     * @return User|null
     */
    public function getUserById(int $id): ?User
    {
        return $this->userRepository->findById($id);
    }
}
