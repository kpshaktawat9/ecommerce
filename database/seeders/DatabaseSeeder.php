<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $user = User::factory()->create([
            'name' => 'Admin',
            'email' => 'test@example.com',
            'password' => Hash::make('password'),
        ]);

        // attach admin role to the user
        $roleId = Role::where('slug', 'admin')->first()->id ?? null;
        if ($roleId) {
            $user->roles()->attach($roleId);
        }
    }
}
