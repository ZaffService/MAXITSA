<?php
$title = 'Toutes les transactions - MAXITSA';
$pageTitle = 'Historique des transactions';
ob_start();
?>

<div class="space-y-6">
    <div class="bg-white rounded-lg p-6 shadow-sm">
        <h2 class="text-xl font-semibold text-gray-800 mb-4">Toutes vos transactions</h2>
        
        <?php if (isset($message)): ?>
            <div class="mb-6 p-4 rounded-lg <?= $message['type'] === 'success' ? 'bg-green-50 border border-green-200 text-green-700' : 'bg-red-50 border border-red-200 text-red-700' ?>" data-alert>
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <?php if ($message['type'] === 'success'): ?>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        <?php else: ?>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        <?php endif; ?>
                    </svg>
                    <?= escape($message['text']) ?>
                </div>
            </div>
        <?php endif; ?>

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
