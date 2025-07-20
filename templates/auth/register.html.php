<style>
    body {
        background: #f5f6fa;
        font-family: 'Segoe UI', Arial, sans-serif;
    }
    .register-container {
        max-width: 500px;
        margin: 40px auto;
        background: #fff;
        border-radius: 16px;
        box-shadow: 0 4px 24px rgba(0,0,0,0.08);
        padding: 32px 24px;
    }
    .register-header {
        background: #ff6a21;
        color: #fff;
        border-radius: 16px 16px 0 0;
        text-align: center;
        padding: 32px 0 16px 0;
        margin: -32px -24px 24px -24px;
    }
    .register-header .avatar {
        background: #fff;
        color: #ff6a21;
        border-radius: 50%;
        width: 48px;
        height: 48px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
        margin-bottom: 8px;
    }
    .section-title {
        font-weight: bold;
        margin: 24px 0 8px 0;
        color: #ff6a21;
        font-size: 1.1rem;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .form-row {
        display: flex;
        gap: 16px;
        margin-bottom: 16px;
    }
    .form-row input {
        width: 100%;
    }
    .form-group {
        margin-bottom: 16px;
    }
    label {
        font-size: 0.95rem;
        color: #333;
        margin-bottom: 4px;
        display: block;
    }
    input[type="text"], input[type="password"] {
        width: 100%;
        padding: 8px 12px;
        border: 1px solid #ddd;
        border-radius: 6px;
        font-size: 1rem;
        background: #fafafa;
    }
    input[type="file"] {
        border: none;
        background: none;
        font-size: 1rem;
    }
    .file-box {
        border: 2px dashed #ddd;
        border-radius: 8px;
        padding: 16px;
        text-align: center;
        background: #fafafa;
        margin-bottom: 8px;
    }
    button[type="submit"] {
        background: #ff6a21;
        color: #fff;
        border: none;
        border-radius: 8px;
        padding: 12px 0;
        width: 100%;
        font-size: 1.1rem;
        font-weight: bold;
        cursor: pointer;
        margin-top: 16px;
        transition: background 0.2s;
    }
    button[type="submit"]:hover {
        background: #e65c1a;
    }
</style>

<div class="register-container">
    <div class="register-header">
        <div class="avatar">M</div>
        <h2>Créer votre compte MAXITSA</h2>
        <p>Rejoignez des milliers d'utilisateurs qui font confiance à MAXITSA</p>
    </div>
    <?php if (!empty($errors)): ?>
        <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
            <ul>
                <?php foreach ($errors as $field => $error): ?>
                    <li><strong><?= htmlspecialchars($field) ?> :</strong> <?= htmlspecialchars($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>
    <?php if ($success): ?>
        <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
            Inscription réussie ! Votre compte a été créé.
        </div>
    <?php endif; ?>
    <form action="/register" method="POST" enctype="multipart/form-data">
        <div class="section-title">
            <span></span> Informations personnelles
        </div>
        <div class="form-row">
            <div class="form-group" style="flex:1;">
                <label for="prenom">Prénom(s)</label>
                <input type="text" name="prenom" id="prenom" placeholder="Entrez votre prénom(s)" required>
            </div>
            <div class="form-group" style="flex:1;">
                <label for="nom">Nom</label>
                <input type="text" name="nom" id="nom" placeholder="Entrez votre nom" required>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group" style="flex:1;">
                <label for="adresse">Adresse</label>
                <input type="text" name="adresse" id="adresse" placeholder="Entrez votre adresse" required>
            </div>
            <div class="form-group" style="flex:1;">
                <label for="login">Téléphone</label>
                <input type="text" name="login" id="login" placeholder="+221 77 123 45 67" required>
            </div>
        </div>
        <div class="section-title">
            <span></span> Sécurité et identification
        </div>
        <div class="form-row">
            <div class="form-group" style="flex:1;">
                <label for="password">Mot de passe</label>
                <input type="password" name="password" id="password" placeholder="Entrez votre mot de passe" required>
            </div>
            <div class="form-group" style="flex:1;">
                <label for="numeroidentite">Numéro d'identité</label>
                <input type="text" name="numeroidentite" id="numeroidentite" placeholder="Numéro de carte d'identité" required>
            </div>
        </div>
        <div class="section-title">
            <span></span> Pièces justificatives
        </div>
        <div class="form-row">
            <div class="form-group" style="flex:1;">
                <label for="photorecto">Recto</label>
                <div class="file-box">
                    <input type="file" name="photorecto" id="photorecto" accept="image/*" required>
                </div>
            </div>
            <div class="form-group" style="flex:1;">
                <label for="photoverso">Verso</label>
                <div class="file-box">
                    <input type="file" name="photoverso" id="photoverso" accept="image/*" required>
                </div>
            </div>
        </div>
        <button type="submit">Créer mon compte principal</button>
    </form>
</div>