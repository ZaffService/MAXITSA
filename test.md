1. **`routes/route.web.php`**:

1. J'ai ajouté une nouvelle entrée pour la clé `/comptes`.
2. Elle pointe vers le `UserController` et une nouvelle action appelée `listAccounts`.
3. Le middleware `auth` est appliqué pour s'assurer que seuls les utilisateurs connectés peuvent accéder à cette page.
4. J'ai également ajouté une route `/ajouter-compte` qui pointera vers `addAccountForm` dans le `UserController`. Cela anticipe le bouton "Ajouter un compte" sur la page de liste.



2. **`src/controller/UserController.php`**:

1. J'ai ajouté la méthode `listAccounts()`.
2. Cette méthode vérifie si l'utilisateur est connecté.
3. Elle utilise `CompteService` pour récupérer la liste des comptes associés à l'utilisateur actuel.
4. Enfin, elle appelle `render('auth/list-accounts.php', ['comptes' => $comptes])` pour afficher le nouveau template, en lui passant les données des comptes.
5. J'ai aussi ajouté une méthode `addAccountForm()` qui est un placeholder pour le moment, mais qui sera utilisée pour afficher le formulaire d'ajout de compte.



3. **`templates/auth/list-accounts.php`**:

1. C'est le nouveau fichier de template que j'ai créé.
2. Il inclut le `dashboard-header.php` pour maintenir la cohérence du layout.
3. Il y a un titre "Mes Comptes" et le bouton "Ajouter un compte" qui pointe vers `/ajouter-compte`.
4. J'ai inclus une boucle `foreach` pour afficher les comptes passés par le contrôleur. Chaque compte est affiché dans une carte (`div` avec des classes Tailwind pour le style).
5. Si aucun compte n'est trouvé, un message s'affiche.





Maintenant, lorsque vous cliquerez sur "Voir mes comptes" depuis le tableau de bord, votre application devrait vous rediriger vers la page `/comptes` et afficher la liste des comptes de l'utilisateur connecté.