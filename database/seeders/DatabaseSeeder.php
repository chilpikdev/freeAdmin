<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        /**
         * SEED USERS | PERMISSION | ROLES
         */
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions
        Permission::create(['guard_name' => 'admin', 'name' => 'dashboard']);
        Permission::create(['guard_name' => 'admin', 'name' => 'manage-users']);
        Permission::create(['guard_name' => 'admin', 'name' => 'settings']);

        // create roles and assign existing permissions
        $role1 = Role::create(['guard_name' => 'admin', 'name' => 'user']);
        $role2 = Role::create(['guard_name' => 'admin', 'name' => 'moderator']);

        $role3 = Role::create(['guard_name' => 'admin', 'name' => 'admin']);
        $role3->givePermissionTo('dashboard');
        $role3->givePermissionTo('manage-users');
        $role3->givePermissionTo('settings');

        // create user
        $user = \App\Models\User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@email.com',
            'password' => bcrypt('123456789')
        ]);
        $user->assignRole($role3);

        /**
         * SETTINGS
         */
        $settings = [
            0 => [
                'title' => 'Site Logo',
                'key' => 'site_logo',
                'value' => '',
                'type' => '<div class="input-group"><div class="custom-file"><input type="file" class="custom-file-input" style="width: 100%;" name="value" id="value"><label class="custom-file-label" for="value">Выбрать файл</label></div></div>'
            ],
            1 => [
                'title' => 'Site Name',
                'key' => 'site_name',
                'value' => '',
                'type' => '<input type="text" id="value" class="form-control" style="width: 100%;" name="value">'
            ],
            2 => [
                'title' => 'Mete Title',
                'key' => 'meta_title',
                'value' => '',
                'type' => '<input type="text" id="value" class="form-control" style="width: 100%;" name="value">'
            ],
            3 => [
                'title' => 'Meta Description',
                'key' => 'meta_description',
                'value' => '',
                'type' => '<textarea id="value" class="form-control" style="width: 100%;" name="value"></textarea>'
            ],
            4 => [
                'title' => 'Meta Keywords',
                'key' => 'meta_keywords',
                'value' => '',
                'type' => '<textarea id="value" class="form-control" style="width: 100%;" name="value"></textarea>'
            ],
            5 => [
                'title' => 'Email',
                'key' => 'email',
                'value' => '',
                'type' => '<input type="text" id="value" class="form-control" style="width: 100%;" name="value">'
            ],
            6 => [
                'title' => 'Phone Number',
                'key' => 'phone_number',
                'value' => '',
                'type' => '<input type="text" id="value" class="form-control" style="width: 100%;" name="value">'
            ],
            7 => [
                'title' => 'Telegram',
                'key' => 'telegram',
                'value' => '',
                'type' => '<input type="text" id="value" class="form-control" style="width: 100%;" name="value">'
            ],
            8 => [
                'title' => 'WhatsApp',
                'key' => 'whatsapp',
                'value' => '',
                'type' => '<input type="text" id="value" class="form-control" style="width: 100%;" name="value">'
            ],
            9 => [
                'title' => 'Office Address',
                'key' => 'office_address',
                'value' => '',
                'type' => '<input type="text" id="value" class="form-control" style="width: 100%;" name="value">'
            ],
        ];

        foreach ($settings as $array)
        {
            \App\Models\Admin\Setting::create($array);
        }
    }
}
