<?php

function redirect(string $url): void
{
    if (APP_DEBUG) {
        error_log("Redirecting to: " . $url);
    }
    header("Location: $url");
    exit;
}


function escape(string $data): string
{
    return htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
}


function url(string $path = ''): string
{
    $baseUrl = APP_URL . '/' . ltrim($path, '/');
    if (APP_DEBUG) {
        error_log("Generated URL: " . $baseUrl);
    }
    return $baseUrl;
}


function view(string $view, array $data = []): void
{
    extract($data);
    $viewPath = __DIR__ . "/../../templates/$view.php";
    
    if (APP_DEBUG) {
        error_log("Loading view: " . $viewPath);
    }
    
    if (file_exists($viewPath)) {
        include $viewPath;
    } else {
        throw new Exception("Vue non trouvée : $view (chemin: $viewPath)");
    }
}


function csrf_token(): string
{
    if (!isset($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}


function csrf_verify(string $token): bool
{
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}
