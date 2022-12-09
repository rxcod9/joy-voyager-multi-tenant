#!/bin/bash

./vendor/bin/sail artisan config:clear
./vendor/bin/sail artisan route:clear
./vendor/bin/sail artisan tenants:db-drop
./vendor/bin/sail artisan db:wipe
./vendor/bin/sail artisan migrate
./vendor/bin/sail artisan db:seed --class=VoyagerDatabaseSeeder
./vendor/bin/sail artisan tenants:migrate-fresh
./vendor/bin/sail artisan tenants:seed --class=Database\\Seeders\\Tenant\\VoyagerDatabaseSeeder
./vendor/bin/sail artisan config:clear
./vendor/bin/sail artisan route:clear
./vendor/bin/sail artisan responsecache:clear
./vendor/bin/sail artisan tenants:run responsecache:clear