<?php
/**
 * Contrôleur des transactions
 */
class TransactionController extends AbstractController
{
    private TransactionService $transactionService;
    private CompteService $compteService;
    private Validator $validator;
    private UserService $userService; // Added UserService

    public function __construct()
    {
        parent::__construct();
        $this->transactionService = App::getDependencie('transactionService');
        $this->compteService = App::getDependencie('compteService');
        $this->validator = App::getDependencie('validator');
        $this->userService = App::getDependencie('userService'); // Initialized UserService
    }

    /**
     * Liste des transactions
     */
    public function index(): void
    {
        $session = App::getDependencie('session');
        $userId = $session->get('user_id');
        
        try {
            $user = $this->userService->getUserById($userId); // Fetch the user
            $transactions = $this->transactionService->getLastTransactionsByUserId($userId, 20); // Afficher plus de transactions
            $this->render('transactions/index', [
                'user' => $user, // Pass the user to the view
                'transactions' => $transactions
            ]);
        } catch (Exception $e) {
            $this->setMessage(MessageEnum::ERROR_TRANSACTION_FETCH, 'error'); // Message d'erreur générique
            $this->render('transactions/index', [
                'user' => $user ?? null, // Pass the user even if there's an error
                'transactions' => [],
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Affiche le formulaire de dépôt
     */
    public function showDepositForm(): void
    {
        $session = App::getDependencie('session');
        $userId = $session->get('user_id');
        
        try {
            $user = $this->userService->getUserById($userId); // Fetch the user
            $compte = $this->compteService->getPrincipalAccount($userId);
            if (!$compte) {
                $this->setMessage(MessageEnum::ERROR_ACCOUNT_NOT_FOUND, 'error');
                $this->redirect(url('dashboard'));
                return;
            }
            $this->render('transactions/deposit', [
                'user' => $user, // Pass the user to the view
                'compte' => $compte,
                'message' => $this->getMessage()
            ]);
        } catch (Exception $e) {
            $this->setMessage(MessageEnum::ERROR_DEPOSIT_FORM_LOAD, 'error');
            $this->redirect(url('dashboard'));
        }
    }

    /**
     * Traite le dépôt d'argent
     */
    public function processDeposit(): void
    {
        if (!$this->isPost()) {
            $this->redirect(url('transactions/deposit'));
            return;
        }

        if (!$this->verifyCsrf()) {
            $this->setMessage(MessageEnum::ERROR_CSRF_INVALID, 'error');
            $this->redirect(url('transactions/deposit'));
            return;
        }

        $data = $this->extractRequest();
        $montant = (float) ($data['montant'] ?? 0);
        $description = $data['description'] ?? null;
        
        $this->validator->required('montant', $montant)
                        ->min('montant', $montant, 100); // Minimum 100 CFA pour un dépôt

        if (!$this->validator->validate()) {
            $session = App::getDependencie('session');
            $userId = $session->get('user_id');
            $user = $this->userService->getUserById($userId); // Fetch the user for re-render
            $compte = $this->compteService->getPrincipalAccount($userId);
            $this->render('transactions/deposit', [
                'user' => $user, // Pass the user to the view
                'compte' => $compte,
                'errors' => $this->validator->getErrors(),
                'old_input' => $data
            ]);
            return;
        }

        $session = App::getDependencie('session');
        $userId = $session->get('user_id');

        try {
            $compte = $this->compteService->getPrincipalAccount($userId);
            if (!$compte) {
                throw new Exception(MessageEnum::ERROR_ACCOUNT_NOT_FOUND);
            }

            $this->transactionService->createDeposit($compte->getId(), $montant, $description);
            $this->setMessage(MessageEnum::SUCCESS_DEPOSIT, 'success');
            $this->redirect(url('dashboard'));
        } catch (Exception $e) {
            $errorMessageKey = $e->getMessage();
            $reflectionClass = new ReflectionClass(MessageEnum::class);
            if ($reflectionClass->hasConstant($errorMessageKey)) {
                $this->setMessage(constant("MessageEnum::" . $errorMessageKey), 'error');
            } else {
                $this->setMessage(MessageEnum::ERROR_DEPOSIT_FAILED, 'error');
                error_log("Unexpected error during deposit: " . $e->getMessage());
            }
            $this->redirect(url('transactions/deposit'));
        }
    }
}
