<?php

namespace Database\Seeders;
use App\Models\Branch;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BranchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Branch::create([
            'branch_name'=>'Jaffna Town',
            'email'=>'jaffsa@gmail.com' ,
            'branch_address'=>'Jaffna',
            'phone_no' => '0210664589',
        ]);

        Branch::create([
            'branch_name'=>'Kodikamam',
            'email'=>'kodikamamjsai@gmail.com' ,
            'branch_address'=>'Kodikamam',
            'phone_no' => '0213658023',
        ]);

        Branch::create([
            'branch_name'=>'Vaddukottai',
            'email'=>'vaddukottaijsai@gmail.com' ,
            'branch_address'=>'Vaddukottai',
            'phone_no' => '0772339116',
        ]);

        Branch::create([
            'branch_name'=>'Mullaitheevu',
            'email'=>'mullaijsai@gmail.com' ,
            'branch_address'=>'Nedunkeni',
            'phone_no' => '0702239116',
        ]);

        Branch::create([
            'branch_name'=>'Vavuniya',
            'email'=>'vsk@gmail.com' ,
            'branch_address'=>'Vavuniya',
            'phone_no' => '0701335678',
        ]);
    }
}
