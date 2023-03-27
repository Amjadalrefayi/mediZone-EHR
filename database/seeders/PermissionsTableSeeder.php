<?php

namespace Database\Seeders;

use App\Enums\PermissionType;
use App\Models\Permission;
use Illuminate\Database\Seeder;

class   PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (PermissionType::getValues() as $value) {
            $this->createPermission($value, PermissionType::getDescription($value));
        }
    }

    private function createPermission($name, $description)
    {
        if (Permission::whereName($name)->count() === 0) {
            echo "creating permission $name \n";

            return Permission::create([
                'name' => $name,
                'description' => $description,
                'guard_name' => 'api',
            ]);
        }
    }
}
