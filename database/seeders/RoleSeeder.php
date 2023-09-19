<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = ['admin', 'manager','chef', 'casher', 'waiter'];
        $arr = [];
        foreach ($roles as $role) {
            $arr[] = [
                "position" => $role,
                "updated_at" => now(),
                "created_at" => now(),
            ];
        }
        Role::insert($arr);
    }
}
