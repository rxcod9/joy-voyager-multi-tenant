<?php

if (!function_exists('tenant_voyager_asset')) {
    function tenant_voyager_asset($path, $secure = null)
    {
        return route('tenant-voyager.voyager_assets').'?path='.urlencode($path);
    }
}