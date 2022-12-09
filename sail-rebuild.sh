#!/bin/bash

sail artisan config:clear
sail artisan route:clear
sail artisan tenants:db-drop
sail artisan db:wipe
sail artisan migrate
sail artisan db:seed --class=VoyagerDatabaseSeeder
sail artisan tenants:migrate-fresh
sail artisan tenants:seed --class=Database\\Seeders\\Tenant\\VoyagerDatabaseSeeder
sail artisan config:clear
sail artisan route:clear
sail artisan responsecache:clear
sail artisan tenants:run responsecache:clear