#!/usr/bin/env bash

cd /var/www/html/WTCAutomation

git pull
sudo chmod 777 -R storage
sudo chmod 777 -R bootstrap/cache
composer dump-autoload
composer install
php artisan migrate --force