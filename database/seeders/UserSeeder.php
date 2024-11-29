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
        User::create([
            'name' => 'Jeevana',
            'last_name'=>'Jegatheeswaran',
            'email' => 'jeevanajegatheeswaran@gmail.com',
            'address'=>'Jaffna',
            'role_id'=>'1', 
            'phone'=>'0776639407',
            'password'=>'12345678',
            'nic'=>'200152001865',
            'dob'=>'2001-01-20',
            'gender'=>'F'
            
        ]);
    }
}
