#!/bin/bash
echo "=== Setup CuraLab ==="

# Installa le estensioni PHP necessarie per Laravel
sudo apt-get install -y php8.2-mbstring php8.2-xml php8.2-curl php8.2-mysql php8.2-zip php8.2-bcmath

# Installa le dipendenze del progetto
cd /workspaces/Progetto-CuraLab/backend
php /usr/local/bin/composer install --no-interaction

# Crea il file .env con la configurazione di base
cat > .env << 'ENVEOF'
APP_NAME=CuraLab
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://localhost

LOG_CHANNEL=stack

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=curalab
DB_USERNAME=curalab
DB_PASSWORD=curalab

SESSION_DRIVER=database
SESSION_LIFETIME=120

CACHE_STORE=database

MAIL_MAILER=log
ENVEOF

# Genera la chiave dell'applicazione
php artisan key:generate

# Crea il database e l'utente MySQL dedicato
sudo mysql -e "CREATE DATABASE IF NOT EXISTS curalab CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
sudo mysql -e "CREATE USER IF NOT EXISTS 'curalab'@'localhost' IDENTIFIED BY 'curalab';"
sudo mysql -e "GRANT ALL PRIVILEGES ON curalab.* TO 'curalab'@'localhost';"
sudo mysql -e "FLUSH PRIVILEGES;"

echo "=== Setup completato! ==="
