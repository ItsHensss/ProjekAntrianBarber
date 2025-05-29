<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use BezhanSalleh\FilamentShield\Support\Utils;
use Spatie\Permission\PermissionRegistrar;

class ShieldSeeder extends Seeder
{
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $rolesWithPermissions = '[{"name":"super_admin","guard_name":"web","permissions":["view_foto::interior","view_any_foto::interior","create_foto::interior","update_foto::interior","restore_foto::interior","restore_any_foto::interior","replicate_foto::interior","reorder_foto::interior","delete_foto::interior","delete_any_foto::interior","force_delete_foto::interior","force_delete_any_foto::interior","view_foto::potongan","view_any_foto::potongan","create_foto::potongan","update_foto::potongan","restore_foto::potongan","restore_any_foto::potongan","replicate_foto::potongan","reorder_foto::potongan","delete_foto::potongan","delete_any_foto::potongan","force_delete_foto::potongan","force_delete_any_foto::potongan","view_lokasi","view_any_lokasi","create_lokasi","update_lokasi","restore_lokasi","restore_any_lokasi","replicate_lokasi","reorder_lokasi","delete_lokasi","delete_any_lokasi","force_delete_lokasi","force_delete_any_lokasi","view_operational","view_any_operational","create_operational","update_operational","restore_operational","restore_any_operational","replicate_operational","reorder_operational","delete_operational","delete_any_operational","force_delete_operational","force_delete_any_operational","view_produk","view_any_produk","create_produk","update_produk","restore_produk","restore_any_produk","replicate_produk","reorder_produk","delete_produk","delete_any_produk","force_delete_produk","force_delete_any_produk","view_queue","view_any_queue","create_queue","update_queue","restore_queue","restore_any_queue","replicate_queue","reorder_queue","delete_queue","delete_any_queue","force_delete_queue","force_delete_any_queue","view_role","view_any_role","create_role","update_role","delete_role","delete_any_role","view_user","view_any_user","create_user","update_user","restore_user","restore_any_user","replicate_user","reorder_user","delete_user","delete_any_user","force_delete_user","force_delete_any_user"]}]';
        $directPermissions = '[]';

        static::makeRolesWithPermissions($rolesWithPermissions);
        static::makeDirectPermissions($directPermissions);

        $this->command->info('Shield Seeding Completed.');
    }

    protected static function makeRolesWithPermissions(string $rolesWithPermissions): void
    {
        if (! blank($rolePlusPermissions = json_decode($rolesWithPermissions, true))) {
            /** @var Model $roleModel */
            $roleModel = Utils::getRoleModel();
            /** @var Model $permissionModel */
            $permissionModel = Utils::getPermissionModel();

            foreach ($rolePlusPermissions as $rolePlusPermission) {
                $role = $roleModel::firstOrCreate([
                    'name' => $rolePlusPermission['name'],
                    'guard_name' => $rolePlusPermission['guard_name'],
                ]);

                if (! blank($rolePlusPermission['permissions'])) {
                    $permissionModels = collect($rolePlusPermission['permissions'])
                        ->map(fn ($permission) => $permissionModel::firstOrCreate([
                            'name' => $permission,
                            'guard_name' => $rolePlusPermission['guard_name'],
                        ]))
                        ->all();

                    $role->syncPermissions($permissionModels);
                }
            }
        }
    }

    public static function makeDirectPermissions(string $directPermissions): void
    {
        if (! blank($permissions = json_decode($directPermissions, true))) {
            /** @var Model $permissionModel */
            $permissionModel = Utils::getPermissionModel();

            foreach ($permissions as $permission) {
                if ($permissionModel::whereName($permission)->doesntExist()) {
                    $permissionModel::create([
                        'name' => $permission['name'],
                        'guard_name' => $permission['guard_name'],
                    ]);
                }
            }
        }
    }
}
