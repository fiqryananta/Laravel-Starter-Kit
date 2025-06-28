<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;

class SuperAdminSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Super Admin',
            'email' => 'admin@semarangkota.go.id',
            'email_verified_at' => now(),
            'password' => Hash::make('jQ^)7$80GX9i'),
            'remember_token' => Str::random(10),
        ]);
    }
}
