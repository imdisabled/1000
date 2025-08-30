@extends('layouts.app')

@section('title', 'Dashboard - 1000 Days Tracker')

@section('content')
@if(isset($isGuest) && $isGuest)
    <div class="card" style="background: linear-gradient(135deg, rgba(255, 193, 7, 0.1), rgba(255, 255, 255, 0.9)); border-left: 4px solid #ffc107; margin-bottom: 2rem;">
        <h2 style="color: #f57c00; margin-bottom: 1rem; display: flex; align-items: center;">
            <span style="font-size: 1.5rem; margin-right: 0.5rem;">👁️</span>
            Viewing hezSec's Progress
        </h2>
        <p style="color: #666; margin-bottom: 1rem;">
            You're currently viewing hezSec's 1000-day journey as a guest. 
            <a href="{{ route('register') }}" style="color: var(--color-dark-blue); font-weight: 600;">Register</a> or 
            <a href="{{ route('login') }}" style="color: var(--color-dark-blue); font-weight: 600;">Login</a> to start your own journey!
        </p>
    </div>
@endif

@if(session('success'))
    <div class="card" style="background: linear-gradient(135deg, rgba(40, 167, 69, 0.1), rgba(255, 255, 255, 0.9)); border-left: 4px solid #28a745; margin-bottom: 2rem;">
        <p style="color: #155724; margin: 0; font-weight: 600;">✅ {{ session('success') }}</p>
    </div>
@endif

<div class="stats-grid">
    <div class="stat-card">
        <span class="stat-number">{{ $completedDays }}</span>
        <div class="stat-label">Days Completed</div>
    </div>
    <div class="stat-card">
        <span class="stat-number">{{ $totalDays - $completedDays }}</span>
        <div class="stat-label">Days Remaining</div>
    </div>
    <div class="stat-card">
        <span class="stat-number">{{ $overdueDays }}</span>
        <div class="stat-label">Overdue Days</div>
    </div>
    <div class="stat-card">
        <span class="stat-number">{{ round(($completedDays / $totalDays) * 100, 1) }}%</span>
        <div class="stat-label">Progress</div>
    </div>
</div>

<div class="card">
    <h2 style="color: var(--color-dark-blue); margin-bottom: 1rem;">Overall Progress</h2>
    <div class="progress-bar">
        <div class="progress-fill" style="width: {{ ($completedDays / $totalDays) * 100 }}%"></div>
    </div>
    <p style="text-align: center; color: var(--color-medium-blue); margin-top: 0.5rem;">
        {{ $completedDays }} of {{ $totalDays }} days completed
    </p>
</div>

@if($todayDay)
<div class="card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
        <h2 style="color: var(--color-dark-blue); margin: 0;">
            @if(isset($isGuest) && $isGuest)
                hezSec's Today's Challenge
            @else
                Today's Challenge
            @endif
        </h2>
        @if(auth()->check() && auth()->user()->is_admin && !$isGuest)
            <form method="POST" action="{{ route('days.regenerate-quote') }}" style="margin: 0;">
                @csrf
                <button type="submit" style="padding: 0.5rem 1rem; background: var(--color-medium-blue); color: white; border: none; border-radius: var(--border-radius); font-size: 0.9rem; cursor: pointer; transition: all 0.3s ease;">
                    Regenerate Quote
                </button>
            </form>
        @endif
    </div>
    <div class="day-item {{ $todayDay->is_completed ? 'completed' : ($todayDay->isPastDue() ? 'past-due' : '') }}">
        <label class="checkbox-container" data-day-id="{{ $todayDay->id }}">
            <input type="checkbox" class="checkbox-input" {{ $todayDay->is_completed ? 'checked' : '' }} {{ (isset($isGuest) && $isGuest) ? 'disabled' : '' }}>
            <div class="checkbox-circle" {{ (isset($isGuest) && $isGuest) ? 'style="opacity: 0.6; cursor: not-allowed;"' : '' }}></div>
        </label>
        <div class="day-info">
            <div class="day-number">Day {{ $todayDay->day_number }}</div>
            <div class="day-date">{{ $todayDay->date->format('F j, Y') }}</div>
            <div style="color: var(--color-medium-blue); font-style: italic; margin-top: 0.5rem;">
                @if($todayDay->quote)
                    {{ $todayDay->quote }}
                @else
                    What progress will you make today?
                @endif
            </div>
        </div>
    </div>
</div>
@endif

@if($overdueDays > 0)
<div class="card">
    <h2 style="color: #ff6b6b; margin-bottom: 1.5rem;">Overdue Days ({{ $overdueDays }})</h2>
    <p style="color: var(--color-medium-blue); margin-bottom: 1rem;">
        Don't worry! You can still reflect on these days. Every step forward counts towards your personal growth.
    </p>
    <a href="{{ route('days.index', ['filter' => 'overdue']) }}" 
       style="display: inline-block; padding: 1rem 2rem; background: linear-gradient(135deg, #ff6b6b, #ff5722); color: white; text-decoration: none; border-radius: var(--border-radius); font-weight: 600; transition: all 0.3s ease;">
        View Overdue Days
    </a>
</div>
@endif

@if($upcomingDays->count() > 0)
<div class="card">
    <h2 style="color: var(--color-dark-blue); margin-bottom: 1.5rem;">Upcoming Days</h2>
    @foreach($upcomingDays as $day)
        <div class="day-item">
            <label class="checkbox-container" data-day-id="{{ $day->id }}">
                <input type="checkbox" class="checkbox-input" disabled>
                <div class="checkbox-circle" style="opacity: 0.5;"></div>
            </label>
            <div class="day-info">
                <div class="day-number">Day {{ $day->day_number }}</div>
                <div class="day-date">{{ $day->date->format('F j, Y') }} ({{ $day->date->diffForHumans() }})</div>
            </div>
        </div>
    @endforeach
</div>
@endif

<div class="card" style="text-align: center; background: linear-gradient(135deg, var(--color-light-blue), var(--color-cream));">
    <h3 style="color: var(--color-dark-blue); margin-bottom: 1rem;">
        "The journey of a thousand miles begins with one step."
    </h3>
    <p style="color: var(--color-medium-blue);">
        Keep going! Every day completed is a victory worth celebrating.
    </p>
</div>
@endsection
