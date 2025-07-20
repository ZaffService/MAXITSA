<?php
namespace App\Controller;

use App\Core\Abstract\AbstractController;
use App\Service\CompteService;
use App\Repository\TransactionRepository;
use App\Service\TransactionService;
use App\Core\Validator;

class UserController extends AbstractController
{

    private CompteService $compteService;
    private TransactionService $transactionService;
    public function showDashboard()
    {
        $user = $this->session->get('user');
        if (!$user) {
            header('Location:/');
            exit();
        }
        $clientId = $user->getId();
        $compteId = $this->compteService->getCompteByClientId($clientId)['id'];
       
        $prenom = $this->session->get('user')->getPrenom();
        $transaction = $this->transactionService->getTransactionForClient($compteId);
        $accounts = $this->compteService->getClientAccounts($clientId);

        
        $solde = $this->compteService->getSoldeByClientId($clientId);
        $this->renderHTML('auth/dashboard', [
            'solde' => $solde,
            'prenom' => $prenom,
            'transaction' => $transaction,
            'accounts' => $accounts
        ]);
    }


    public function __construct (){
        parent::__construct();
        $this->compteService = CompteService::getInstance();
        $this->transactionService = TransactionService::getInstance();
    }   


      public function listAccounts(): void
   {
       $clientId = $this->session->get('user')->getId();
       $accounts = $this->compteService->getClientAccounts($clientId);
       $this->renderHTML('auth/list-accounts', [
           'accounts' => $accounts
       ]);
   }

   public function addAccountForm(): void{
    $this->renderHTML('auth/ajouterCompte');
   }
  

    public function register()
    {
        $this->layout = 'login.layout.php'; 
        $errors = [];
        $success = false;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'nom' => $_POST['nom'] ?? '',
                'prenom' => $_POST['prenom'] ?? '',
                'adresse' => $_POST['adresse'] ?? '',
                'telephone' => $_POST['telephone'] ?? '',
                'cni' => $_POST['cni'] ?? '',
                'password' => $_POST['password'] ?? '',
                'photo_recto' => $_FILES['photo_recto'] ?? null,
                'photo_verso' => $_FILES['photo_verso'] ?? null,
            ];

            $rules = [
                'nom' => ['required'],
                'prenom' => ['required'],
                'adresse' => ['required'],
                'telephone' => ['required', 'isSenegalPhone'],
                'cni' => ['required', 'isCNI'],
                'password' => ['required', ['minLength', 8], 'isPassword'],
                'photo_recto' => ['required'],
                'photo_verso' => ['required'],
            ];

            $validator = Validator::getInstance();
            Validator::resetError();

            if ($validator->validate($data, $rules)) {
                $success = true;
            } else {
                $errors = Validator::getErrors();
            }
        }

        $this->renderHTML('auth/register.html', ['errors' => $errors, 'success' => $success]);
    }





}
