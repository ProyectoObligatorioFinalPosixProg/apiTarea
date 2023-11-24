#!/bin/bash
composer install
echo "Copiando .env.example a .env..."
cp .env.example .env
echo "Generando clave de aplicación..."
php artisan key:generate
