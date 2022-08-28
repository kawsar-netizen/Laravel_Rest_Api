<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            ['name'=>'Kawsar','email'=>'Kawsar@gamil.com','password'=>'123456'],
            ['name'=>'Rafi','email'=>'Rafi@gamil.com','password'=>'123456'],
            ['name'=>'Sinat','email'=>'Sinat@gamil.com','password'=>'123456'],
            ['name'=>'Nafian','email'=>'Nafian@gamil.com','password'=>'123456'],
        ];

        User::insert($users);
    }
}
