<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\projetoGCA\User::class)->create([
            'name' => "caetano De' Carli",
            'email' => 'caetano@decarli.com',
        ]);

        factory(\projetoGCA\User::class)->create([
            'name' => "Genova De' Carli",
            'email' => 'genova@decarli.com',
        ]);

        factory(\projetoGCA\User::class, 48)->create();
    }
}
