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
        $data = [
            [
                'name' => 'Supper-admin',
                'description' => 'Administrator with full access',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Admin',
                'description' => 'Scope Administrator with limited access',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Editor',
                'description' => 'Content editor with limited access',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'User',
                'description' => 'Regular user with limited access',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];
        $existData = Role::get()->pluck('name')->toArray();
        $insertData = [];
        foreach($data as $role){
            if(!in_array($role['name'],$existData)){
                $insertData[] = $role;
            }
        }
        if(!empty($insertData)){
            Role::insert($insertData);
        }
    }
}
