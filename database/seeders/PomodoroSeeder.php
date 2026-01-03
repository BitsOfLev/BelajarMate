<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PomodoroPreset;

class PomodoroSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Check if system preset already exists
        $existingPreset = PomodoroPreset::where('preset_type', 'system')->first();
        
        if (!$existingPreset) {
            PomodoroPreset::create([
                'user_id' => null,
                'preset_type' => 'system',
                'title' => 'Classic Pomodoro',
                'work_minutes' => 25,
                'short_break_minutes' => 5,
                'long_break_minutes' => 15,
                'work_cycles' => 4,
            ]);
            
            $this->command->info('System Pomodoro preset created successfully!');
        } else {
            $this->command->info('System preset already exists.');
        }
    }
}
