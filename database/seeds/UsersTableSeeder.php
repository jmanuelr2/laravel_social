<?php

use Illuminate\Database\Seeder;
use App\User;
class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        user::truncate();
        factory(User::class)->create(['email' => 'jmanuelr2@hotmail.com']);
    }
}
