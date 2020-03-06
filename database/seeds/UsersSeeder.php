<?php

use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      //
      DB::table('users')->insert([
        'name'=> 'Akram Chauhan',
        'username'=> 'akramchauhan',
        'email'=> 'admin@akramchauhan.com',
        'password'=> bcrypt('password'),
        'phone_number'=> '+91 960-110-6151',
        'created_at'=>'2020-03-06 11:11:11'
      ]);
    }
}
