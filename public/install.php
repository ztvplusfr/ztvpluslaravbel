<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$config = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Handle form submission
    if (isset($_POST['install'])) {
        $result = processInstallation($_POST);
        if ($result === true) {
            echo "<h2>Installation terminée!</h2>";
            echo "<p>Vérifiez les logs ci-dessous.</p>";
        } else {
            echo "<h2>Erreur lors de l'installation:</h2>";
            echo "<pre>" . $result . "</pre>";
        }
    } else {
        // Update .env file
        updateEnv($_POST);
        echo "<h2>Fichier .env mis à jour!</h2>";
        echo "<p>Vous pouvez maintenant procéder à l'installation en cliquant sur le bouton ci-dessous.</p>";
        showInstallForm();
    }
} else {
    // Load current .env values
    $parseFile = function ($file) {
        if (!file_exists($file)) return [];
        $contents = file_get_contents($file);
        $lines = explode("\n", $contents);
        $config = [];
        foreach ($lines as $line) {
            if (str_contains($line, '=')) {
                [$key, $value] = explode('=', $line, 2);
                $config[trim($key)] = trim($value);
            }
        }
        return $config;
    };

    $config = $parseFile('.env');

    // Check if .env exists, copy from .env.example if not
    if (!file_exists('.env')) {
        if (file_exists('.env.example')) {
            copy('.env.example', '.env');
            $config = $parseFile('.env.example');
            echo "<p>Fichier .env crée à partir de .env.example</p>";
        }
    }

    showConfigForm($config);
}

function showConfigForm($config) {
    ?>
    <!DOCTYPE html>
    <html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Configuration Laravel</title>
        <style>
            body { font-family: Arial, sans-serif; background-color: #f4f4f4; margin: 0; padding: 20px; }
            .container { max-width: 800px; margin: 0 auto; background: white; padding: 30px; border-radius: 10px; box-shadow: 0 0 20px rgba(0,0,0,0.1); }
            .form-group { margin-bottom: 20px; }
            label { display: block; margin-bottom: 5px; font-weight: bold; }
            input[type="text"], input[type="email"], input[type="password"] { width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; }
            .grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
            button { background: #007bff; color: white; padding: 12px 30px; border: none; border-radius: 4px; cursor: pointer; font-size: 16px; }
            button:hover { background: #0056b3; }
            .help { font-size: 12px; color: #666; margin-top: 5px; }
        </style>
    </head>
    <body>
        <div class="container">
            <h1>Configuration du Projet Laravel</h1>
            <p>Remplissez les informations suivantes pour configurer votre projet :</p>

            <form method="POST">
                <div class="grid">
                    <div class="form-group">
                        <label for="APP_NAME">Nom de l'application *</label>
                        <input type="text" id="APP_NAME" name="APP_NAME" value="<?php echo htmlspecialchars($config['APP_NAME'] ?? 'Laravel'); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="APP_URL">URL de l'application *</label>
                        <input type="text" id="APP_URL" name="APP_URL" value="<?php echo htmlspecialchars($config['APP_URL'] ?? 'http://localhost'); ?>" required>
                        <div class="help">Exemple: https://votre-domaine.com</div>
                    </div>
                </div>

                <h3>Configuration Base de Données</h3>
                <div class="grid">
                    <div class="form-group">
                        <label for="DB_HOST">Hôte DB *</label>
                        <input type="text" id="DB_HOST" name="DB_HOST" value="<?php echo htmlspecialchars($config['DB_HOST'] ?? '127.0.0.1'); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="DB_PORT">Port DB *</label>
                        <input type="text" id="DB_PORT" name="DB_PORT" value="<?php echo htmlspecialchars($config['DB_PORT'] ?? '3306'); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="DB_DATABASE">Nom DB *</label>
                        <input type="text" id="DB_DATABASE" name="DB_DATABASE" value="<?php echo htmlspecialchars($config['DB_DATABASE'] ?? ''); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="DB_USERNAME">Utilisateur DB</label>
                        <input type="text" id="DB_USERNAME" name="DB_USERNAME" value="<?php echo htmlspecialchars($config['DB_USERNAME'] ?? 'root'); ?>">
                    </div>
                    <div class="form-group">
                        <label for="DB_PASSWORD">Mot de passe DB</label>
                        <input type="password" id="DB_PASSWORD" name="DB_PASSWORD" value="<?php echo htmlspecialchars($config['DB_PASSWORD'] ?? ''); ?>">
                    </div>
                </div>

                <h3>Clés API</h3>
                <div class="form-group">
                    <label for="TMDB_API_KEY">Clé TMDB *</label>
                    <input type="text" id="TMDB_API_KEY" name="TMDB_API_KEY" value="<?php echo htmlspecialchars($config['TMDB_API_KEY'] ?? ''); ?>" required>
                    <div class="help">Obtenez une clé sur https://www.themoviedb.org/settings/api</div>
                </div>

                <div class="grid">
                    <div class="form-group">
                        <label for="GOOGLE_CLIENT_ID">Google Client ID (optionnel)</label>
                        <input type="text" id="GOOGLE_CLIENT_ID" name="GOOGLE_CLIENT_ID" value="<?php echo htmlspecialchars($config['GOOGLE_CLIENT_ID'] ?? ''); ?>">
                    </div>
                    <div class="form-group">
                        <label for="GOOGLE_CLIENT_SECRET">Google Client Secret (optionnel)</label>
                        <input type="text" id="GOOGLE_CLIENT_SECRET" name="GOOGLE_CLIENT_SECRET" value="<?php echo htmlspecialchars($config['GOOGLE_CLIENT_SECRET'] ?? ''); ?>">
                    </div>
                </div>

                <h3>Email Configuration</h3>
                <div class="grid">
                    <div class="form-group">
                        <label for="MAIL_USERNAME">Email utilisateur</label>
                        <input type="email" id="MAIL_USERNAME" name="MAIL_USERNAME" value="<?php echo htmlspecialchars($config['MAIL_USERNAME'] ?? ''); ?>">
                    </div>
                    <div class="form-group">
                        <label for="MAIL_PASSWORD">Mot de passe email</label>
                        <input type="password" id="MAIL_PASSWORD" name="MAIL_PASSWORD" value="<?php echo htmlspecialchars($config['MAIL_PASSWORD'] ?? ''); ?>">
                    </div>
                </div>

                <button type="submit">Sauvegarder la configuration</button>
            </form>
        </div>
    </body>
    </html>
    <?php
}

function showInstallForm() {
    ?>
    <!DOCTYPE html>
    <html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Installation Laravel</title>
        <style>
            body { font-family: Arial, sans-serif; background-color: #f4f4f4; margin: 0; padding: 20px; }
            .container { max-width: 800px; margin: 0 auto; background: white; padding: 30px; border-radius: 10px; box-shadow: 0 0 20px rgba(0,0,0,0.1); }
            button { background: #28a745; color: white; padding: 12px 30px; border: none; border-radius: 4px; cursor: pointer; font-size: 16px; margin: 10px; }
            button:hover { background: #218838; }
            pre { background: #f8f9fa; padding: 15px; border-radius: 4px; overflow-x: auto; }
        </style>
    </head>
    <body>
        <div class="container">
            <h1>Installation du Projet</h1>

            <form method="POST">
                <input type="hidden" name="install" value="1">
                <p><strong>ATTENTION:</strong> Assurez-vous que votre base de données est créée et accessible.</p>
                <p>Ce script va exécuter :</p>
                <ul>
                    <li>Génération de la clé d'application</li>
                    <li>Création du lien de stockage</li>
                    <li>Exécution des migrations</li>
                    <li>Création des tables dans la DB</li>
                </ul>
                <button type="submit">Lancer l'installation</button>
            </form>

            <hr>
            <p><strong>Ou exécutez manuellement ces commandes dans un terminal/SSH :</strong></p>
            <pre>
cd /path/to/your/project
php artisan key:generate
php artisan migrate
php artisan storage:link
            </pre>
        </div>
    </body>
    </html>
    <?php
}

function updateEnv($data) {
    $envPath = '.env';

    if (!file_exists($envPath)) {
        copy('.env.example', $envPath);
    }

    $envContent = file_get_contents($envPath);

    $envVars = [
        'APP_NAME',
        'APP_URL',
        'DB_HOST',
        'DB_PORT',
        'DB_DATABASE',
        'DB_USERNAME',
        'DB_PASSWORD',
        'TMDB_API_KEY',
        'GOOGLE_CLIENT_ID',
        'GOOGLE_CLIENT_SECRET',
        'MAIL_USERNAME',
        'MAIL_PASSWORD'
    ];

    foreach ($envVars as $var) {
        if (isset($data[$var])) {
            $envContent = preg_replace("/^{$var}=.*$/m", "{$var}={$data[$var]}", $envContent);
        }
    }

    // Set production defaults
    $envContent = preg_replace("/^APP_ENV=.*$/m", "APP_ENV=production", $envContent);
    $envContent = preg_replace("/^APP_DEBUG=.*$/m", "APP_DEBUG=false", $envContent);

    file_put_contents($envPath, $envContent);
}

function processInstallation($data) {
    $output = "Démarrage de l'installation...\n\n";

    // Check if we can execute commands
    if (!function_exists('exec')) {
        $output .= "ERREUR: exec() est désactivé sur ce serveur. Veuillez exécuter manuellement les commandes suivantes dans un terminal:\n" .
                   "cd /path/to/project\n" .
                   "php artisan key:generate\n" .
                   "php artisan migrate --force\n" .
                   "php artisan storage:link\n";
        return $output;
    }

    // Change working directory to project root
    chdir(dirname($_SERVER['DOCUMENT_ROOT'] . '/../../../'));

    // Generate app key
    exec('php artisan key:generate 2>&1', $outputKey, $returnKey);
    $output .= "Génération de la clé d'application:\n" . implode("\n", $outputKey) . "\n";
    if ($returnKey !== 0) $output .= " - ERREUR: Code de retour $returnKey\n";

    // Run migrations
    exec('php artisan migrate --force 2>&1', $outputMigrate, $returnMigrate);
    $output .= "\nMigration de la base de données:\n" . implode("\n", $outputMigrate) . "\n";
    if ($returnMigrate !== 0) $output .= " - ERREUR: Code de retour $returnMigrate\n";

    // Create storage link
    exec('php artisan storage:link 2>&1', $outputLink, $returnLink);
    $output .= "\nCréation du lien de stockage:\n" . implode("\n", $outputLink) . "\n";
    if ($returnLink !== 0) $output .= " - ERREUR: Code de retour $returnLink\n";

    $output .= "\nInstallation terminée.\n";
    return $output;
}
?>
