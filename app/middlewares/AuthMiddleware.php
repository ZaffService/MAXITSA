<?php

class AuthMiddleware
{
    public function __invoke(): void
    {
        $session = App::getDependencie("session");
        
        if (!$session->has('user_id')) {
            redirect(url('login'));
        }
        
        $this->checkSessionExpiry($session);
    }
    
    private function checkSessionExpiry(Session $session): void
    {
        $lastActivity = $session->get('last_activity', 0);
        
        if (time() - $lastActivity > SESSION_LIFETIME) {
            $session->destroy();
            redirect(url('login?expired=1'));
        }
        
        $session->set('last_activity', time());
    }
}
