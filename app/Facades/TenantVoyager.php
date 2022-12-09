<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class TenantVoyager extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @method static string image($file, $default = '')
     * @method static $this useModel($name, $object)
     *
     * @see \App\Voyager
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'tenant-voyager';
    }
}
