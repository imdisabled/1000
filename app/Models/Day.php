<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Day extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'day_number',
        'date',
        'task_description',
        'is_completed',
        'completed_at',
        'quote'
    ];

    protected $casts = [
        'date' => 'date',
        'is_completed' => 'boolean',
        'completed_at' => 'datetime'
    ];

    public function markCompleted()
    {
        $this->update([
            'is_completed' => true,
            'completed_at' => now()
        ]);
    }

    public function markIncomplete()
    {
        $this->update([
            'is_completed' => false,
            'completed_at' => null
        ]);
    }

    public function isPastDue()
    {
        return $this->date->isPast() && !$this->is_completed;
    }

    public function isToday()
    {
        return $this->date->isToday();
    }

    public function isFuture()
    {
        return $this->date->isFuture();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
