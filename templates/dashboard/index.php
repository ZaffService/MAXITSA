<?php
$title = 'Dashboard - MAXITSA';
$pageTitle = 'Aperçu du compte';
ob_start();
?>

<div class="space-y-6">
    <!-- En-tête avec informations utilisateur -->
    <div class="bg-white rounded-lg p-6 shadow-sm">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-xl font-semibold text-gray-800">
                    Bonjour <?= $user ? escape($user->getFullName()) : 'Utilisateur' ?>
                </h2>
                <p class="text-gray-600">Bienvenue sur votre espace MAXITSA</p>
            </div>
            <div class="text-right">
                <p class="text-sm text-gray-500">Dernière connexion</p>
                <p class="text-sm font-medium"><?= date('d/m/Y H:i') ?></p>
            </div>
        </div>
    </div>

    <!-- Carte du solde principal -->
    <div class="bg-gradient-to-r from-maxitsa-orange to-orange-600 text-white rounded-lg p-6 shadow-lg">
        <div class="flex items-center justify-between">
            <div>
                <div class="flex items-center space-x-3 mb-2">
                    <div class="w-8 h-8 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm opacity-90">Compte Principal</p>
                        <p class="text-xs opacity-75"><?= $compte ? escape($compte->getNumeroCompte()) : 'N/A' ?></p>
                    </div>
                </div>
                <div class="text-3xl font-bold">
                    <?= $compte ? $compte->getFormattedSolde() : '0 CFA' ?>
                </div>
            </div>
            <div class="text-right">
                <a href="<?= url('transactions/deposit') ?>" class="bg-white bg-opacity-20 hover:bg-opacity-30 px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                    Recharger
                </a>
            </div>
        </div>
    </div>
    
    <!-- Actions rapides -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <a href="<?= url('transactions/deposit') ?>" class="bg-white rounded-lg p-6 shadow-sm hover:shadow-md transition-shadow cursor-pointer">
            <div class="flex items-center space-x-3">
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                </div>
                <div>
                    <h3 class="font-medium text-gray-800">Dépôt</h3>
                    <p class="text-sm text-gray-500">Alimenter le compte</p>
                </div>
            </div>
        </a>
        
        <div class="bg-white rounded-lg p-6 shadow-sm hover:shadow-md transition-shadow cursor-pointer">
            <div class="flex items-center space-x-3">
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"></path>
                    </svg>
                </div>
                <div>
                    <h3 class="font-medium text-gray-800">Transfert</h3>
                    <p class="text-sm text-gray-500">Envoyer de l'argent</p>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-lg p-6 shadow-sm hover:shadow-md transition-shadow cursor-pointer">
            <div class="flex items-center space-x-3">
                <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 0h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v2"></path>
                    </svg>
                </div>
                <div>
                    <h3 class="font-medium text-gray-800">Paiement</h3>
                    <p class="text-sm text-gray-500">Payer une facture</p>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Section Transactions -->
    <div class="bg-white rounded-lg p-6 shadow-sm">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-lg font-semibold text-gray-800">Dernières transactions</h2>
            <a href="<?= url('transactions') ?>" class="text-maxitsa-orange hover:underline flex items-center text-sm font-medium">
                Voir toutes les transactions
                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </a>
        </div>
        
        <?php if (!empty($transactions)): ?>
            <div class="space-y-4">
                <?php foreach ($transactions as $transaction): ?>
                    <div class="flex items-center justify-between py-4 border-b border-gray-100 last:border-b-0">
                        <div class="flex items-center space-x-4">
                            <div class="w-10 h-10 rounded-full flex items-center justify-center <?= $transaction->getTypeTransaction() === 'Depot' ? 'bg-green-100' : ($transaction->getTypeTransaction() === 'Retrait' ? 'bg-red-100' : 'bg-blue-100') ?>">
                                <?php if ($transaction->getTypeTransaction() === 'Depot'): ?>
                                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                    </svg>
                                <?php elseif ($transaction->getTypeTransaction() === 'Retrait'): ?>
                                    <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 12H6"></path>
                                    </svg>
                                <?php else: ?>
                                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 0h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v2"></path>
                                    </svg>
                                <?php endif; ?>
                            </div>
                            <div>
                                <div class="font-medium text-gray-800">
                                    <?= escape($transaction->getTypeTransaction()) ?>
                                </div>
                                <div class="text-sm text-gray-500">
                                    <?= $transaction->getFormattedDate() ?>
                                    <?php if ($transaction->getDescription()): ?>
                                        • <?= escape($transaction->getDescription()) ?>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <div class="text-right">
                            <div class="font-semibold <?= $transaction->getColorClass() ?>">
                                <?= $transaction->getFormattedMontant() ?>
                            </div>
                            <div class="text-xs text-gray-500">
                                <?= date('H:i', strtotime($transaction->getCreatedAt())) ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="text-center py-12">
                <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 012 2"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-medium text-gray-800 mb-2">Aucune transaction</h3>
                <p class="text-gray-500">Vos transactions apparaîtront ici une fois que vous commencerez à utiliser votre compte.</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layouts/dashboard.php';
?>
