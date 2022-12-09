<?php

namespace App\Http\Controllers\Tenant;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Facades\TenantVoyager;

class VoyagerUserController extends VoyagerBaseController
{
    public function profile(Request $request)
    {
        $route = '';
        $dataType = TenantVoyager::model('DataType')->where('model_name', Auth::guard(app('VoyagerGuard'))->getProvider()->getModel())->first();
        if (!$dataType && app('VoyagerGuard') == 'web') {
            $route = route('tenant-voyager.users.edit', Auth::user()->getKey());
        } elseif ($dataType) {
            $route = route('tenant-voyager.'.$dataType->slug.'.edit', Auth::user()->getKey());
        }

        return TenantVoyager::view('tenant-voyager::profile', compact('route'));
    }

    // POST BR(E)AD
    public function update(Request $request, $id)
    {
        if (Auth::user()->getKey() == $id) {
            $request->merge([
                'role_id'                              => Auth::user()->role_id,
                'user_belongstomany_role_relationship' => Auth::user()->roles->pluck('id')->toArray(),
            ]);
        }

        return parent::update($request, $id);
    }
}
