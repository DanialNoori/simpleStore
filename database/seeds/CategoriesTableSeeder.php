<?php

use App\Category;
use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Category::create(['name'=>'Mobile']);
        Category::create(['name'=>'Tablet']);
        Category::create(['name'=>'Headphone']);
        Category::create(['name'=>'Hands free']);
    }
}
