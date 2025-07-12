<?php
$title = 'Inscription - MAXITSA';
ob_start();
?>

<div class="bg-white rounded-2xl shadow-2xl overflow-hidden">
    <!-- En-tête -->
    <div class="bg-gradient-to-r from-maxitsa-orange to-orange-600 p-8 text-center text-white">
        <div class="w-16 h-16 bg-white bg-opacity-20 rounded-full flex items-center justify-center mx-auto mb-4">
            <span class="text-white text-2xl font-bold">M</span>
        </div>
        <h1 class="text-3xl font-bold mb-2">Créer votre compte MAXITSA</h1>
        <p class="opacity-90">Rejoignez des milliers d'utilisateurs qui font confiance à MAXITSA</p>
    </div>
    
    <div class="p-8 md:p-12">
        <!-- Messages -->
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
        
        <form method="POST" action="<?= url('register') ?>" enctype="multipart/form-data" class="space-y-6">
            <input type="hidden" name="csrf_token" value="<?= csrf_token() ?>">
            
            <!-- Informations personnelles -->
            <div class="bg-gray-50 p-6 rounded-lg">
                <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-maxitsa-orange" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                    Informations personnelles
                </h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-gray-700 text-sm font-semibold mb-2">Prénom(s)</label>
                        <input 
                            type="text" 
                            name="prenom" 
                            value="<?= escape($_POST['prenom'] ?? '') ?>"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-maxitsa-orange focus:border-transparent transition-colors"
                            placeholder="Entrez votre prénom(s)"
                        >
                        <?php if (isset($errors['prenom'])): ?>
                            <p class="text-red-500 text-sm mt-1"><?= escape($errors['prenom']) ?></p>
                        <?php endif; ?>
                    </div>
                    
                    <div>
                        <label class="block text-gray-700 text-sm font-semibold mb-2">Nom</label>
                        <input 
                            type="text" 
                            name="nom" 
                            value="<?= escape($_POST['nom'] ?? '') ?>"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-maxitsa-orange focus:border-transparent transition-colors"
                            placeholder="Entrez votre nom"
                        >
                        <?php if (isset($errors['nom'])): ?>
                            <p class="text-red-500 text-sm mt-1"><?= escape($errors['nom']) ?></p>
                        <?php endif; ?>
                    </div>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                    <div>
                        <label class="block text-gray-700 text-sm font-semibold mb-2">Adresse</label>
                        <input 
                            type="text" 
                            name="adresse" 
                            value="<?= escape($_POST['adresse'] ?? '') ?>"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-maxitsa-orange focus:border-transparent transition-colors"
                            placeholder="Entrez votre adresse"
                        >
                        <?php if (isset($errors['adresse'])): ?>
                            <p class="text-red-500 text-sm mt-1"><?= escape($errors['adresse']) ?></p>
                        <?php endif; ?>
                    </div>
                    
                    <div>
                        <label class="block text-gray-700 text-sm font-semibold mb-2">Téléphone</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <span class="text-gray-500 text-sm">+221</span>
                            </div>
                            <input 
                                type="tel" 
                                name="telephone" 
                                value="<?= escape($_POST['telephone'] ?? '') ?>"
                                class="w-full pl-12 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-maxitsa-orange focus:border-transparent transition-colors"
                                placeholder="77 123 45 67"
                            >
                        </div>
                        <?php if (isset($errors['telephone'])): ?>
                            <p class="text-red-500 text-sm mt-1"><?= escape($errors['telephone']) ?></p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            
            <!-- Sécurité -->
            <div class="bg-gray-50 p-6 rounded-lg">
                <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-maxitsa-orange" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                    </svg>
                    Sécurité et identification
                </h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-gray-700 text-sm font-semibold mb-2">Mot de passe</label>
                        <input 
                            type="password" 
                            name="password" 
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-maxitsa-orange focus:border-transparent transition-colors"
                            placeholder="Entrez votre mot de passe"
                        >
                        <?php if (isset($errors['password'])): ?>
                            <p class="text-red-500 text-sm mt-1"><?= escape($errors['password']) ?></p>
                        <?php endif; ?>
                    </div>
                    
                    <div>
                        <label class="block text-gray-700 text-sm font-semibold mb-2">Numéro d'identité</label>
                        <input 
                            type="text" 
                            name="numero_identite" 
                            value="<?= escape($_POST['numero_identite'] ?? '') ?>"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-maxitsa-orange focus:border-transparent transition-colors"
                            placeholder="Numéro de carte d'identité"
                        >
                        <?php if (isset($errors['numero_identite'])): ?>
                            <p class="text-red-500 text-sm mt-1"><?= escape($errors['numero_identite']) ?></p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            
            <!-- Upload des pièces -->
            <div class="bg-gray-50 p-6 rounded-lg">
                <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-maxitsa-orange" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    Pièces justificatives
                </h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-gray-700 text-sm font-semibold mb-2">Recto</label>
                        <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-maxitsa-orange transition-colors cursor-pointer">
                            <input type="file" name="photo_recto" accept="image/*" class="hidden" id="recto">
                            <label for="recto" class="cursor-pointer">
                                <div class="w-12 h-12 bg-gray-100 rounded-lg mx-auto mb-3 flex items-center justify-center">
                                    <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                                <p class="text-gray-600 text-sm font-medium">Cliquez pour uploader</p>
                                <p class="text-gray-400 text-xs mt-1">PNG, JPG jusqu'à 2MB</p>
                            </label>
                        </div>
                    </div>
                    
                    <div>
                        <label class="block text-gray-700 text-sm font-semibold mb-2">Verso</label>
                        <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-maxitsa-orange transition-colors cursor-pointer">
                            <input type="file" name="photo_verso" accept="image/*" class="hidden" id="verso">
                            <label for="verso" class="cursor-pointer">
                                <div class="w-12 h-12 bg-gray-100 rounded-lg mx-auto mb-3 flex items-center justify-center">
                                    <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                                <p class="text-gray-600 text-sm font-medium">Cliquez pour uploader</p>
                                <p class="text-gray-400 text-xs mt-1">PNG, JPG jusqu'à 2MB</p>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Bouton d'inscription -->
            <button 
                type="submit" 
                class="w-full bg-maxitsa-orange text-white py-4 rounded-lg font-semibold hover:bg-opacity-90 transition-colors transform hover:scale-105 text-lg"
            >
                Créer mon compte MAXITSA
            </button>
            
            <!-- Lien vers connexion -->
            <div class="text-center pt-6 border-t border-gray-200">
                <span class="text-gray-600">Déjà un compte ? </span>
                <a href="<?= url('login') ?>" class="text-maxitsa-orange font-semibold hover:underline">Se connecter</a>
            </div>
        </form>
    </div>
</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layouts/security.layout.php';
?>
