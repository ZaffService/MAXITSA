<?php

class SecurityController extends AbstractController
{
    private UserService $userService;
    private CompteService $compteService;
    private FileUploadService $fileUploadService;
    private Validator $validator;
    
    public function __construct()
    {
        parent::__construct();
        $this->userService = App::getDependencie('userService');
        $this->compteService = App::getDependencie('compteService');
        $this->fileUploadService = App::getDependencie('fileUploadService');
        $this->validator = App::getDependencie('validator');
    }
    
    public function showLogin(): void
    {
        $this->render('auth/login', ['message' => $this->getMessage()]);
    }
    
    public function login(): void
    {
        if (!$this->verifyCsrf()) {
            $this->setMessage(MessageEnum::ERROR_CSRF_INVALID, 'error');
            $this->redirect(url('login'));
            return;
        }
        
        $data = $this->extractRequest();
        unset($data['csrf_token']); // Supprimer le token CSRF des données
        $this->validateLogin($data);
        
        if (!$this->validator->validate()) {
            $this->render('auth/login', ['errors' => $this->validator->getErrors()]);
            return;
        }
        
        if ($this->authenticateUser($data)) {
            $this->redirect(url('dashboard'));
        } else {
            $this->setMessage(MessageEnum::ERROR_INVALID_CREDENTIALS, 'error');
            $this->redirect(url('login'));
        }
    }
    
    public function showRegister(): void
    {
        $this->render('auth/register', ['message' => $this->getMessage()]);
    }
    
    public function register(): void
    {
        if (!$this->verifyCsrf()) {
            $this->setMessage(MessageEnum::ERROR_CSRF_INVALID, 'error');
            $this->redirect(url('register'));
            return;
        }
        
        $data = $this->extractRequest();
        unset($data['csrf_token']); // Supprimer le token CSRF des données
        $this->validateRegister($data);
        
        if (!$this->validator->validate()) {
            $this->render('auth/register', ['errors' => $this->validator->getErrors()]);
            return;
        }
        
        if ($this->createUser($data)) {
            $this->setMessage(MessageEnum::SUCCESS_ACCOUNT_CREATED, 'success');
            $this->redirect(url('login'));
        } else {
            // Le message d'erreur est déjà défini par createUser en cas d'échec
            $this->redirect(url('register'));
        }
    }
    
    public function logout(): void
    {
        $this->session->destroy();
        $this->redirect(url('login'));
    }
    
    private function validateLogin(array $data): void
    {
        $this->validator->required('telephone', $data['telephone'] ?? '')
                        ->phone('telephone', $data['telephone'] ?? '')
                        ->required('password', $data['password'] ?? '');
    }
    
    private function validateRegister(array $data): void
    {
        $this->validator->required('nom', $data['nom'] ?? '')
                        ->required('prenom', $data['prenom'] ?? '')
                        ->required('telephone', $data['telephone'] ?? '')
                        ->phone('telephone', $data['telephone'] ?? '')
                        ->unique('telephone', $data['telephone'] ?? '', 'telephoneExists', MessageEnum::ERROR_PHONE_EXISTS)
                        ->required('adresse', $data['adresse'] ?? '')
                        ->required('numero_identite', $data['numero_identite'] ?? '')
                        ->cni('numero_identite', $data['numero_identite'] ?? '')
                        ->required('password', $data['password'] ?? '');

        // Ajout de la validation pour les téléchargements de fichiers
        $this->validator->required('photo_recto', $_FILES['photo_recto']['tmp_name'] ?? '');
        $this->validator->required('photo_verso', $_FILES['photo_verso']['tmp_name'] ?? '');
    }
    
    private function authenticateUser(array $data): bool
    {
        $user = $this->userService->authenticate($data['telephone'], $data['password']);
        
        if ($user) {
            $this->session->set('user_id', $user->getId());
            $this->session->set('last_activity', time());
            return true;
        }
        
        return false;
    }
    
    private function createUser(array $data): bool
    {
        try {
            // Upload des fichiers
            $data['photo_recto'] = $this->uploadFile('photo_recto');
            $data['photo_verso'] = $this->uploadFile('photo_verso');
            
            // Le service ne vérifie plus l'unicité, c'est le Validator qui le fait
            $user = $this->userService->createUser($data);
            if ($user) {
                $this->compteService->createPrincipalAccount($user->getId());
                return true;
            }
        } catch (Exception $e) {
            $errorMessageKey = $e->getMessage();
            // Vérifier si le message d'exception est une de nos constantes MessageEnum
            $reflectionClass = new ReflectionClass(MessageEnum::class);
            if ($reflectionClass->hasConstant($errorMessageKey)) {
                $this->setMessage(constant("MessageEnum::" . $errorMessageKey), 'error');
            } else {
                // Fallback pour les exceptions inattendues
                $this->setMessage(MessageEnum::ERROR_VALIDATION_FAILED, 'error'); 
                error_log("Unexpected error during user creation: " . $e->getMessage());
            }
        }
        
        return false;
    }
    
    private function uploadFile(string $fieldName): ?string
    {
        if (isset($_FILES[$fieldName]) && $_FILES[$fieldName]['error'] === UPLOAD_ERR_OK) {
            return $this->fileUploadService->upload($_FILES[$fieldName]);
        }
        return null;
    }
}
