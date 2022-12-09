#!/bin/bash

php artisan config:clear
php artisan route:clear
php artisan tenants:db-drop
php artisan db:wipe
php artisan migrate
php artisan db:seed --class=VoyagerDatabaseSeeder
php artisan tenants:migrate-fresh
php artisan tenants:seed --class=Database\\Seeders\\Tenant\\VoyagerDatabaseSeeder
php artisan config:clear
php artisan route:clear
php artisan responsecache:clear
php artisan tenants:run responsecache:clear