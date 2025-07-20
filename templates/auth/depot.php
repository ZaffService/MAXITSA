<div class="max-w-md mx-auto bg-white rounded-lg shadow-lg p-6 mt-10">
    <h2 class="text-xl font-bold mb-4">Faire un dépôt</h2>
    <?php if (!empty($error)): ?>
        <div class="mb-4 p-2 bg-red-100 text-red-700 rounded"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
    <form action="/depot-action" method="POST">
        <div class="mb-4">
            <label for="compte_id" class="block mb-2">Choisir le compte</label>
            <select name="compte_id" id="compte_id" class="w-full border rounded px-3 py-2">
                <?php foreach ($accounts as $compte): ?>
                    <option value="<?= $compte->getId() ?>">
                        <?= $compte->getType() ?> - <?= $compte->getTelephone() ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="mb-4">
            <label for="montant" class="block mb-2">Montant à déposer</label>
            <input type="number" name="montant" id="montant" class="w-full border rounded px-3 py-2" required min="1" step="0.01">
        </div>
        <button type="submit" class="bg-maxitsa-orange text-white px-4 py-2 rounded">Déposer</button>
    </form>
</div>