<?php

namespace Database\Seeders;

use App\Models\Tenant;
use Illuminate\Database\Seeder;
use Stancl\Tenancy\Database\Models\Domain;
use TCG\Voyager\Models\DataRow;
use TCG\Voyager\Models\DataType;
use TCG\Voyager\Models\Menu;
use TCG\Voyager\Models\MenuItem;
use TCG\Voyager\Models\Permission;

class DomainsTableSeeder extends Seeder
{
    /**
     * Auto generated seed file.
     *
     * @return void
     */
    public function run()
    {
        //Data Type
        $dataType = $this->dataType('name', 'domains');
        if (!$dataType->exists) {
            $dataType->fill([
                'slug'                  => 'domains',
                'display_name_singular' => __('seeders.data_types.domain.singular'),
                'display_name_plural'   => __('seeders.data_types.domain.plural'),
                'icon'                  => 'voyager-world',
                'model_name'            => 'Stancl\\Tenancy\\Database\\Models\\Domain',
                'controller'            => '',
                'generate_permissions'  => 1,
                'description'           => '',
            ])->save();
        }
        //Data Rows
        $domainDataType = DataType::where('slug', 'domains')->firstOrFail();
        $dataRow = $this->dataRow($domainDataType, 'id');
        if (!$dataRow->exists) {
            $dataRow->fill([
                'type'         => 'number',
                'display_name' => __('voyager::seeders.data_rows.id'),
                'required'     => 1,
                'browse'       => 0,
                'read'         => 0,
                'edit'         => 0,
                'add'          => 0,
                'delete'       => 0,
                'order'        => 1,
            ])->save();
        }

        $dataRow = $this->dataRow($domainDataType, 'tenant_id');
        if (!$dataRow->exists) {
            $dataRow->fill([
                'type'         => 'text',
                'display_name' => __('seeders.data_rows.tenant'),
                'required'     => 1,
                'browse'       => 1,
                'read'         => 1,
                'edit'         => 1,
                'add'          => 1,
                'delete'       => 1,
                'order'        => 2,
            ])->save();
        }

        $dataRow = $this->dataRow($domainDataType, 'domain_belongsto_tenant_relationship');
        if (!$dataRow->exists) {
            $dataRow->fill([
                'type'         => 'relationship',
                'display_name' => __('seeders.data_rows.tenant'),
                'required'     => 0,
                'browse'       => 1,
                'read'         => 1,
                'edit'         => 1,
                'add'          => 1,
                'delete'       => 0,
                'details'      => [
                    'model'       => 'App\\Models\\Tenant',
                    'table'       => 'tenants',
                    'type'        => 'belongsTo',
                    'column'      => 'tenant_id',
                    'key'         => 'id',
                    'label'       => 'name',
                    'pivot_table' => 'tenants',
                    'pivot'       => 0,
                ],
                'order'        => 3,
            ])->save();
        }

        $dataRow = $this->dataRow($domainDataType, 'domain');
        if (!$dataRow->exists) {
            $dataRow->fill([
                'type'         => 'text',
                'display_name' => __('seeders.data_rows.domain'),
                'required'     => 1,
                'browse'       => 1,
                'read'         => 1,
                'edit'         => 1,
                'add'          => 1,
                'delete'       => 1,
                'order'        => 4,
            ])->save();
        }

        $dataRow = $this->dataRow($domainDataType, 'created_at');
        if (!$dataRow->exists) {
            $dataRow->fill([
                'type'         => 'timestamp',
                'display_name' => __('voyager::seeders.data_rows.created_at'),
                'required'     => 0,
                'browse'       => 0,
                'read'         => 1,
                'edit'         => 0,
                'add'          => 0,
                'delete'       => 0,
                'order'        => 5,
            ])->save();
        }

        $dataRow = $this->dataRow($domainDataType, 'updated_at');
        if (!$dataRow->exists) {
            $dataRow->fill([
                'type'         => 'timestamp',
                'display_name' => __('voyager::seeders.data_rows.updated_at'),
                'required'     => 0,
                'browse'       => 0,
                'read'         => 0,
                'edit'         => 0,
                'add'          => 0,
                'delete'       => 0,
                'order'        => 6,
            ])->save();
        }

        //Menu Item
        $menu = Menu::where('name', 'admin')->firstOrFail();
        $menuItem = MenuItem::firstOrNew([
            'menu_id' => $menu->id,
            'title'   => __('seeders.menu_items.domains'),
            'url'     => '',
            'route'   => 'voyager.domains.index',
        ]);
        if (!$menuItem->exists) {
            $menuItem->fill([
                'target'     => '_self',
                'icon_class' => 'voyager-world',
                'color'      => null,
                'parent_id'  => null,
                'order'      => 10,
            ])->save();
        }

        //Permissions
        Permission::generateFor('domains');

        $tenant1 = Tenant::whereSlug(config('seed.tenants.1_slug', 'tenant-1'))->firstOrFail();

        $domain = Domain::firstOrNew([
            'domain' => config('seed.domains.1_tenant_1_domain', 'domain-1-tenant-1.localhost'),
        ]);
        if (!$domain->exists) {
            $domain->fill([
                'tenant_id' => $tenant1->id,
            ])->save();
        }

        $domain = Domain::firstOrNew([
            'domain' => config('seed.domains.1_tenant_2_domain', 'domain-2-tenant-1.localhost'),
        ]);
        if (!$domain->exists) {
            $domain->fill([
                'tenant_id' => $tenant1->id,
            ])->save();
        }

        $tenant2 = Tenant::whereSlug(config('seed.tenants.2_slug', 'tenant-2'))->firstOrFail();

        $domain = Domain::firstOrNew([
            'domain' => config('seed.domains.2_tenant_1_domain', 'domain-1-tenant-2.localhost'),
        ]);
        if (!$domain->exists) {
            $domain->fill([
                'tenant_id' => $tenant2->id,
            ])->save();
        }

        $domain = Domain::firstOrNew([
            'domain' => config('seed.domains.2_tenant_2_domain', 'domain-2-tenant-2.localhost'),
        ]);
        if (!$domain->exists) {
            $domain->fill([
                'tenant_id' => $tenant2->id,
            ])->save();
        }
    }

    /**
     * [dataRow description].
     *
     * @param [type] $type  [description]
     * @param [type] $field [description]
     *
     * @return [type] [description]
     */
    protected function dataRow($type, $field)
    {
        return DataRow::firstOrNew([
            'data_type_id' => $type->id,
            'field'        => $field,
        ]);
    }

    /**
     * [dataType description].
     *
     * @param [type] $field [description]
     * @param [type] $for   [description]
     *
     * @return [type] [description]
     */
    protected function dataType($field, $for)
    {
        return DataType::firstOrNew([$field => $for]);
    }
};
