<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Créer un manager par défaut
        $manager = User::create([
            'name' => 'Manager SUP Herman',
            'email' => 'manager@supherman.com',
            'password' => Hash::make('Suph3rm4n!'),
            'email_verified_at' => now(),
        ]);
        $manager->assignRole('manager');

    }
}
