<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Dashboard - MAXITSA' ?></title>
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
</head>
<body class="bg-gray-50">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <?php include __DIR__ . '/../partials/sidebar.php'; ?>
        
        <!-- Main Content -->
        <div class="flex-1 flex flex-col">
            <!-- Header -->
            <?php include __DIR__ . '/../partials/dashboard-header.php'; ?>
            
            <!-- Content -->
            <main class="flex-1 p-6 overflow-y-auto">
                <?= $content ?>
            </main>
        </div>
    </div>
</body>
</html>
