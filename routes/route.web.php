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
  '/add-account' => [
    'controller' => UserController::class,
    'action' => 'addAccount',
    'middlewares' => ['auth'],
],

   '/register' => [ 
      'controller' => UserController::class,
      'action' => 'register',
  ],
  '/depot' => [
    'controller' => UserController::class,
    'action' => 'depotForm',
    'middlewares' => ['auth'],
],
'/depot-action' => [
    'controller' => UserController::class,
    'action' => 'depot',
    'middlewares' => ['auth'],
],
'/retrait' => [
    'controller' => UserController::class,
    'action' => 'retraitForm',
    'middlewares' => ['auth'],
],
'/retrait-action' => [
    'controller' => UserController::class,
    'action' => 'retrait',
    'middlewares' => ['auth'],
],
];
