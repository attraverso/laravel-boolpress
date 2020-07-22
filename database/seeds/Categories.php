<?php

use Illuminate\Database\Seeder;
use App\Category;
use Faker\Generator as Faker;

class Categories extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    /** this instance of parameters is a Singleton design pattern */
    public function run(Faker $faker)
    {
      for ($i=0; $i < 6; $i++) { 
        $seed = new Category;
        $seed->name = $faker->word;
        $seed->slug = $faker->passthrough($seed->name);
        $seed->save();
      }
    }
}
