<?php

namespace App\Actions;

use TCG\Voyager\Actions\EditAction as ActionsEditAction;

class EditAction extends ActionsEditAction implements TenantActionInterface
{
    public function getDefaultRoute()
    {
        return route('tenant-voyager.' . $this->dataType->slug . '.edit', $this->data->{$this->data->getKeyName()});
    }
}
