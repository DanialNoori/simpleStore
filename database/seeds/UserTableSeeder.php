<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    const MAX_NUMBER_OF_USER = 10;
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\User::class,self::MAX_NUMBER_OF_USER)->create();
    }
}
