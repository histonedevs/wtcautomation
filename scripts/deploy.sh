#!/usr/bin/env bash

echo "Deployment Started On : "
date

cd /var/www/html/WTCAutomation

git pull --no-edit
sudo chmod 777 -R storage
sudo chmod 777 -R bootstrap/cache
composer dump-autoload
composer install
php artisan migrate --force

echo "Deployment Ended On : "
date