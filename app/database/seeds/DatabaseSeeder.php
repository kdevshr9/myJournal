<?php

class DatabaseSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        Eloquent::unguard();

        // $this->call('UserTableSeeder');
        $this->call('UserTableSeeder');

        $this->command->info('User table seeded!');
    }

}

class UserTableSeeder extends Seeder {

    public function run() {
        DB::table('users')->delete();

        User::create(
                array(
                    'email' => 'kdevshr9@gmail.com',
                    'name' => 'Kumar Dev Shrestha',
                    'username' => 'dev_shr',
                    'password' => Hash::make('password')
                )
        );
    }

}
