<?php

namespace App\Core\Middlewares;

use App\Core\Session;

class Auth
{
    public function __invoke(): bool
    {
        try {
            $session = Session::getInstance();
            $user = $session->get('user');
            var_dump($user);

            if (!$user) {
                header('Location: /');
                echo "il ya d'utilisateur";
                exit; 
            }

            return true; 

        } catch (\Throwable $e) {
            error_log("Erreur lors de la vérification d'authentification: " . $e->getMessage());
            header('Location: /');
            exit; 
        }
    }
}
