#!/usr/bin/env bash

git pull
sudo chmod 777 -R storage
sudo chmod 777 bootstrap/cache
composer dump-autoload