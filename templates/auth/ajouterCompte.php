<?php $title = 'Mes Comptes'; ?>

<div class="flex flex-col min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-100 dark:from-gray-900 dark:via-blue-900 dark:to-indigo-900">
<?php include __DIR__ . '/../layout/partial/dashboard-header.php'; ?>

<main class="flex-1 flex items-center justify-center p-4">
  <div class="w-full max-w-md mx-auto bg-white rounded-lg shadow-lg overflow-hidden">
    <div class="bg-maxitsa-orange text-white p-6 text-center">
      <div class="w-16 h-16 mx-auto bg-white bg-opacity-20 rounded-full flex items-center justify-center mb-4">
        <span class="text-white font-bold text-3xl">M</span>
      </div>
      <h3 class="text-2xl font-semibold mb-1">Ajouter un nouveau compte</h3>
      <p class="text-sm opacity-90">Remplissez les informations ci-dessous pour créer un nouveau compte.</p>
    </div>
    <form action="/add-account" method="POST" class="p-6">
      <div class="grid gap-4">
        <div class="grid gap-2">
          <label class="text-sm font-medium leading-none text-gray-700" for="phone-number">
            Numéro de téléphone
          </label>
          <input
            class="flex h-10 w-full rounded-md border border-gray-300 bg-white px-3 py-2 text-sm placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-maxitsa-orange focus:border-transparent disabled:cursor-not-allowed disabled:opacity-50"
            id="phone-number"
            placeholder="Ex: 0612345678"
            required=""
            type="tel"
            name="phone_number"
          />
        </div>
        <div class="grid gap-2">
          <label class="text-sm font-medium leading-none text-gray-700" for="balance">
            Solde initial
          </label>
          <input
            class="flex h-10 w-full rounded-md border border-gray-300 bg-white px-3 py-2 text-sm placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-maxitsa-orange focus:border-transparent disabled:cursor-not-allowed disabled:opacity-50"
            id="balance"
            placeholder="Ex: 1000.00"
            required=""
            type="number"
            step="0.01"
            name="balance"
          />
        </div>
      </div>
      <div class="flex items-center mt-6">
            <button class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-maxitsa-orange focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 bg-maxitsa-orange text-white hover:bg-orange-600 h-10 px-4 py-2 w-full" type="submit">
            Ajouter un compte secondaire
        </button>
      </div>
    </form>
  </div>
</main>
</div>
