<?php
/**
 * Routeur de l'application
 */
class Router
{
    private array $routes = [];
    
    public function get(string $path, string $controller, string $method, array $middlewares = []): void
    {
        $this->addRoute('GET', $path, $controller, $method, $middlewares);
    }
    
    public function post(string $path, string $controller, string $method, array $middlewares = []): void
    {
        $this->addRoute('POST', $path, $controller, $method, $middlewares);
    }
    
    private function addRoute(string $httpMethod, string $path, string $controller, string $method, array $middlewares): void
    {
        $this->routes[] = [
            'method' => $httpMethod,
            'path' => $path,
            'controller' => $controller,
            'action' => $method,
            'middlewares' => $middlewares
        ];
    }
    
    public function dispatch(): void
    {
        $requestMethod = $_SERVER['REQUEST_METHOD'];
        $requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        
        // Debug: afficher les informations de la requête
        if (APP_DEBUG) {
            error_log("Request Method: " . $requestMethod);
            error_log("Request URI: " . $requestUri);
            error_log("Routes registered: " . count($this->routes));
        }
        
        // Supprime le chemin de base si nécessaire
        $basePath = str_replace($_SERVER['DOCUMENT_ROOT'], '', __DIR__);
        $basePath = dirname(dirname($basePath));
        if ($basePath !== '/') {
            $requestUri = str_replace($basePath, '', $requestUri);
        }
        
        foreach ($this->routes as $route) {
            if ($route['method'] === $requestMethod && $this->matchPath($route['path'], $requestUri)) {
                if (APP_DEBUG) {
                    error_log("Route matched: " . $route['path'] . " -> " . $route['controller'] . "::" . $route['action']);
                }
                
                // Charger la configuration des middlewares
                require_once __DIR__ . '/../config/middlewares.php';
                
                // Exécution des middlewares
                foreach ($route['middlewares'] as $middlewareName) {
                    if (isset($middlewares[$middlewareName])) {
                        $middlewareClass = $middlewares[$middlewareName];
                        $middleware = new $middlewareClass();
                        $middleware();
                    }
                }
                
                // Exécution du contrôleur
                $controller = new $route['controller']();
                $controller->{$route['action']}();
                return;
            }
        }
        
        // Route non trouvée
        if (APP_DEBUG) {
            error_log("No route found for: " . $requestMethod . " " . $requestUri);
        }
        http_response_code(404);
        echo "Page non trouvée - " . $requestMethod . " " . $requestUri;
    }
    
    private function matchPath(string $routePath, string $requestPath): bool
    {
        return $routePath === $requestPath;
    }
}
