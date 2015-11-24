#!/usr/bin/env bash

cp .env.example .env
composer install
composer requrie predis/predis
php artisan key:generate
php artisan migrate:refresh --seed
