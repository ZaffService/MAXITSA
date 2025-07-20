<?php

namespace App\Controller;

use App\Core\Abstract\AbstractController;
use App\Service\UserService;

class SecurityController extends AbstractController 
{
    private UserService $userService;
    
    public function __construct()
    {
        parent::__construct();
        $this->layout = 'security.layout.php'; 
        $this->userService = UserService::getInstance();
    }
    
    public function login()
    {
        $error = null;
        if($_SERVER['REQUEST_METHOD'] === 'POST')
        {
            $login = ($_POST['login']);
            $password = ($_POST['password']);
            $user = $this->userService->getUserByLoginPassword($login, $password);
            if($user !== null)
            {
                $this->session->set('user', $user);
                header('Location: /dashboardClient');
                exit();
            } else {
                $error = "Identifiants incorrects";
            }
        }
        $this->renderHTML('auth/login.html', ['error' => $error]);
    }
    public function logout(){
        session_destroy(); $login = ($_POST['login']);
            $password = ($_POST['password']);
        header('location:/');

    }
}
