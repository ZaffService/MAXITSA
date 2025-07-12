<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'MAXITSA - Authentification' ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'maxitsa-orange': '#FF6B35',
                        'maxitsa-dark': '#2D2D2D'
                    }
                }
            }
        }
    </script>
    <link rel="icon" type="image/x-icon" href="/favicon.ico">
</head>
<body class="bg-gradient-to-br from-gray-100 to-gray-200 min-h-screen flex items-center justify-center p-4">
    <!-- Background Pattern -->
    <div class="absolute inset-0 opacity-5">
        <div class="absolute inset-0" style="background-image: url('data:image/svg+xml,<svg width="60" height="60" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg"><g fill="none" fill-rule="evenodd"><g fill="%23000000" fill-opacity="0.1"><circle cx="30" cy="30" r="2"/></g></svg>');"></div>
    </div>
    
    <div class="w-full max-w-2xl relative z-10">
        <?= $content ?>
    </div>

    <!-- Scripts de sécurité -->
    <script>
        // Protection contre les attaques XSS
        document.addEventListener('DOMContentLoaded', function() {
            // Désactiver le clic droit en production
            <?php if (!APP_DEBUG): ?>
            document.addEventListener('contextmenu', e => e.preventDefault());
            <?php endif; ?>
            
            // Gestion des messages flash
            const alerts = document.querySelectorAll('[data-alert]');
            alerts.forEach(alert => {
                setTimeout(() => {
                    alert.style.opacity = '0';
                    setTimeout(() => alert.remove(), 300);
                }, 5000);
            });
        });
    </script>
</body>
</html>
