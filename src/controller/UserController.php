<?php
namespace App\Controller;

use App\Core\Abstract\AbstractController;
use App\Service\CompteService;
use App\Service\TransactionService;
use App\Core\Validator;
use App\Service\UserService;

class UserController extends AbstractController
{

    private UserService $userService;
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
        $comptePrincipal = $this->compteService->getComptePrincipalByClientId($clientId);
        $solde = $comptePrincipal ? $comptePrincipal['solde'] : 0;

        $prenom = $user->getPrenom();
        $compteId = $comptePrincipal ? $comptePrincipal['id'] : null;
        $transaction = $this->transactionService->getTransactionForClient($compteId);
        $accounts = $this->compteService->getClientAccounts($clientId);

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
        $this->userService = UserService::getInstance();
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
                'login' => $_POST['login'] ?? '', 
                'password' => $_POST['password'] ?? '',
                'numeroidentite' => $_POST['numeroidentite'] ?? '',
                'photorecto' => $_FILES['photorecto']['name'] ?? '', 
                'photoverso' => $_FILES['photoverso']['name'] ?? '', 
            ];

            $rules = [
                'nom' => ['required'],
                'prenom' => ['required'],
                'adresse' => ['required'],
                'login' => ['required', 'isSenegalPhone'],
                'password' => ['required', ['minLength', 8], 'isPassword'],
                'photorecto' => ['required'],
                'photoverso' => ['required'],
                'numeroidentite' => ['required', 'isCNI'],
                'adresse' => ['required'],

            ];

            $validator = Validator::getInstance();
            Validator::resetError();

            if ($validator->validate($data, $rules)) {
                $success = $this->userService->registerUser($data);
            } else {
                $errors = Validator::getErrors();
            }
        }

        $this->renderHTML('auth/register.html', ['errors' => $errors, 'success' => $success]);
    }

    
public function addAccount(): void
{
    $user = $this->session->get('user');
    if (!$user) {
        header('Location:/');
        exit();
    }
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $clientId = $user->getId();
        $telephone = $_POST['phone_number'] ?? '';
        $solde = floatval($_POST['balance'] ?? 0);

        $success = $this->compteService->addSecondaryAccount($clientId, $telephone, $solde);

        if ($success) {
            header('Location: /comptes');
            exit();
        } else {
            $error = "Erreur lors de l'ajout du compte secondaire.";
            $this->renderHTML('auth/ajouterCompte', ['error' => $error]);
        }
    }
}


public function depotForm(): void
{
    $clientId = $this->session->get('user')->getId();
    $accounts = $this->compteService->getClientAccounts($clientId);
    $this->renderHTML('auth/depot', ['accounts' => $accounts]);
}

public function depot(): void
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $compteId = intval($_POST['compte_id'] ?? 0);
        $montant = floatval($_POST['montant'] ?? 0);

        $success = $this->transactionService->depot($compteId, $montant);

        if ($success) {
            header('Location: /dashboardClient');
            exit();
        } else {
            $error = "Erreur lors du dépôt.";
            $this->renderHTML('auth/depot', ['error' => $error]);
        }
    }
}

public function retraitForm(): void
{
    $clientId = $this->session->get('user')->getId();
    $principal = $this->compteService->getComptePrincipalByClientId($clientId);
    $secondaires = $this->compteService->getComptesSecondairesByClientId($clientId);
    $this->renderHTML('auth/retrait', [
        'principal' => $principal,
        'secondaires' => $secondaires
    ]);
}

public function retrait(): void
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $comptePrincipalId = intval($_POST['compte_principal_id']);
        $compteSecondaireId = intval($_POST['compte_secondaire_id']);
        $montant = floatval($_POST['montant']);

        $success = $this->transactionService->retrait($comptePrincipalId, $compteSecondaireId, $montant);

        if ($success) {
            header('Location: /dashboardClient');
            exit();
        } else {
            $error = "Erreur lors du retrait.";
            $this->renderHTML('auth/retrait', ['error' => $error]);
        }
    }
}
}
