@echo off
php artisan migrate:refresh
php artisan db:seed --class=TareaDatabaseSeed
php artisan test