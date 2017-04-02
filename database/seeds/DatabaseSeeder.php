<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        \App\User::create( [
            'name' => 'Derick',
            'email' => 'derickfelix4321@gmail.com',
            'password' => bcrypt('admin'),
            'remember_token' => str_random(10),
        ]);
        $this->call(PostsTableSeeder::class);
        $this->call(TagTableSeeder::class);
        //$this->call(CommentTableSeeder::class);
    }
}
