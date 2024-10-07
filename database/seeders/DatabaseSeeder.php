<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Book;
use App\Models\Review;

class DatabaseSeeder extends Seeder
{

    public function run(): void
    {
        Book::factory(33)->create()->each(function($book){
            
            $randomNumb = random_int(3,30);

            Review::factory()->count($randomNumb)->averageRate()->for($book)->create();
        });

        Book::factory(33)->create()->each(function($book){
            
            $randomNumb = random_int(3,30);

            Review::factory()->count($randomNumb)->badRate()->for($book)->create();
        });

        Book::factory(34)->create()->each(function($book){
            
            $randomNumb = random_int(3,30);

            Review::factory()->count($randomNumb)->goodRate()->for($book)->create();
        });
        
    }
}
