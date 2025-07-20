<div class="max-w-md mx-auto bg-white rounded-lg shadow-lg p-6 mt-10">
    <h2 class="text-xl font-bold mb-4">Faire un retrait</h2>
    <?php if (!empty($error)): ?>
        <div class="mb-4 p-2 bg-red-100 text-red-700 rounded"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
    <form action="/retrait-action" method="POST">
        <div class="mb-4">
            <label class="block mb-2">Compte principal</label>
            <input type="text" value="<?= $principal['telephone'] ?>" disabled class="w-full border rounded px-3 py-2 bg-gray-100">
            <input type="hidden" name="compte_principal_id" value="<?= $principal['id'] ?>">
        </div>
        <div class="mb-4">
            <label class="block mb-2">Compte secondaire</label>
            <select name="compte_secondaire_id" class="w-full border rounded px-3 py-2">
                <?php foreach ($secondaires as $c): ?>
                    <option value="<?= $c['id'] ?>"><?= $c['telephone'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="mb-4">
            <label class="block mb-2">Montant à retirer</label>
            <input type="number" name="montant" class="w-full border rounded px-3 py-2" required min="1" step="0.01">
        </div>
        <button type="submit" class="bg-maxitsa-orange text-white px-4 py-2 rounded">Retirer</button>
    </form>
</div>