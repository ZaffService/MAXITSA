<?php $title = 'Mes Comptes'; ?>

<div class="flex flex-col min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-100 dark:from-gray-900 dark:via-blue-900 dark:to-indigo-900">
  <?php include __DIR__ . '/../layout/partial/dashboard-header.php'; ?>
  
  <main class="flex-1 p-6 md:p-10">
    <div class="max-w-7xl mx-auto">
      <!-- Header avec animation -->
      <div class="flex items-center justify-between mb-8 animate-fade-in">
        <div class="space-y-2">
          <h1 class="text-4xl font-bold">
            Mes Comptes
          </h1>
          <p class="text-gray-600 dark:text-gray-300">Gérez vos comptes</p>
        </div>
        
        <a href="/ajouter-compte" class="group relative inline-flex items-center justify-center px-6 py-3 overflow-hidden font-medium text-white transition-all duration-300 ease-out border-2 border-maxitsa-orange rounded-full hover:bg-maxitsa-orange hover:border-maxitsa-orange focus:outline-none focus:ring-2 focus:ring-maxitsa-orange focus:ring-offset-2 transform hover:scale-105 hover:shadow-lg">
            <span class="absolute inset-0 w-full h-full bg-gradient-to-r from-maxitsa-orange to-orange-600 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></span>
            <span class="absolute inset-0 w-full h-full bg-maxitsa-orange opacity-0 group-hover:opacity-100 transition-opacity duration-300"></span>
            <span class="relative flex items-center gap-2 text-maxitsa-orange group-hover:text-white">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                Ajouter un compte
            </span>
        </a>
      </div>

      <!-- Section des comptes -->
      <div class="space-y-6">
        <h2 class="text-2xl font-semibold text-gray-900 dark:text-white">Vos comptes</h2>
        
        <!-- Compte Principal -->
        <div class="group bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
            <div class="p-6">
              <div class="flex items-center justify-between mb-4">
                <div class="flex items-center space-x-3">
                  <div class="p-2 bg-maxitsa-orange rounded-lg">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                  </div>
                  <div>
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">Compte principal</h3>
                  </div>
                </div>
                <div class="text-right">
                  <div class="text-2xl font-bold text-gray-900 dark:text-white"> 100.000 </div>
                  <div class="text-sm text-red-600 dark:text-red-400 flex items-center justify-end">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    </svg>
                  </div>
                </div>
              </div>
              
              <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-3 mb-4">
                <p class="text-sm text-gray-600 dark:text-gray-300">
                  <span class="font-medium">N° de compte:</span> •••• •••• •••• 9156
                </p>
              </div>
              
              <div class="flex space-x-2">
                <button class="flex-1 bg-maxitsa-orange text-white font-medium py-2 px-4 rounded-lg hover:bg-orange-600 transition-colors duration-200">
                  Voir détails
                </button>
                <button class="flex-1 bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 font-medium py-2 px-4 rounded-lg hover:bg-gray-300 dark:hover:bg-gray-600 transition-colors duration-200">
                  Historique
                </button>
              </div>
            </div>
          </div>

          <!-- Compte Secondaire -->
          <div class="group bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
            <div class="p-6">
              <div class="flex items-center justify-between mb-4">
                <div class="flex items-center space-x-3">
                  <div class="p-2 bg-maxitsa-orange rounded-lg">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                  </div>
                  <div>
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">Compte secondaire</h3>
                  </div>
                </div>
                <div class="text-right">
                  <div class="text-2xl font-bold text-gray-900 dark:text-white"> 100.000 </div>
                  <div class="text-sm text-red-600 dark:text-red-400 flex items-center justify-end">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    </svg>
                  </div>
                </div>
              </div>
              
              <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-3 mb-4">
                <p class="text-sm text-gray-600 dark:text-gray-300">
                  <span class="font-medium">N° de compte:</span> •••• •••• •••• 9156
                </p>
              </div>
              
              <div class="flex space-x-2">
                <button class="flex-1 bg-maxitsa-orange text-white font-medium py-2 px-4 rounded-lg hover:bg-orange-600 transition-colors duration-200">
                  Voir détails
                </button>
                <button class="flex-1 bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 font-medium py-2 px-4 rounded-lg hover:bg-gray-300 dark:hover:bg-gray-600 transition-colors duration-200">
                  Historique
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>
</div>

<style>
@keyframes fade-in {
  from {
    opacity: 0;
    transform: translateY(20px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

.animate-fade-in {
  animation: fade-in 0.6s ease-out;
}

/* Effet de glassmorphisme pour les cartes */
.glass-card {
  backdrop-filter: blur(10px);
  background: rgba(255, 255, 255, 0.1);
  border: 1px solid rgba(255, 255, 255, 0.2);
}

/* Animation pour les boutons */
.btn-animate {
  position: relative;
  overflow: hidden;
}

.btn-animate::before {
  content: '';
  position: absolute;
  top: 0;
  left: -100%;
  width: 100%;
  height: 100%;
  background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
  transition: left 0.5s;
}

.btn-animate:hover::before {
  left: 100%;
}
</style>
