<?php

namespace App\Actions;

use TCG\Voyager\Actions\ActionInterface;

interface TenantActionInterface extends ActionInterface
{
    public function getTitle();

    public function getIcon();

    public function getPolicy();

    public function getAttributes();

    public function getRoute($key);

    public function getDefaultRoute();

    public function getDataType();
}
