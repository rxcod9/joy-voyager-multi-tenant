<?php

namespace App\Actions;

use TCG\Voyager\Actions\RestoreAction as ActionsRestoreAction;

class RestoreAction extends ActionsRestoreAction implements TenantActionInterface
{
    public function getDefaultRoute()
    {
        return route('tenant-voyager.'.$this->dataType->slug.'.restore', $this->data->{$this->data->getKeyName()});
    }
}
