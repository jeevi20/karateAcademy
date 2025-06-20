<?php

namespace Database\Seeders;
use App\Models\Belt;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BeltSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Belt::create([
            'belt_name'=>'9th Kyu (White)',
            'rank'=>'No prior experience.' ,
            'color'=>'White',
            'requirements' => 'Basic stances, punches & blocks.',
            'max_attempts' =>'unlimited',
            
            
        ]);

        Belt::create([
            'belt_name'=>'8th Kyu (Yellow)',
            'rank'=>'Beginner' ,
            'color'=>'Yellow',
            'requirements' => 'Basic stances, punches & blocks.',
            'max_attempts' =>'3'
        ]);

        Belt::create([
            'belt_name'=>'7th Kyu (Orange)',
            'rank'=>'Beginner' ,
            'color'=>'Orange',
            'requirements' => 'Improved techniques, basic kata.',
            'max_attempts' =>'3'
        ]);

        Belt::create([
            'belt_name'=>'6th Kyu (Green)',
            'rank'=>'Intermediate' ,
            'color'=>'Green',
            'requirements' => 'Proficiency in basic movements, kata. ',
            'max_attempts' =>'3'
        ]);

        Belt::create([
            'belt_name'=>'5th Kyu (Purple-1)',
            'rank'=>'Intermediate' ,
            'color'=>'Purple',
            'requirements' => 'Enhanced control and precision.',
            'max_attempts' =>'3'
        ]);

        Belt::create([
            'belt_name'=>'4th Kyu (Purple-2)',
            'rank'=>'Intermediate' ,
            'color'=>'Purple',
            'requirements' => 'Mastery of intermediate techniques, kata.',
            'max_attempts' =>'3'
        ]);

        Belt::create([
            'belt_name'=>'3rd Kyu (Brown-1)',
            'rank'=>'Advanced' ,
            'color'=>'Brown',
            'requirements' => 'Mastery of advanced basics, sparring, and kata.',
            'max_attempts' =>'2'
        ]);

        Belt::create([
            'belt_name'=>'2nd Kyu (Brown-2)',
            'rank'=>'Advanced' ,
            'color'=>'Brown',
            'requirements' => 'High-level control, multiple katas.',
            'max_attempts' =>'2'
        ]);

        Belt::create([
            'belt_name'=>'1st Kyu (Brown-3)',
            'rank'=>'Advanced' ,
            'color'=>'Brown',
            'requirements' => 'Exceptional proficiency in advanced techniques, kata',
            'max_attempts' =>'2'
        ]);

        Belt::create([
            'belt_name'=>'Shodan (Black-1)',
            'rank'=>'1st Dan' ,
            'color'=>'Black',
            'requirements' => 'Mastery of foundational techniques, basic kata, and kumite.',
            'max_attempts' =>'3'
        ]);

        Belt::create([
            'belt_name'=>'Nidan (Black-2)',
            'rank'=>'2nd Dan' ,
            'color'=>'Black',
            'requirements' => 'Advanced kata, kumite, and demonstrated teaching ability.',
            'max_attempts' =>'3'
        ]);

        Belt::create([
            'belt_name'=>'Sandan (Black-3)',
            'rank'=>'3rd Dan' ,
            'color'=>'Black',
            'requirements' => 'Proficiency in advanced techniques, kata, and kumite, Contribution to teaching.',
            'max_attempts' =>'3'
        ]);

        Belt::create([
            'belt_name'=>'Yondan (Black-4)',
            'rank'=>'4th Dan' ,
            'color'=>'Black',
            'requirements' => 'Mastery of all previous skills, deep understanding of karate philosophy.',
            'max_attempts' =>'2'
        ]);

        Belt::create([
            'belt_name'=>'Godan (Black-5)',
            'rank'=>'5th Dan' ,
            'color'=>'Black',
            'requirements' => 'Leadership in training and teaching, contribution to the growth of karate.',
            'max_attempts' =>'2'
        ]);

        Belt::create([
            'belt_name'=>'Rokudan (Black-6)',
            'rank'=>'6th Dan' ,
            'color'=>'Black',
            'requirements' => 'Higher-level mastery, significant contribution to Shotokan Karate.',
            'max_attempts' =>'2'
        ]);

        Belt::create([
            'belt_name'=>'Nanadan (Black-7)',
            'rank'=>'7th Dan' ,
            'color'=>'Black',
            'requirements' => 'Senior master, recognized for exceptional expertise and influence.',
            'max_attempts' =>'1'
        ]);

        Belt::create([
            'belt_name'=>'Hachidan (Black-8)',
            'rank'=>'8th Dan' ,
            'color'=>'Black',
            'requirements' => 'Elite mastery, decades of teaching, and advancing the art of karate.',
            'max_attempts' =>'1'
        ]);

        Belt::create([
            'belt_name'=>'Kudan (Black-9)',
             'rank'=>'9th Dan' ,
             'color'=>'Black',
             'requirements' => 'Lifetime achievement, profound knowledge, and exceptional mastery.',
             'max_attempts' =>'1'
         ]);

        
    }
}
