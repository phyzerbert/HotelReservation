<?php

use Illuminate\Database\Seeder;
use App\Models\Role;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create([
            'name' => 'General Manager',
            'slug' => 'general_manager',
        ]);

        Role::create([
            'name' => 'Office Manager',
            'slug' => 'office_manager',
        ]);
        
        Role::create([
            'name' => 'Data Entry Guy',
            'slug' => 'data_editor',
        ]);
    }
}
