<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        // ⚠️ COMPTE OBLIGATOIRE POUR L'ÉVALUATION ⚠️
        $manager = User::create([
            'name' => 'Manager SUP Herman',
            'email' => 'manager@supherman.com',
            'password' => Hash::make('Suph3rm4n!'),
            'email_verified_at' => now(),
            'must_change_password' => false, // Pas besoin de changer le mot de passe
        ]);
        $manager->assignRole('manager');

        // Autres comptes de test (optionnels)
        $employee = User::create([
            'name' => 'Employee Test',
            'email' => 'employee@test.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);
        $employee->assignRole('employee');

        $accounting = User::create([
            'name' => 'Accounting Test',
            'email' => 'accounting@test.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);
        $accounting->assignRole('accounting');
    }
}
