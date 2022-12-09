<?php

declare(strict_types=1);

return [
    'admin' => [
        'email' => env('SEED_ADMIN_EMAIL', 'admin@admin.com'),
        'password' => env('SEED_ADMIN_PASSWORD', 'password'),
    ],
    'tenants' => [
        '1_name' => env('SEED_TENANTS_1_NAME', 'Tenant 1'),
        '1_slug' => env('SEED_TENANTS_1_SLUG', 'tenant-1'),
        '2_name' => env('SEED_TENANTS_2_NAME', 'Tenant 2'),
        '2_slug' => env('SEED_TENANTS_2_SLUG', 'tenant-2'),
    ],
    'domains' => [
        '1_tenant_1_domain' => env('SEED_TENANT_1_DOMAINS_1_DOMAIN', 'domain-1-tenant-1.localhost'),
        '1_tenant_2_domain' => env('SEED_TENANT_1_DOMAINS_2_DOMAIN', 'domain-2-tenant-1.localhost'),
        '2_tenant_1_domain' => env('SEED_TENANT_2_DOMAINS_1_DOMAIN', 'domain-1-tenant-2.localhost'),
        '2_tenant_2_domain' => env('SEED_TENANT_2_DOMAINS_2_DOMAIN', 'domain-2-tenant-2.localhost'),
    ]
];
