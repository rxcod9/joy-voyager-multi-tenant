<?php

namespace App\Actions;

use TCG\Voyager\Actions\ViewAction as ActionsViewAction;

class ViewAction extends ActionsViewAction implements TenantActionInterface
{
    public function getDefaultRoute()
    {
        return route('tenant-voyager.' . $this->dataType->slug . '.show', $this->data->{$this->data->getKeyName()});
    }
}
