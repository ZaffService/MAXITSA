<?php

abstract class AbstractController
{
    protected Session $session;
    
    public function __construct()
    {
        $this->session = App::getDependencie('session');
    }
    
    protected function render(string $view, array $data = []): void
    {
        view($view, $data);
    }
    
    protected function redirect(string $url): void
    {
        redirect($url);
    }
    
    protected function extractRequest(): array
    {
        extract($_POST);
        extract($_GET);
        return get_defined_vars();
    }
    
    protected function setMessage(string $key, string $type = 'info'): void
    {
        $this->session->set('message', [
            'type' => $type,
            'text' => Translator::get($key)
        ]);
    }
    
    protected function getMessage(): ?array
    {
        $message = $this->session->get('message');
        $this->session->remove('message');
        return $message;
    }
    
    protected function verifyCsrf(): bool
    {
        $token = $_POST['csrf_token'] ?? '';
        return csrf_verify($token);
    }

    protected function isPost(): bool
    {
        return $_SERVER['REQUEST_METHOD'] === 'POST';
    }
}
