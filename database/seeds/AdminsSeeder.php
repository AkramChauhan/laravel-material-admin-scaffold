<?php

use Illuminate\Database\Seeder;

class AdminsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $profile_pic= url('/')."/frontend_assets/profiles/akram_chauhan.jpg";
      //
      DB::table('admins')->insert([
        'name'=> 'Akram Chauhan',
        'email'=> 'admin@akramchauhan.com',
        'password'=> bcrypt('admin12345'),
        'created_at'=>'2020-03-06 11:11:11'
      ]);
    }
}
