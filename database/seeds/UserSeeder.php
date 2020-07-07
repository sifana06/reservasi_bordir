<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->user();
    }

    public function user()
    {
        $payload = [
            'name' => 'Dandy',
            'email' => 'dandy@ziqomedia.com',
            'password' => bcrypt('password'),
            'phone' => '0823239323423',
            'role' => 'admin',
        ];

        User::firstOrCreate($payload)->sharedLock()->get();

        $payload = [
            'name' => 'Dono',
            'email' => 'dono@email.com',
            'password' => bcrypt('secret'),
            'phone' => '087567786734',
            'role' => 'pemilik',
        ];

        User::firstOrCreate($payload);
    }
}
