<?php

//panggil model
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
        // panggil nama function
        $this->user();
    }

    public function user() /**ini nama function.e, menyesuaikan aja */
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

        $payload = [
            'name' => 'Anda',
            'email' => 'azidantx98@gmail.com',
            'password' => bcrypt('rahasia'),
            'phone' => '0834573465234',
            'role' => 'pemilik'
        ];

        User::firstOrCreate($payload);
    }
}
