<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Buat Role
        $admin = Role::firstOrCreate(['name' => 'admin']);
        $kasir = Role::firstOrCreate(['name' => 'kasir']);
        $pelanggan = Role::firstOrCreate(['name' => 'pelanggan']);

        // Tambahkan Izin
        Permission::firstOrCreate(['name' => 'manage products']);
        Permission::firstOrCreate(['name' => 'manage users']);
        Permission::firstOrCreate(['name' => 'manage promo']);
        Permission::firstOrCreate(['name' => 'manage settings']);
        Permission::firstOrCreate(['name' => 'manage orders']);

        // Berikan Izin ke Role Admin
        $admin = Role::findByName('admin');
        $admin->givePermissionTo(['manage products', 'manage users', 'manage promo', 'manage orders', 'manage settings']);

        // Berikan Izin ke Role Kasir
        $kasir = Role::findByName('kasir');
        $kasir->givePermissionTo(['manage orders']);
    }
}
