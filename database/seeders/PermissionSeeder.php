<?php

namespace Database\Seeders;
use App\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
{
    $permissions = ['create', 'edit', 'view', 'delete']; // Tên các quyền

    foreach ($permissions as $permission) {
        Permission::firstOrCreate(['name' => $permission]); // Chỉ tạo mới nếu quyền chưa tồn tại
    }
}
}
