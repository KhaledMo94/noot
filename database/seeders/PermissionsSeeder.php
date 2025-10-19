<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $array = [
            'categories',
            'product-categories',
            'packages',
            'service-providers',
            'users',
            'cashiers',
            'notifications',
            'orders',
            'products',
        ];

        foreach ($array as $permission){
            Permission::create(['name'=>$permission]);
        }
    }
}
