<?php

return [
    'success.account.created' => 'Compte créé avec succès !',
    'success.login' => 'Connexion réussie',
    'error.invalid.credentials' => 'Identifiants incorrects',
    'error.phone.exists' => 'Ce numéro de téléphone existe déjà',
    'error.csrf.invalid' => 'Token CSRF invalide',
    'error.upload.failed' => 'Erreur lors de l\'upload',
    'error.validation.failed' => 'Données invalides',
    'validation.required' => 'Le champ :field est requis',
    'validation.email' => 'Le champ :field doit être un email valide',
    'validation.phone' => 'Le numéro de téléphone doit être au format sénégalais',
    'validation.cni' => 'Le numéro CNI doit être au format sénégalais',
    'error.upload.generic' => 'Une erreur inconnue est survenue lors de l\'upload du fichier',
    'error.upload.size' => 'Le fichier est trop volumineux (max : 2MB)',
    'error.upload.type' => 'Type de fichier non autorisé (JPG, PNG uniquement)',
    'error.upload.save' => 'Erreur lors de la sauvegarde du fichier',
    
    // Nouveaux messages pour les transactions
    'success.deposit' => 'Dépôt effectué avec succès !',
    'error.deposit.failed' => 'Échec du dépôt. Veuillez réessayer.',
    'error.invalid.amount' => 'Le montant doit être supérieur à zéro.',
    'error.account.not_found' => 'Compte introuvable.',
    'error.transaction.save_failed' => 'Erreur lors de l\'enregistrement de la transaction.',
    'error.transaction.fetch' => 'Erreur lors de la récupération des transactions.',
    'error.deposit.form_load' => 'Erreur lors du chargement du formulaire de dépôt.',
    'validation.min' => 'Le champ :field doit être au minimum de :min.',
];
