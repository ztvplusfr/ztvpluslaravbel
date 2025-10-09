<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\File;

class InstallController extends Controller
{
    /**
     * Page d'accueil de l'installeur
     */
    public function welcome()
    {
        // Vérifier si l'application est déjà installée
        if ($this->isInstalled()) {
            return redirect('/login');
        }

        // Vérifications de l'environnement
        $checks = $this->checkEnvironment();

        return view('install.welcome', compact('checks'));
    }

    /**
     * Formulaire de configuration
     */
    public function configure(Request $request)
    {
        // Vérifier si l'application est déjà installée
        if ($this->isInstalled()) {
            return redirect('/login');
        }

        return view('install.configure');
    }

    /**
     * Traitement de la configuration
     */
    public function saveConfig(Request $request)
    {
        // Vérifier si l'application est déjà installée
        if ($this->isInstalled()) {
            return redirect('/login');
        }

        // Validation des données
        $validated = $request->validate([
            'db_name' => 'required|string|max:255',
            'db_user' => 'required|string|max:255',
            'db_password' => 'nullable|string',
            'site_name' => 'required|string|max:255',
            'admin_email' => 'required|email|max:255',
            'admin_password' => 'required|string|min:8',
        ]);

        // Sauvegarde dans le fichier .env
        $this->updateEnvFile([
            'DB_DATABASE' => $validated['db_name'],
            'DB_USERNAME' => $validated['db_user'],
            'DB_PASSWORD' => $validated['db_password'] ?? '',
            'APP_NAME' => $validated['site_name'],
            'ADMIN_EMAIL' => $validated['admin_email'],
            'ADMIN_PASSWORD' => $validated['admin_password'],
        ]);

        // Test de connexion à la base de données
        try {
            DB::connection()->getPdo();
        } catch (\Exception $e) {
            return back()->withInput()->withErrors(['db_connection' => 'Impossible de se connecter à la base de données. Vérifiez les paramètres.']);
        }

        // Redirection vers l'installation
        return redirect('/install/install');
    }

    /**
     * Installation de la base de données et finalisation
     */
    public function install(Request $request)
    {
        // Vérifier si l'application est déjà installée
        if ($this->isInstalled()) {
            return redirect('/login');
        }

        try {
            // Génère la clé d'application si elle n'existe pas
            if (empty(config('app.key'))) {
                Artisan::call('key:generate');
            }

            // Exécute les migrations
            Artisan::call('migrate', ['--force' => true]);

            // Exécute les seeders
            Artisan::call('db:seed', ['--force' => true]);

            // Crée le compte administrateur
            $this->createAdminUser();

            // Crée le fichier d'installation terminée ou ajoute la variable env
            $this->markAsInstalled();

            // Redirection finale
            return redirect('/login')->with(['success' => 'Installation terminée avec succès !']);

        } catch (\Exception $e) {
            return back()->withErrors(['install_error' => 'Erreur lors de l\'installation : ' . $e->getMessage()]);
        }
    }

    /**
     * Vérifie si l'application est installée
     */
    private function isInstalled()
    {
        return File::exists(storage_path('installed')) || env('APP_INSTALLED') === 'true';
    }

    /**
     * Met à jour le fichier .env
     */
    private function updateEnvFile(array $data)
    {
        $envPath = base_path('.env');

        if (!File::exists($envPath)) {
            File::copy('.env.example', $envPath);
        }

        $envContent = File::get($envPath);

        foreach ($data as $key => $value) {
            $envContent = preg_replace("/^{$key}=.*$/m", "{$key}={$value}", $envContent);
        }

        File::put($envPath, $envContent);
    }

    /**
     * Crée le compte administrateur
     */
    private function createAdminUser()
    {
        $adminEmail = env('ADMIN_EMAIL');
        $adminPassword = env('ADMIN_PASSWORD');

        if ($adminEmail && $adminPassword) {
            User::create([
                'name' => 'Administrateur',
                'email' => $adminEmail,
                'password' => Hash::make($adminPassword),
                'role' => 'admin',
            ]);
        }
    }

    /**
     * Marque l'application comme installée
     */
    private function markAsInstalled()
    {
        // Crée un fichier storage/installed
        File::put(storage_path('installed'), 'installed');

        // Ou ajoute APP_INSTALLED=true dans .env
        $this->updateEnvFile(['APP_INSTALLED' => 'true']);
    }

    /**
     * Vérifications de l'environnement système
     */
    private function checkEnvironment()
    {
        return [
            'php_version' => [
                'name' => 'Version de PHP',
                'status' => version_compare(PHP_VERSION, '8.1', '>='),
                'message' => 'PHP ' . PHP_VERSION,
                'required' => '8.1+',
            ],
            'pdo' => [
                'name' => 'Extension PDO',
                'status' => extension_loaded('pdo'),
                'message' => extension_loaded('pdo') ? 'Disponible' : 'Indisponible',
                'required' => 'Requis',
            ],
            'mbstring' => [
                'name' => 'Extension mbstring',
                'status' => extension_loaded('mbstring'),
                'message' => extension_loaded('mbstring') ? 'Disponible' : 'Indisponible',
                'required' => 'Requis',
            ],
            'openssl' => [
                'name' => 'Extension openssl',
                'status' => extension_loaded('openssl'),
                'message' => extension_loaded('openssl') ? 'Disponible' : 'Indisponible',
                'required' => 'Requis',
            ],
            'tokenizer' => [
                'name' => 'Extension tokenizer',
                'status' => extension_loaded('tokenizer'),
                'message' => extension_loaded('tokenizer') ? 'Disponible' : 'Indisponible',
                'required' => 'Requis',
            ],
            'xml' => [
                'name' => 'Extension xml',
                'status' => extension_loaded('xml'),
                'message' => extension_loaded('xml') ? 'Disponible' : 'Indisponible',
                'required' => 'Requis',
            ],
            'curl' => [
                'name' => 'Extension curl',
                'status' => extension_loaded('curl'),
                'message' => extension_loaded('curl') ? 'Disponible' : 'Indisponible',
                'required' => 'Requis',
            ],
            'storage_permissions' => [
                'name' => 'Permissions storage/',
                'status' => is_writable(storage_path()),
                'message' => is_writable(storage_path()) ? 'Écriture possible' : 'Écriture impossible',
                'required' => 'Requis',
            ],
            'bootstrap_permissions' => [
                'name' => 'Permissions bootstrap/cache/',
                'status' => is_writable(base_path('bootstrap/cache')),
                'message' => is_writable(base_path('bootstrap/cache')) ? 'Écriture possible' : 'Écriture impossible',
                'required' => 'Requis',
            ],
        ];
    }
}
