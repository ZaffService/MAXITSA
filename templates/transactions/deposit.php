<?php
$title = 'Dépôt - MAXITSA';
$pageTitle = 'Effectuer un dépôt';
ob_start();
?>

<div class="space-y-6">
    <div class="bg-white rounded-lg p-6 shadow-sm">
        <h2 class="text-xl font-semibold text-gray-800 mb-4">Dépôt sur votre compte principal</h2>
        
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

        <form method="POST" action="<?= url('transactions/deposit') ?>" class="space-y-6">
            <input type="hidden" name="csrf_token" value="<?= csrf_token() ?>">
            
            <div>
                <label class="block text-gray-700 text-sm font-semibold mb-2">Numéro de compte</label>
                <input 
                    type="text" 
                    value="<?= escape($compte->getNumeroCompte()) ?>" 
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg bg-gray-100 cursor-not-allowed" 
                    readonly
                >
            </div>

            <div>
                <label class="block text-gray-700 text-sm font-semibold mb-2">Montant du dépôt (CFA)</label>
                <input 
                    type="number" 
                    name="montant" 
                    value="<?= escape($old_input['montant'] ?? '') ?>"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-maxitsa-orange focus:border-transparent transition-colors"
                    placeholder="Ex: 10000"
                    min="100"
                >
                <?php if (isset($errors['montant'])): ?>
                    <p class="text-red-500 text-sm mt-1"><?= escape($errors['montant']) ?></p>
                <?php endif; ?>
            </div>

            <div>
                <label class="block text-gray-700 text-sm font-semibold mb-2">Description (optionnel)</label>
                <textarea 
                    name="description" 
                    rows="3" 
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-maxitsa-orange focus:border-transparent transition-colors"
                    placeholder="Ex: Dépôt pour les courses"
                ><?= escape($old_input['description'] ?? '') ?></textarea>
            </div>

            <button 
                type="submit" 
                class="w-full bg-maxitsa-orange text-white py-3 rounded-lg font-semibold hover:bg-opacity-90 transition-colors transform hover:scale-105"
            >
                Effectuer le dépôt
            </button>
        </form>
    </div>
</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layouts/dashboard.php';
?>
