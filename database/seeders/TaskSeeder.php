<?php

namespace Database\Seeders;
use App\Models\Task;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Team;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         $teams = Team::with('users')->get();

        foreach ($teams as $team) {
            if ($team->users->count() > 0) {
                // Create 5 tasks per team
                for ($i = 1; $i <= 5; $i++) {
                    Task::create([
                        'title' => "Task $i for {$team->name}",
                        'description' => "Description for task $i",
                        'priority' => ['low', 'medium', 'high'][array_rand(['low', 'medium', 'high'])],
                        'status' => ['pending', 'in_progress', 'completed'][array_rand(['pending', 'in_progress', 'completed'])],
                        'due_date' => now()->addDays(rand(1, 30)),
                        'team_id' => $team->id,
                        'created_by' => $team->created_by,
                        'assigned_to' => $team->users->random()->id,
                    ]);
                }
            }
        } 
    }
}
