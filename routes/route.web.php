<?php

$router = App::getDependencie("router");

// Routes publiques
$router->get('/', 'SecurityController', 'showLogin');
$router->get('/login', 'SecurityController', 'showLogin');
$router->post('/login', 'SecurityController', 'login');
$router->get('/register', 'SecurityController', 'showRegister');
$router->post('/register', 'SecurityController', 'register', ['crypt']);
$router->get('/logout', 'SecurityController', 'logout');

// Routes protégées
$router->get('/dashboard', 'DashboardController', 'index', ['auth']);
$router->get('/comptes', 'CompteController', 'index', ['auth']);
$router->get('/transactions', 'TransactionController', 'index', ['auth']);

// Nouvelle route pour le dépôt
$router->get('/transactions/deposit', 'TransactionController', 'showDepositForm', ['auth']);
$router->post('/transactions/deposit', 'TransactionController', 'processDeposit', ['auth']);
