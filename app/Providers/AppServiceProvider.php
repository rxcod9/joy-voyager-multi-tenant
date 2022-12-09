<?php

namespace App\Providers;

use App\Console\Commands;
use App\Facades\TenantVoyager as TenantVoyagerFacade;
use App\Http\Middleware\TenantVoyagerAdminMiddleware;
use App\Models\User;
use App\Routing\ControllerDispatcher as RoutingControllerDispatcher;
use App\TenantVoyager;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Routing\Contracts\ControllerDispatcher as ContractsControllerDispatcher;
use Illuminate\Routing\ControllerDispatcher;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Stancl\Tenancy\Bootstrappers\DatabaseTenancyBootstrapper;
use TCG\Voyager\Facades\Voyager;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $loader = AliasLoader::getInstance();
        $loader->alias('TenantVoyager', TenantVoyagerFacade::class);

        // Bug: tenants routes are loaded from tenant db data types
        $this->app->bind(ContractsControllerDispatcher::class, fn ($app) => new RoutingControllerDispatcher($app, $app->make(DatabaseTenancyBootstrapper::class)));

        $this->app->singleton('tenant-voyager', function () {
            return new TenantVoyager();
        });

        $this->loadHelpers();
    }

    /**
     * Load helpers.
     */
    protected function loadHelpers()
    {
        foreach (glob(__DIR__.'/../Helpers/*.php') as $filename) {
            require_once $filename;
        }
    }

    /**
     * Register view composers.
     */
    protected function registerViewComposers()
    {
        // Register alerts
        View::composer('tenant-voyager::*', function ($view) {
            $view->with('alerts', TenantVoyagerFacade::alerts());
        });
    }

    /**
     * Bootstrap the application services.
     *
     * @param \Illuminate\Routing\Router $router
     */
    public function boot(Router $router, Dispatcher $event)
    {
        $this->commands([
            Commands\DbDrop::class,
        ]);

        $this->loadViewsFrom(__DIR__.'/../../resources/views/vendor/tenant-voyager', 'tenant-voyager');

        $this->registerViewComposers();

        $router->aliasMiddleware('tenant-admin.user', TenantVoyagerAdminMiddleware::class);

        \URL::forceRootUrl(\Config::get('app.url'));
        // And this if you wanna handle https URL scheme
        // It's not usefull for http://www.example.com, it's just to make it more independant from the constant value
        if (\Str::contains(\Config::get('app.url'), 'https://')) {
            \URL::forceScheme('https');
            //use \URL:forceSchema('https') if you use laravel < 5.4
        }
    }
}
