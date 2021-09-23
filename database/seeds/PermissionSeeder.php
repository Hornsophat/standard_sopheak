<?php

use Illuminate\Database\Seeder;
use App\Model\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            ['name' => 'create-customer', 'display_name' => 'Create Customer'],
            ['name' => 'edit-customer', 'display_name' => 'Edit Customer'],
            ['name' => 'list-customer', 'display_name' => 'List Customer'],
            ['name' => 'delete-customer', 'display_name' => 'Delete Customer'],
            ['name' => 'view-customer', 'display_name' => 'View Customer'],
            ['name' => 'visit-customer', 'display_name' => 'Viseted Customer'],

            ['name' => 'create-employee', 'display_name' => 'Create Employee'],
            ['name' => 'edit-employee', 'display_name' => 'Edit Employee'],
            ['name' => 'list-employee', 'display_name' => 'List Employee'],
            ['name' => 'delete-employee', 'display_name' => 'Delete Employee'],
            ['name' => 'view-employee', 'display_name' => 'View Employee'],

            ['name' => 'create-product', 'display_name' => 'Create Product'],
            ['name' => 'edit-product', 'display_name' => 'Edit Product'],
            ['name' => 'list-product', 'display_name' => 'List Product'],
            ['name' => 'delete-product', 'display_name' => 'Delete Product'],
            ['name' => 'inventory-product', 'display_name' => 'Inventory Product'],

            ['name' => 'create-sale', 'display_name' => 'Create Sale'],
            ['name' => 'list-sale', 'display_name' => 'List Sale'],
            ['name' => 'view-sale', 'display_name' => 'View Sale'],
            ['name' => 'view-payment', 'display_name' => 'View Payment'],

            ['name' => 'create-deposite', 'display_name' => 'Create Deposite'],
            ['name' => 'complete-sale', 'display_name' => 'Complete Sale'],
            ['name' => 'cancel-sale', 'display_name' => 'Cancel Sale'],

            ['name' => 'create-land', 'display_name' => 'Create Land'],
            ['name' => 'edit-land', 'display_name' => 'Edit Land'],
            ['name' => 'list-land', 'display_name' => 'List Land'],
            ['name' => 'delete-land', 'display_name' => 'Delete Land'],

            ['name' => 'create-property-zone', 'display_name' => 'Create Property Zone'],
            ['name' => 'edit-property-zone', 'display_name' => 'Edit Property Zone'],
            ['name' => 'list-property-zone', 'display_name' => 'List Property Zone'],
            ['name' => 'delete-property-zone', 'display_name' => 'Delete Property Zone'],

            ['name' => 'create-project', 'display_name' => 'Create Project'],
            ['name' => 'edit-project', 'display_name' => 'Edit Project'],
            ['name' => 'list-project', 'display_name' => 'List Project'],
            ['name' => 'delete-project', 'display_name' => 'Delete Project'],
            ['name' => 'view-project', 'display_name' => 'View Project'],
            ['name' => 'view-project-commission', 'display_name' => 'View Project Commission'],

            ['name' => 'create-property', 'display_name' => 'Create Property'],
            ['name' => 'edit-property', 'display_name' => 'Edit Property'],
            ['name' => 'list-property', 'display_name' => 'List Property'],
            ['name' => 'delete-property', 'display_name' => 'Delete Property'],
            ['name' => 'view-property', 'display_name' => 'View Property'],

            ['name' => 'create-property-type', 'display_name' => 'Create Property Type'],
            ['name' => 'edit-property-type', 'display_name' => 'Edit Property Type'],
            ['name' => 'list-property-type', 'display_name' => 'List Property Type'],
            ['name' => 'delete-property-type', 'display_name' => 'Delete Property Type'],

            ['name' => 'create-timeline', 'display_name' => 'Create Payment Timeline'],
            ['name' => 'edit-timeline', 'display_name' => 'Edit Payment Timeline'],
            ['name' => 'list-timeline', 'display_name' => 'List Payment Timeline'],
            ['name' => 'delete-timeline', 'display_name' => 'Delete Payment Timeline'],
            ['name' => 'view-timeline', 'display_name' => 'View Payment Timeline'],

            ['name' => 'create-user-group', 'display_name' => 'Create User Group'],
            ['name' => 'edit-user-group', 'display_name' => 'Edit User Group'],
            ['name' => 'list-user-group', 'display_name' => 'List User Group'],
            ['name' => 'delete-user-group', 'display_name' => 'Delete User Group'],

            ['name' => 'create-user', 'display_name' => 'Create User'],
            ['name' => 'edit-user', 'display_name' => 'Edit User'],
            ['name' => 'list-user', 'display_name' => 'List User'],
            ['name' => 'delete-user', 'display_name' => 'Delete User'],

            ['name' => 'settings', 'display_name' => 'Settings'],

            ['name' => 'create-position', 'display_name' => 'Create Position'],
            ['name' => 'list-position', 'display_name' => 'List Position'],
            ['name' => 'view-position', 'display_name' => 'View Position'],
            ['name' => 'delete-position', 'display_name' => 'Delete Position'],
            ['name' => 'edit-position', 'display_name' => 'Edit Position'],

            ['name' => 'create-department', 'display_name' => 'Create Department'],
            ['name' => 'list-department', 'display_name' => 'List Department'],
            ['name' => 'view-department', 'display_name' => 'View Department'],
            ['name' => 'delete-department', 'display_name' => 'Delete Department'],
            ['name' => 'edit-department', 'display_name' => 'Edit Department'],

            ['name' => 'create-sale-type', 'display_name' => 'Create Sale Type'],
            ['name' => 'list-sale-type', 'display_name' => 'List Sale Type'],
            ['name' => 'view-sale-type', 'display_name' => 'View Sale Type'],
            ['name' => 'delete-sale-type', 'display_name' => 'Delete Sale Type'],
            ['name' => 'edit-sale-type', 'display_name' => 'Edit Sale Type'],
        ];

        $new_per = '';
        $i = 0;
        foreach ($permissions as $per)
        {
            $permission = Permission::where('name', $per['name'])->first();

            if (is_null($permission))
            {
                $new_permission = Permission::create($per);
                $new_per .= $per['name'];

                if ($i != count($permissions) - 1)
                    $new_per .= ', ';
            }
            $i++;
        }

        if ($new_per == '')
            echo ('Nothing permission is added.');
        else
            echo ('Successfully created new permission(s) : ' . $new_per);
    }
}
