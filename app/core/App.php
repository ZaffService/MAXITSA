<?php

class App
{
    private static array $dependencies = [];
    
    public static function run(): void
    {
        Translator::load();
        self::initDependencies();
        
        require_once __DIR__ . '/../../routes/route.web.php';
        
        $router = self::getDependencie('router');
        $router->dispatch();
    }
    
    private static function initDependencies(): void
    {
        self::registerCore();
        self::registerRepositories();
        self::registerServices();
    }
    
    private static function registerCore(): void
    {
        self::$dependencies['session'] = new Session();
        self::$dependencies['database'] = new Database();
        self::$dependencies['router'] = new Router();
    }
    
    private static function registerRepositories(): void
    {
        $database = self::$dependencies['database'];
        
        self::$dependencies['userRepository'] = new UserRepository($database);
        self::$dependencies['compteRepository'] = new CompteRepository($database);
        self::$dependencies['transactionRepository'] = new TransactionRepository($database);
    }
    
    private static function registerServices(): void
    {
        // Initialiser TwilioService en premier car il est une dépendance de UserService
        self::$dependencies['twilioService'] = new TwilioService();

        self::$dependencies['userService'] = new UserService(
            self::$dependencies['userRepository'],
            self::$dependencies['twilioService']
        );
        self::$dependencies['transactionService'] = new TransactionService(
            self::$dependencies['transactionRepository'],
            self::$dependencies['compteRepository'],
            self::$dependencies['database'] // Passer l'instance de Database ici
        );
        self::$dependencies['compteService'] = new CompteService(self::$dependencies['compteRepository']);
        self::$dependencies['fileUploadService'] = new FileUploadService();
        self::$dependencies['validator'] = new Validator(self::$dependencies['userRepository']);
    }
    
    public static function getDependencie(string $name)
    {
        if (!isset(self::$dependencies[$name])) {
            throw new Exception("Dependency '{$name}' not found");
        }
        
        return self::$dependencies[$name];
    }
}
