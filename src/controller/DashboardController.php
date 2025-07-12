<?php
/**
 * Contrôleur du dashboard
 */
class DashboardController extends AbstractController
{
    private UserService $userService;
    private CompteService $compteService;
    private TransactionService $transactionService;

    public function __construct()
    {
        $this->userService = App::getDependencie('userService');
        $this->compteService = App::getDependencie('compteService');
        $this->transactionService = App::getDependencie('transactionService');
    }

    /**
     * Page principale du dashboard
     */
    public function index(): void
    {
        $session = App::getDependencie('session');
        $userId = $session->get('user_id');

        try {
            $user = $this->userService->getUserById($userId);
            $compte = $this->compteService->getPrincipalAccount($userId);
            $transactions = $this->transactionService->getLastTransactionsByUserId($userId, 10);

            $this->render('dashboard/index', [
                'user' => $user,
                'compte' => $compte,
                'transactions' => $transactions
            ]);
        } catch (Exception $e) {
            $this->render('dashboard/index', [
                'error' => $e->getMessage(),
                'user' => null,
                'compte' => null,
                'transactions' => []
            ]);
        }
    }
}
