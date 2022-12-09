<?php

declare(strict_types=1);

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Stancl\Tenancy\Concerns\DealsWithMigrations;
use Stancl\Tenancy\Concerns\HasATenantsOption;
use Symfony\Component\Console\Input\InputOption;

final class DbDrop extends Command
{
    use HasATenantsOption, DealsWithMigrations;

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Drop database for tenant(s)';

    public function __construct()
    {
        parent::__construct();

        $this->setName('tenants:db-drop');
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        tenancy()->runForMultiple($this->option('tenants'), function ($tenant) {
            $this->info('Dropping database.');
            $this->dropDatabase('tenant', $tenant->tenancy_db_name);
        });

        $this->info('Done.');
    }

    /**
     * Drop the database.
     *
     * @param  string  $connection
     * @param  string  $database
     * @return void
     */
    protected function dropDatabase($connection, $database)
    {
        $this->laravel['db']->connection($connection)
            ->getSchemaBuilder()
            ->dropDatabaseIfExists($database);
    }
}
