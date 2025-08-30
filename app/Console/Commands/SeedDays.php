<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SeedDays extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'seed:days';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Seed the days table with 1000 days of tasks';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting to seed 1000 days...');
        
        $startDate = Carbon::today();
        
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

        // Clear existing data
        DB::table('days')->truncate();

        // Insert in batches for better performance
        $batchSize = 100;
        $batches = [];
        
        for ($i = 1; $i <= 1000; $i++) {
            $batches[] = [
                'day_number' => $i,
                'date' => $startDate->copy()->addDays($i - 1)->format('Y-m-d'),
                'task_description' => $tasks[($i - 1) % count($tasks)],
                'is_completed' => false,
                'created_at' => now(),
                'updated_at' => now()
            ];

            if (count($batches) >= $batchSize || $i == 1000) {
                DB::table('days')->insert($batches);
                $batches = [];
                $this->info("Inserted days " . max(1, $i - $batchSize + 1) . " to $i");
            }
        }

        $this->info('Successfully seeded 1000 days!');
        return 0;
    }
}
