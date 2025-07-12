<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'MAXITSA' ?></title>
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
<body class="bg-gray-50 min-h-screen">
    <?php if (isset($showHeader) && $showHeader): ?>
        <?php include __DIR__ . '/../partials/header.php'; ?>
    <?php endif; ?>
    
    <main class="<?= $mainClass ?? '' ?>">
        <?= $content ?>
    </main>
    
    <?php if (isset($showFooter) && $showFooter): ?>
        <?php include __DIR__ . '/../partials/footer.php'; ?>
    <?php endif; ?>

    <!-- Scripts -->
    <script>
        // Gestion des messages flash
        document.addEventListener('DOMContentLoaded', function() {
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
