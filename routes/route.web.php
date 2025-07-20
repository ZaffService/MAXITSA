<?php

use App\Controller\SecurityController;
use App\Controller\UserController;

$routes = [
  '/' => [
      'controller' => SecurityController::class,
      'action' => 'login',      
  ],
  
  '/dashboardClient' => [
      'controller' => UserController::class,
      'action' => 'showDashboard',
      'middlewares' => ['auth'],
  ],
  '/logout'=>[
    'controller'=>SecurityController::class,
    'action'=>'logout',
  ],
  '/comptes' => [ 
      'controller' => UserController::class,
      'action' => 'listAccounts', 
      'middlewares' => ['auth'], 
  ],
  '/ajouter-compte' => [ 
      'controller' => UserController::class,
      'action' => 'addAccountForm', 
      'middlewares' => ['auth'],
  ],

   '/register' => [ 
      'controller' => UserController::class,
      'action' => 'register',
  ],
];
