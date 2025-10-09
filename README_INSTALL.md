# Installation Script for Laravel Project

## Description
A PHP-based installer script (`public/install.php`) that allows you to configure and install a Laravel project via web browser interface. No SSH required if exec() is enabled on the server.

## Features
- Web-based configuration form for:
  - Application name and URL
  - Database settings
  - TMDB API key
  - Google APIs (optional)
  - Email configuration
- Automatic .env file creation/update
- Installation process with artisan commands execution
- Fallback to manual commands if exec() is disabled

## Usage

### 1. Upload files to your cPanel
- Upload all Laravel project files
- Place the `public/` folder contents in your domain's document root

### 2. Run the installer
- Visit `http://your-domain.com/install.php`
- Fill out the configuration form
- Click "Sauvegarder la configuration"
- Then click "Lancer l'installation"

### 3. Complete setup
- The script will attempt to run the necessary Laravel commands
- If exec() is disabled (common on cPanel), follow the manual instructions provided

## Requirements
- PHP 8.1+
- MySQL/MariaDB database
- File system write permissions
- Optionally: SSH access if manual installation is needed

## Security Notes
- Delete `public/install.php` after installation
- Set proper file permissions on production
- Ensure .env file is not publicly accessible
