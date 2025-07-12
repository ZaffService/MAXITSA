<?php

class Auth
{
   
    public function __invoke(): void
    {
        $session = App::getDependencie("session");
        
        if (!$session->has('user_id')) {
            redirect(url('login'));
            exit;
        }
        
        $lastActivity = $session->get('last_activity', 0);
        $sessionLifetime = SESSION_LIFETIME;
        
        if (time() - $lastActivity > $sessionLifetime) {
            $session->destroy();
            redirect(url('login?expired=1'));
            exit;
        }
        
        $session->set('last_activity', time());
    }
}
