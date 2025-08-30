<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Day;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

class DaySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create or update hezSec as the admin user
        $user = User::firstOrCreate(
            ['name' => 'hezSec'],
            [
                'email' => 'hezsec@1000.fit',
                'password' => Hash::make('kingdomFall##66'),
                'is_admin' => true
            ]
        );

        // Ensure hezSec is the only admin
        User::where('id', '!=', $user->id)->update(['is_admin' => false]);

        // Delete existing days for hezSec to start fresh
        Day::where('user_id', $user->id)->delete();

        $startDate = Carbon::today()->subDays(999); // Start 999 days ago for day 1 today
        
        $tasks = [
            'Complete morning workout routine',
            'Read 30 pages of a good book',
            'Practice meditation for 20 minutes',
            'Learn something new in your field',
            'Write in your journal',
            'Connect with a friend or family member',
            'Organize and clean your workspace',
            'Plan and prepare healthy meals',
            'Practice a new skill or hobby',
            'Review and update your goals',
            'Take a nature walk or exercise outdoors',
            'Complete an important work project',
            'Learn a new programming concept',
            'Practice gratitude exercises',
            'Declutter and organize your living space',
            'Create something artistic or creative',
            'Network with professionals in your field',
            'Volunteer or help someone in need',
            'Practice public speaking or presentation skills',
            'Research and plan your next career move',
            'Complete a challenging physical activity',
            'Learn about financial planning and investing',
            'Practice mindfulness throughout the day',
            'Complete an online course or tutorial',
            'Build or improve a personal project',
            'Practice time management techniques',
            'Study a new language for 30 minutes',
            'Complete a home improvement task',
            'Practice leadership skills',
            'Review and optimize your daily routines'
        ];

        for ($i = 1; $i <= 1000; $i++) {
            Day::create([
                'user_id' => $user->id,
                'day_number' => $i,
                'date' => $startDate->copy()->addDays($i - 1),
                'task_description' => $tasks[($i - 1) % count($tasks)],
                'is_completed' => false
            ]);
        }
    }
}
