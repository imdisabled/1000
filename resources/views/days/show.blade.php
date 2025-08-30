@extends('layouts.app')

@section('title', 'Day {{ $day->day_number }} - 1000 Days Tracker')

@section('content')
<div class="card">
    <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 2rem; flex-wrap: wrap; gap: 1rem;">
        <div>
            <h1 style="color: var(--color-dark-blue); margin: 0 0 0.5rem 0;">Day {{ $day->day_number }}</h1>
            <div style="color: var(--color-medium-blue); font-size: 1.1rem;">
                {{ $day->date->format('F j, Y') }}
                @if($day->isToday())
                    <span style="background: var(--color-dark-blue); color: white; padding: 0.3rem 0.8rem; border-radius: 6px; font-size: 0.9rem; margin-left: 0.5rem;">TODAY</span>
                @elseif($day->isPastDue())
                    <span style="background: #ff6b6b; color: white; padding: 0.3rem 0.8rem; border-radius: 6px; font-size: 0.9rem; margin-left: 0.5rem;">OVERDUE</span>
                @elseif($day->isFuture())
                    <span style="background: var(--color-light-blue); color: var(--color-dark-blue); padding: 0.3rem 0.8rem; border-radius: 6px; font-size: 0.9rem; margin-left: 0.5rem;">UPCOMING</span>
                @endif
            </div>
        </div>
        
        <div style="display: flex; gap: 1rem; align-items: center;">
            <label class="checkbox-container" data-day-id="{{ $day->id }}" style="transform: scale(1.5);">
                <input type="checkbox" class="checkbox-input" {{ $day->is_completed ? 'checked' : '' }}>
                <div class="checkbox-circle"></div>
            </label>
        </div>
    </div>

    @if($day->is_completed)
        <div style="background: linear-gradient(135deg, rgba(162, 170, 219, 0.2), rgba(137, 138, 196, 0.1)); padding: 2rem; border-radius: var(--border-radius); border-left: 4px solid var(--color-dark-blue); margin-bottom: 2rem;">
            <h3 style="color: var(--color-dark-blue); margin-bottom: 1rem; display: flex; align-items: center;">
                <span style="font-size: 1.5rem; margin-right: 0.5rem;">✅</span>
                Completed!
            </h3>
            <p style="color: var(--color-medium-blue); margin-bottom: 0.5rem;">
                <strong>Completed on:</strong> {{ $day->completed_at->format('F j, Y \a\t g:i A') }}
            </p>
            <p style="color: var(--color-medium-blue);">
                <strong>Days ago:</strong> {{ $day->completed_at->diffForHumans() }}
            </p>
        </div>

        @if($day->quote)
            <div style="background: linear-gradient(135deg, var(--color-cream), rgba(162, 170, 219, 0.1)); padding: 2rem; border-radius: var(--border-radius); border-left: 4px solid var(--color-medium-blue); margin-bottom: 2rem;">
                <h3 style="color: var(--color-dark-blue); margin-bottom: 1rem; display: flex; align-items: center;">
                    <span style="font-size: 1.5rem; margin-right: 0.5rem;">💬</span>
                    Your Motivation Quote
                </h3>
                <blockquote style="font-size: 1.2rem; font-style: italic; color: var(--color-dark-blue); margin: 0; line-height: 1.6;">
                    "{{ $day->quote }}"
                </blockquote>
            </div>
        @endif
    @else
        @if($day->quote)
            <div style="background: linear-gradient(135deg, var(--color-cream), rgba(162, 170, 219, 0.1)); padding: 2rem; border-radius: var(--border-radius); border-left: 4px solid var(--color-medium-blue); margin-bottom: 2rem;">
                <h3 style="color: var(--color-dark-blue); margin-bottom: 1rem; display: flex; align-items: center;">
                    <span style="font-size: 1.5rem; margin-right: 0.5rem;">💬</span>
                    Your Motivation Quote
                </h3>
                <blockquote style="font-size: 1.2rem; font-style: italic; color: var(--color-dark-blue); margin: 0; line-height: 1.6;">
                    "{{ $day->quote }}"
                </blockquote>
            </div>
        @endif
    @endif

    <div style="background: rgba(255, 255, 255, 0.6); padding: 2rem; border-radius: var(--border-radius); margin-bottom: 2rem;">
        <h3 style="color: var(--color-dark-blue); margin-bottom: 1rem;">Progress Context</h3>
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1.5rem;">
            <div style="text-align: center;">
                <div style="font-size: 2rem; font-weight: 700; color: var(--color-dark-blue);">{{ $day->day_number }}</div>
                <div style="color: var(--color-medium-blue);">Day Number</div>
            </div>
            <div style="text-align: center;">
                <div style="font-size: 2rem; font-weight: 700; color: var(--color-dark-blue);">{{ 1000 - $day->day_number }}</div>
                <div style="color: var(--color-medium-blue);">Days Remaining</div>
            </div>
            <div style="text-align: center;">
                <div style="font-size: 2rem; font-weight: 700; color: var(--color-dark-blue);">{{ round(($day->day_number / 1000) * 100, 1) }}%</div>
                <div style="color: var(--color-medium-blue);">Journey Progress</div>
            </div>
        </div>
        
        <div style="margin-top: 2rem;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.5rem;">
                <span style="color: var(--color-medium-blue);">Overall Progress</span>
                <span style="color: var(--color-dark-blue); font-weight: 600;">{{ round(($day->day_number / 1000) * 100, 1) }}%</span>
            </div>
            <div class="progress-bar">
                <div class="progress-fill" style="width: {{ ($day->day_number / 1000) * 100 }}%"></div>
            </div>
        </div>
    </div>

    <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
        <div style="display: flex; gap: 1rem;">
            @if($day->day_number > 1)
                @php $previousDay = \App\Models\Day::where('day_number', $day->day_number - 1)->first(); @endphp
                @if($previousDay)
                    <a href="{{ route('days.show', $previousDay) }}" 
                       style="padding: 1rem 2rem; background: var(--color-light-blue); color: var(--color-dark-blue); text-decoration: none; border-radius: var(--border-radius); font-weight: 600; transition: all 0.3s ease; display: flex; align-items: center;">
                        <span style="margin-right: 0.5rem;">←</span> Day {{ $previousDay->day_number }}
                    </a>
                @endif
            @endif
            
            @if($day->day_number < 1000)
                @php $nextDay = \App\Models\Day::where('day_number', $day->day_number + 1)->first(); @endphp
                @if($nextDay)
                    <a href="{{ route('days.show', $nextDay) }}" 
                       style="padding: 1rem 2rem; background: var(--color-medium-blue); color: white; text-decoration: none; border-radius: var(--border-radius); font-weight: 600; transition: all 0.3s ease; display: flex; align-items: center;">
                        Day {{ $nextDay->day_number }} <span style="margin-left: 0.5rem;">→</span>
                    </a>
                @endif
            @endif
        </div>
        
        <a href="{{ route('days.index') }}" 
           style="padding: 1rem 2rem; background: rgba(255, 255, 255, 0.9); color: var(--color-dark-blue); text-decoration: none; border-radius: var(--border-radius); font-weight: 600; border: 2px solid var(--color-medium-blue); transition: all 0.3s ease;">
            ← Back to All Days
        </a>
    </div>
</div>

@if($day->is_completed && !$day->quote)
    <div style="background: linear-gradient(135deg, rgba(255, 193, 7, 0.1), rgba(255, 255, 255, 0.8)); padding: 2rem; border-radius: var(--border-radius); border-left: 4px solid #ffc107; margin-top: 2rem; text-align: center;">
        <h3 style="color: #f57c00; margin-bottom: 1rem;">🎉 Congratulations!</h3>
        <p style="color: #666; margin-bottom: 1rem;">
            You've completed this day! A motivational quote is being generated for you.
        </p>
        <div style="display: inline-block;" class="loading"></div>
    </div>
@endif
@endsection
