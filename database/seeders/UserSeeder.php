<?php

namespace Database\Seeders;

use App\Models\User;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        if (!User::where('email', 'admin@example.com')->exists()) {
            User::create([
                'name' => 'Jeevana',
                'last_name' => 'Jegatheeswaran',
                'email' => 'jeevanajegatheeswaran@gmail.com',
                'phone' => '1234567890',
                'address' => 'Jaffna',
                'gender' => 'F',
                'dob' => '2000-01-20',
                'nic' => '200152001865',
                'role_id'=>'1', 
                'password' => '12345678', 
            ]);
        }
        
    }
}
