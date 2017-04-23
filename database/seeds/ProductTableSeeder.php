<?php

use Illuminate\Database\Seeder;

class ProductTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (range(1,UserTableSeeder::MAX_NUMBER_OF_USER) as $id) {
            factory(App\Product::class,1)->create(['user_id'=>$id]);
        }

    }
}
