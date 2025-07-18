<!-- Welcome Section -->
<div class="mb-6">
  <h2 class="text-2xl font-bold text-gray-800 mb-2"> <?= $prenom ?> </h2>
  <p class="text-gray-600">Bienvenue sur votre espace MAXITSA</p>
  <div class="text-right text-sm text-gray-500 mt-2">
      <a href="/comptes" class="bg-maxitsa-orange text-white px-4 py-2 rounded-lg font-medium hover:bg-orange-600 transition-colors">
        Voir mes comptes 
      </a>
  </div>
</div>

<!-- Account Card -->
<div class="bg-maxitsa-orange rounded-xl p-6 text-white mb-8">
  <div class="flex items-center justify-between">
      <div>
          <div class="flex items-center mb-2">
              <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
              </svg>
              <span class="text-sm opacity-90">Compte Principal</span>
          </div>
          <p class="text-xs opacity-75 mb-1">MAXITSA-567890</p>
          <h3 class="text-3xl font-bold"> <?=$solde?> </h3>
          
      </div>
      <button class="bg-white bg-opacity-20 hover:bg-opacity-30 px-4 py-2 rounded-lg transition-colors">
          Recharger
      </button>
  </div>
</div>

<!-- Action Buttons -->
<div class="grid grid-cols-3 gap-4 mb-8">
  <div class="bg-white rounded-xl p-6 text-center hover:shadow-lg transition-shadow cursor-pointer">
      <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-3">
          <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
          </svg>
      </div>
      <h4 class="font-semibold text-gray-800 mb-1">Dépôt</h4>
      <p class="text-sm text-gray-600">Alimenter le compte</p>
  </div>

  <div class="bg-white rounded-xl p-6 text-center hover:shadow-lg transition-shadow cursor-pointer">
      <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-3">
          <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path>
          </svg>
      </div>
      <h4 class="font-semibold text-gray-800 mb-1">Transfert</h4>
      <p class="text-sm text-gray-600">Envoyer de l'argent</p>
  </div>

  <div class="bg-white rounded-xl p-6 text-center hover:shadow-lg transition-shadow cursor-pointer">
      <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-3">
          <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
          </svg>
      </div>
      <h4 class="font-semibold text-gray-800 mb-1">Paiement</h4>
      <p class="text-sm text-gray-600">Payer une facture</p>
  </div>
</div>

<!-- Recent Transactions -->
<div class="bg-white rounded-xl p-6">
  <div class="flex items-center justify-between mb-6">
      <h3 class="text-lg font-semibold text-gray-800">Dernières transactions</h3>
      <a href="#" class="text-maxitsa-orange hover:underline text-sm">Voir toutes les transactions ></a>
  </div>


  <div class="space-y-4">
      <?php foreach ($transaction as $valeur): ?>
          <div class="flex items-center justify-between py-3 border-b border-gray-100">
              <div class="flex items-center">
                  <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center mr-4">
                      <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                      </svg>
                  </div>
                  <div>
                      <p class="font-medium text-gray-800"><?= $valeur['type'] ?></p>
                      <p class="text-sm text-gray-600"><?= $valeur['date'] ?> • <?= $valeur['compte_id'] ?></p>
                  </div>
              </div>
              <div class="text-right">
                  <p class="font-semibold text-green-600"><?= $valeur['montant'] ?> CFA</p>
                  <p class="text-xs text-gray-500"><?= date('H:i', strtotime($valeur['date'])) ?></p>
              </div>
          </div>
      <?php endforeach; ?>
  </div>
       
      
  </div>
</div>
