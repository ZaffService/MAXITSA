<?php

class AuthController extends AbstractController
{
    private UserService $userService;
    private CompteService $compteService;

    public function __construct()
    {
        $this->userService = App::getDependencie('userService');
        $this->compteService = App::getDependencie('compteService');
    }

    public function index(): void
    {
        if (APP_DEBUG) {
            error_log("AuthController::index() called - redirecting to login");
        }
        $this->redirect(url('login'));
    }

    public function showLogin(): void
    {
        if (APP_DEBUG) {
            error_log("AuthController::showLogin() called");
        }
        
        $session = App::getDependencie('session');
        $message = $session->get('message');
        $session->remove('message');
        
        $this->render('auth/login', ['message' => $message]);
    }

    public function login(): void
    {
        if (!$this->isPost()) {
            $this->redirect(url('login'));
            return;
        }

        if (!$this->verifyCsrf()) {
            $session = App::getDependencie('session');
            $session->set('message', ['type' => 'error', 'text' => 'Token CSRF invalide']);
            $this->redirect(url('login'));
            return;
        }

        $telephone = $this->getPost('telephone');
        $password = $this->getPost('password');

        $validator = new Validator();
        $validator->required('telephone', $telephone)
                 ->required('password', $password);

        if ($validator->hasErrors()) {
            $this->render('auth/login', ['errors' => $validator->getErrors()]);
            return;
        }

        try {
            $user = $this->userService->authenticate($telephone, $password);
            
            if ($user) {
                $session = App::getDependencie('session');
                $session->set('user_id', $user->getId());
                $session->set('last_activity', time());
                
                $this->redirect(url('dashboard'));
            } else {
                $session = App::getDependencie('session');
                $session->set('message', ['type' => 'error', 'text' => 'Identifiants incorrects']);
                $this->redirect(url('login'));
            }
        } catch (Exception $e) {
            $session = App::getDependencie('session');
            $session->set('message', ['type' => 'error', 'text' => $e->getMessage()]);
            $this->redirect(url('login'));
        }
    }

    public function showRegister(): void
    {
        if (APP_DEBUG) {
            error_log("AuthController::showRegister() called");
        }
        
        $session = App::getDependencie('session');
        $message = $session->get('message');
        $session->remove('message');
        
        $this->render('auth/register', ['message' => $message]);
    }

    public function register(): void
    {
        if (!$this->isPost()) {
            $this->redirect(url('register'));
            return;
        }

        if (!$this->verifyCsrf()) {
            $session = App::getDependencie('session');
            $session->set('message', ['type' => 'error', 'text' => 'Token CSRF invalide']);
            $this->redirect(url('register'));
            return;
        }

        // Gestion des uploads
        $fileUpload = new FileUpload();
        $photoRecto = null;
        $photoVerso = null;

        try {
            if (isset($_FILES['photo_recto']) && $_FILES['photo_recto']['error'] === UPLOAD_ERR_OK) {
                $photoRecto = $fileUpload->upload($_FILES['photo_recto']);
            }
            
            if (isset($_FILES['photo_verso']) && $_FILES['photo_verso']['error'] === UPLOAD_ERR_OK) {
                $photoVerso = $fileUpload->upload($_FILES['photo_verso']);
            }
        } catch (Exception $e) {
            $session = App::getDependencie('session');
            $session->set('message', ['type' => 'error', 'text' => $e->getMessage()]);
            $this->redirect(url('register'));
            return;
        }

        $data = [
            'nom' => $this->getPost('nom'),
            'prenom' => $this->getPost('prenom'),
            'telephone' => $this->getPost('telephone'),
            'adresse' => $this->getPost('adresse'),
            'numero_identite' => $this->getPost('numero_identite'),
            'password' => $this->getPost('password'), // Sera crypté par le middleware
            'photo_recto' => $photoRecto,
            'photo_verso' => $photoVerso
        ];

        $validator = new Validator();
        $validator->required('nom', $data['nom'])
                 ->required('prenom', $data['prenom'])
                 ->required('telephone', $data['telephone'])
                 ->phone('telephone', $data['telephone'])
                 ->required('adresse', $data['adresse'])
                 ->required('numero_identite', $data['numero_identite'])
                 ->required('password', $data['password']);

        if ($validator->hasErrors()) {
            $this->render('auth/register', ['errors' => $validator->getErrors()]);
            return;
        }

        try {
            $user = $this->userService->createUser($data);
            
            if ($user) {
                // Créer le compte principal
                $this->compteService->createPrincipalAccount($user->getId());
                
                $session = App::getDependencie('session');
                $session->set('message', ['type' => 'success', 'text' => 'Compte créé avec succès ! Vous pouvez maintenant vous connecter.']);
                $this->redirect(url('login'));
            } else {
                $session = App::getDependencie('session');
                $session->set('message', ['type' => 'error', 'text' => 'Erreur lors de la création du compte']);
                $this->redirect(url('register'));
            }
        } catch (Exception $e) {
            $session = App::getDependencie('session');
            $session->set('message', ['type' => 'error', 'text' => $e->getMessage()]);
            $this->redirect(url('register'));
        }
    }

    public function logout(): void
    {
        $session = App::getDependencie('session');
        $session->destroy();
        $this->redirect(url('login'));
    }
}
