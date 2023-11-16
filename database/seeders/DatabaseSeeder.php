<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        $owner1 = \App\Models\User::create([
            'name' => 'Mohsen Mirhosseini',
            'email' => 'mohsen.mirhosseini@gmail.com',
            'password' => 'Nil00f@r1869',
            'api_token' => Str::random(60),
        ]);

        \App\Models\Chat::create([
            'title' => 'Room 102001',
            'owner_id' => $owner1->id
        ]);

        $owner2 = \App\Models\User::create([
            'name' => 'Amir ArabNezhad',
            'email' => 'amirarabnezhad0@gmail.com',
            'password' => '123456',
            'api_token' => Str::random(60),
        ]);
        \App\Models\Chat::create([
            'title' => 'Room 102015',
            'owner_id' => $owner2->id
        ]);
    }
}
