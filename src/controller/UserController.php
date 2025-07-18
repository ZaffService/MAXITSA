<?php
namespace App\Controller;

use App\Core\Abstract\AbstractController;
use App\Service\CompteService;
use App\Repository\TransactionRepository;
use App\Service\TransactionService;

class UserController extends AbstractController
{

    private CompteService $compteService;
    private TransactionService $transactionService;
    public function showDashboard()
    {
        $clientId = $this->session->get('user')->getId();
        if (!$clientId) {
            header('Location:/');
            exit();
        }
        $compteId = $this->compteService->getCompteByClientId($clientId)['id'];
       
        $prenom = $this->session->get('user')->getPrenom();
        $transaction = $this->transactionService->getTransactionForClient($compteId);
        
        $solde = $this->compteService->getSoldeByClientId($clientId);
        $this->renderHTML('auth/dashboard', [
            'solde' => $solde,
            'prenom' => $prenom,
            'transaction' => $transaction,
        ]);
    }


    public function __construct (){
        parent::__construct();
        $this->compteService = CompteService::getInstance();
        $this->transactionService = TransactionService::getInstance();
    }   


      public function listAccounts(): void
   {
      
       $this->renderHTML('auth/list-accounts');
   }

   public function addAccountForm(): void{
    $this->renderHTML('auth/ajouterCompte');
   }

}
