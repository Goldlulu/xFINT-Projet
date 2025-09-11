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
            'must_change_password' => false, // Pas besoin de changer le mot de passe
        ]);
        $manager->assignRole('manager');

        // Créer un employé de test
        $employee = User::create([
            'name' => 'Employee Test',
            'email' => 'employee@test.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);
        $employee->assignRole('employee');
    }
}
