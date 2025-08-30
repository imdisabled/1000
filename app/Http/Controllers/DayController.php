<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Day;
use App\Models\User;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class DayController extends Controller
{
    public function index(Request $request)
    {
        // For guests, show hezSec's days (read-only)
        if (!auth()->check()) {
            $admin = User::where('name', 'hezSec')->first();
            $query = $admin ? $admin->days()->orderBy('day_number') : Day::where('id', -1); // Empty query if no hezSec
        } else {
            // For authenticated users, show their own days
            $query = auth()->user()->days()->orderBy('day_number');
        }
        
        $filter = $request->get('filter');
        
        switch ($filter) {
            case 'completed':
                $query->where('is_completed', true);
                break;
            case 'pending':
                $query->where('is_completed', false);
                break;
            case 'overdue':
                $query->where('date', '<', today())
                      ->where('is_completed', false);
                break;
        }
        
        $days = $query->paginate(50);
        
        // Generate quote for today's day if it doesn't have one
        foreach ($days as $day) {
            if (!$day->quote && $day->date->isToday()) {
                $this->generateDailyQuote($day);
                $day->refresh();
            }
        }
        
        $isGuest = !auth()->check();
        return view('days.index', compact('days', 'isGuest'));
    }

    public function show(Day $day)
    {
        // Check if user can view this day
        if (!auth()->check()) {
            // Guests can only view hezSec's days
            $admin = User::where('is_admin', true)->first();
            if (!$admin || $day->user_id !== $admin->id) {
                abort(404);
            }
        } else {
            // Users can only view their own days
            if ($day->user_id !== auth()->id()) {
                abort(403);
            }
        }
        
        // Generate quote for this day if it doesn't have one
        if (!$day->quote) {
            $this->generateDailyQuote($day);
            $day->refresh(); // Reload to get the new quote
        }
        
        $isGuest = !auth()->check();
        return view('days.show', compact('day', 'isGuest'));
    }

    public function toggle(Day $day)
    {
        // Only authenticated users can toggle their own days
        if (!auth()->check() || $day->user_id !== auth()->id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        if ($day->is_completed) {
            $day->markIncomplete();
        } else {
            $day->markCompleted();
            // If day doesn't have a quote yet, generate daily quote instead of completion quote
            if (!$day->quote) {
                $this->generateDailyQuote($day);
            }
        }

        return response()->json([
            'success' => true,
            'is_completed' => $day->is_completed,
            'completed_at' => $day->completed_at?->format('Y-m-d H:i:s'),
            'quote' => $day->quote
        ]);
    }

    private function generateQuote(Day $day)
    {
        try {
            // Replace with your actual n8n webhook URL
            $n8nUrl = env('N8N_WEBHOOK_URL', 'https://your-n8n-domain.com/webhook/generate-quote');
            
            $response = Http::timeout(10)->post($n8nUrl, [
                'day_number' => $day->day_number,
                'date' => $day->date->format('Y-m-d'),
                'task' => $day->task_description
            ]);

            if ($response->successful()) {
                $quote = $response->json('quote') ?? 'Great job completing day ' . $day->day_number . '!';
                $day->update(['quote' => $quote]);
            }
        } catch (\Exception $e) {
            // Fallback quote if n8n is unavailable
            $day->update(['quote' => 'Congratulations on completing day ' . $day->day_number . '! Keep up the great work!']);
        }
    }

    private function generateDailyQuote(Day $day)
    {
        try {
            // Use your n8n webhook URL for daily quotes
            $n8nUrl = 'https://n8n.hamza.onl/webhook/bc02423d-5df1-4823-b058-30ae2b90b9c7';
            
            Log::info('Calling n8n webhook for day ' . $day->day_number, [
                'url' => $n8nUrl,
                'data' => [
                    'day_number' => $day->day_number,
                    'date' => $day->date->format('Y-m-d'),
                    'type' => 'daily_motivation',
                    'user_name' => $day->user->name ?? 'User'
                ]
            ]);
            
            $response = Http::timeout(10)->post($n8nUrl, [
                'day_number' => $day->day_number,
                'date' => $day->date->format('Y-m-d'),
                'type' => 'daily_motivation', // Indicate this is for daily motivation, not completion
                'user_name' => $day->user->name ?? 'User'
            ]);

            Log::info('n8n webhook response', [
                'status' => $response->status(),
                'body' => $response->body(),
                'successful' => $response->successful()
            ]);

            if ($response->successful()) {
                $json = $response->json();
                if (is_array($json) && isset($json[0]['quote'])) {
                    $quote = $json[0]['quote'];
                } else {
                    $quote = $response->json('quote') ?? 'Today is day ' . $day->day_number . ' of your journey. Make it count!';
                }
                Log::info('Extracted quote from response', ['quote' => $quote, 'response_body' => $response->body()]);
                $day->update(['quote' => $quote]);
                Log::info('Day updated', ['day_id' => $day->id, 'quote_after_update' => $day->fresh()->quote]);
            } else {
                Log::warning('n8n webhook failed', ['status' => $response->status(), 'body' => $response->body()]);
            }
        } catch (\Exception $e) {
            Log::error('Exception calling n8n webhook', ['error' => $e->getMessage()]);
            // Fallback quote if n8n is unavailable
            $motivationalQuotes = [
                'Every day is a new opportunity to grow and improve yourself.',
                'Small progress is still progress. Keep moving forward!',
                'Today is day ' . $day->day_number . ' of your transformation journey.',
                'Focus on being better than you were yesterday.',
                'Your future self will thank you for the effort you put in today.',
                'Consistency is the key to achieving your dreams.',
                'Each day brings you one step closer to your goals.',
                'Believe in yourself and your ability to create positive change.',
            ];
            
            $randomQuote = $motivationalQuotes[array_rand($motivationalQuotes)];
            Log::info('Using fallback quote', ['quote' => $randomQuote, 'day_id' => $day->id]);
            $day->update(['quote' => $randomQuote]);
            Log::info('Fallback update result', ['day_id' => $day->id, 'quote_after_update' => $day->fresh()->quote]);
        }
    }

    public function dashboard()
    {
        $totalDays = 1000;
        
        // For guests, show hezSec's progress
        if (!auth()->check()) {
            $admin = User::where('name', 'hezSec')->first();
            if (!$admin) {
                return view('welcome'); // Show a welcome page if no hezSec exists
            }
            
            $completedDays = $admin->days()->where('is_completed', true)->count();
            $todayDay = $admin->days()->whereDate('date', today())->first();
            
            // Generate quote for today's day if it doesn't have one
            if ($todayDay && !$todayDay->quote) {
                $this->generateDailyQuote($todayDay);
                $todayDay->refresh(); // Reload to get the new quote
            }
            
            $overdueDays = $admin->days()->where('date', '<', today())
                                 ->where('is_completed', false)
                                 ->count();
            $upcomingDays = $admin->days()->where('date', '>', today())
                                  ->orderBy('date')
                                  ->limit(7)
                                  ->get();
            
            return view('dashboard', compact('totalDays', 'completedDays', 'todayDay', 'overdueDays', 'upcomingDays'))->with('isGuest', true)->with('adminName', $admin->name);
        }
        
        // For authenticated users, show their own progress
        $user = auth()->user();
        
        // If user has no days, create them
        if ($user->days()->count() === 0) {
            $this->createDaysForUser($user);
        }
        
        $completedDays = $user->days()->where('is_completed', true)->count();
        $todayDay = $user->days()->whereDate('date', today())->first();
        
        // Generate quote for today's day if it doesn't have one
        if ($todayDay && !$todayDay->quote) {
            $this->generateDailyQuote($todayDay);
            $todayDay->refresh(); // Reload to get the new quote
        }
        
        $overdueDays = $user->days()->where('date', '<', today())
                            ->where('is_completed', false)
                            ->count();
        $upcomingDays = $user->days()->where('date', '>', today())
                             ->orderBy('date')
                             ->limit(7)
                             ->get();

        return view('dashboard', compact('totalDays', 'completedDays', 'todayDay', 'overdueDays', 'upcomingDays'))->with('isGuest', false);
    }

    private function createDaysForUser($user)
    {
        $startDate = today();
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

        $batch = [];
        for ($i = 1; $i <= 1000; $i++) {
            $batch[] = [
                'user_id' => $user->id,
                'day_number' => $i,
                'date' => $startDate->copy()->addDays($i - 1),
                'task_description' => $tasks[($i - 1) % count($tasks)],
                'is_completed' => false,
                'created_at' => now(),
                'updated_at' => now()
            ];

            if (count($batch) >= 100) {
                Day::insert($batch);
                $batch = [];
            }
        }
        
        if (!empty($batch)) {
            Day::insert($batch);
        }
    }

    public function regenerateQuote(Request $request)
    {
        Log::info('Regenerate quote method called', ['user' => auth()->user()->name ?? 'guest']);
        
        if (!auth()->check() || !auth()->user()->is_admin) {
            Log::warning('Unauthorized access to regenerate quote', ['user' => auth()->user()->name ?? 'guest']);
            abort(403, 'Unauthorized');
        }

        $user = auth()->user();
        $todayDay = $user->days()->whereDate('date', today())->first();
        
        Log::info('Today day lookup', ['found' => $todayDay ? 'yes' : 'no', 'day_id' => $todayDay->id ?? null]);

        if (!$todayDay) {
            // If no day for today, create it
            $this->createDaysForUser($user);
            $todayDay = $user->days()->whereDate('date', today())->first();
            Log::info('Created today day', ['day_id' => $todayDay->id ?? null]);
        }

        // Force regenerate the quote
        $this->generateDailyQuote($todayDay);
        $todayDay->refresh();

        Log::info('Regenerate quote completed', ['quote' => $todayDay->quote]);

        return redirect()->route('dashboard')->with('success', 'Quote regenerated successfully!');
    }
}
