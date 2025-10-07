<?php

namespace Database\Seeders;
use App\Models\User;
use App\Models\Team;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TeamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         $admin = User::where('email', 'admin@example.com')->first();
        $users = User::where('role', 'user')->get();

        // Create teams
        $team1 = Team::create([
            'name' => 'Development Team',
            'description' => 'Main development team',
            'created_by' => $admin->id,
        ]);

        $team2 = Team::create([
            'name' => 'Marketing Team',
            'description' => 'Marketing and promotion',
            'created_by' => $admin->id,
        ]);

        // Attach users to teams
        $team1->users()->attach($users->random(5)->pluck('id'));
        $team2->users()->attach($users->random(4)->pluck('id'));
    }
}
