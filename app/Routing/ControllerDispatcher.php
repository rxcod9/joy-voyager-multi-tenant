<?php

namespace App\Routing;

use BadMethodCallException;
use Exception;
use Illuminate\Container\Container;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Routing\Route;
use Illuminate\Routing\ControllerDispatcher as RoutingControllerDispatcher;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Stancl\Tenancy\Bootstrappers\DatabaseTenancyBootstrapper;
use TCG\Voyager\Models\DataType;

class ControllerDispatcher extends RoutingControllerDispatcher
{
    /**
     * The controller instance.
     *
     * @var mixed
     */
    public $controller;

    /**
     * The tenant instance.
     *
     * @var mixed
     */
    public $tenant;

    /**
     * The dataType instance.
     *
     * @var mixed
     */
    public $dataType;

    /**
     * The databaseTenancyBootstrapper instance.
     *
     * @var mixed
     */
    public $databaseTenancyBootstrapper;

    /**
     * Create a new controller dispatcher instance.
     *
     * @param  \Illuminate\Container\Container  $container
     * @return void
     */
    public function __construct(
        Container $container,
        DatabaseTenancyBootstrapper $databaseTenancyBootstrapper
    ) {
        $this->container = $container;
        $this->databaseTenancyBootstrapper = $databaseTenancyBootstrapper;
        parent::__construct($container);
    }

    /**
     * Dispatch a request to a given controller and method.
     *
     * @param  \Illuminate\Routing\Route  $route
     * @param  mixed  $controller
     * @param  string  $method
     * @return mixed
     */
    public function dispatch(Route $route, $controller, $method)
    {
        // If Central domain request
        if ($route->getDomain()) {
            return parent::dispatch($route, $controller, $method);
        }

        // If not CRUD
        if (!in_array($method, [
            'index',
            'show',
            'create',
            'store',
            'edit',
            'update',
            'destroy',
            'order',
            'action',
            'update_order',
            'restore',
            'relation',
            'remove_media',
        ])) {
            return parent::dispatch($route, $controller, $method);
        }

        if (!$this->getTenant()) {
            return parent::dispatch($route, $controller, $method);
        }

        $this->databaseTenancyBootstrapper->bootstrap($this->getTenant());

        if (!$this->getDataType()) {
            return parent::dispatch($route, $controller, $method);
        }

        $namespacePrefix = '\\' . config('tenant-voyager.controllers.namespace') . '\\';

        $controllerClass = $this->getDataType()->controller
            ? Str::start($this->getDataType()->controller, '\\')
            : $namespacePrefix . 'VoyagerBaseController';

        $controller = $this->getController($controllerClass);

        $parameters = $this->resolveParameters($route, $controller, $method);

        if (method_exists($controller, 'callAction')) {
            try {
                return $controller->callAction($method, $parameters);
            } catch (BadMethodCallException $e) {
                return parent::dispatch($route, $controller, $method);
            }
        }

        return $controller->{$method}(...array_values($parameters));
    }

    /**
     * Get the controller instance for the route.
     *
     * @return mixed
     */
    public function getController(string $controllerClass)
    {
        if (!$this->controller) {

            $this->controller = $this->container->make(ltrim($controllerClass, '\\'));
        }

        return $this->controller;
    }

    /**
     * Get the tenant.
     *
     * @return array
     */
    protected function getTenant()
    {
        if (!$this->tenant) {
            $domain = request()->host();

            /** @var Tenant|null $tenant */
            $this->tenant =   config('tenancy.tenant_model')::query()
                ->whereHas('domains', function (Builder $query) use ($domain) {
                    $query->where('domain', $domain);
                })
                ->with('domains')
                ->first();
        }

        return $this->tenant;
    }

    /**
     * Get the dataType.
     *
     * @return array
     */
    protected function getDataType()
    {
        if (!$this->dataType) {
            $slug = explode('.', request()->route()->getName())[1];

            $this->dataType =  DataType::whereSlug($slug)->first();
        }

        return $this->dataType;
    }
}
