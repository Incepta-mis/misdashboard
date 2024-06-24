<?php

use Illuminate\Database\Seeder;

class User_table_Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users_info')->insert([[
            'name' =>'Raqib',
            'user_id'=> 1012064,
            'email' => 'raqib@inceptapharma.com',
            'password' => bcrypt('1'),
            'role' => '5'
        ],
        [
            'name' =>'xyz',
            'user_id'=> 1010112,
            'email' => 'xyz1@inceptapharma.com',
            'password' => bcrypt('1234'),
            'role' => '5'
        ],
        [
            'name' =>'xyz',
            'user_id'=> 1005975,
            'email' => 'xyz2@inceptapharma.com',
            'password' => bcrypt('1234'),
            'role' => '5'
        ],
        [
            'name' =>'xyz',
            'user_id'=> 1000069,
            'email' => 'xyz3@inceptapharma.com',
            'password' => bcrypt('1234'),
            'role' => '5'
        ],
        [
            'name' =>'xyz',
            'user_id'=> 1006519,
            'email' => 'xyz4@inceptapharma.com',
            'password' => bcrypt('1234'),
            'role' => '5'
        ]
        ]);
    }
}
