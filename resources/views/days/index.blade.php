@extends('layouts.app')

@section('title', 'All Days - 1000 Days Tracker')

@section('content')
@if(isset($isGuest) && $isGuest)
    <div class="card" style="background: linear-gradient(135deg, rgba(255, 193, 7, 0.1), rgba(255, 255, 255, 0.9)); border-left: 4px solid #ffc107; margin-bottom: 2rem;">
        <h3 style="color: #f57c00; margin-bottom: 1rem;">👁️ Guest View</h3>
        <p style="color: #666;">
            You're viewing hezSec's days in read-only mode. 
            <a href="{{ route('register') }}" style="color: var(--color-dark-blue); font-weight: 600;">Create an account</a> to start your own 1000-day journey!
        </p>
    </div>
@endif

<div class="card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; flex-wrap: wrap; gap: 1rem;">
        <h2 style="color: var(--color-dark-blue); margin: 0;">All Days ({{ $days->total() }} total)</h2>
        
        <div style="display: flex; gap: 1rem; flex-wrap: wrap;">
            <a href="{{ route('days.index') }}" 
               class="{{ !request('filter') ? 'active' : '' }}"
               style="padding: 0.5rem 1rem; background: {{ !request('filter') ? 'var(--color-medium-blue)' : 'rgba(255,255,255,0.9)' }}; color: {{ !request('filter') ? 'white' : 'var(--color-dark-blue)' }}; text-decoration: none; border-radius: var(--border-radius); font-weight: 600; transition: all 0.3s ease;">
                All
            </a>
            <a href="{{ route('days.index', ['filter' => 'completed']) }}" 
               class="{{ request('filter') === 'completed' ? 'active' : '' }}"
               style="padding: 0.5rem 1rem; background: {{ request('filter') === 'completed' ? 'var(--color-medium-blue)' : 'rgba(255,255,255,0.9)' }}; color: {{ request('filter') === 'completed' ? 'white' : 'var(--color-dark-blue)' }}; text-decoration: none; border-radius: var(--border-radius); font-weight: 600; transition: all 0.3s ease;">
                Completed
            </a>
            <a href="{{ route('days.index', ['filter' => 'pending']) }}" 
               class="{{ request('filter') === 'pending' ? 'active' : '' }}"
               style="padding: 0.5rem 1rem; background: {{ request('filter') === 'pending' ? 'var(--color-medium-blue)' : 'rgba(255,255,255,0.9)' }}; color: {{ request('filter') === 'pending' ? 'white' : 'var(--color-dark-blue)' }}; text-decoration: none; border-radius: var(--border-radius); font-weight: 600; transition: all 0.3s ease;">
                Pending
            </a>
            <a href="{{ route('days.index', ['filter' => 'overdue']) }}" 
               class="{{ request('filter') === 'overdue' ? 'active' : '' }}"
               style="padding: 0.5rem 1rem; background: {{ request('filter') === 'overdue' ? '#ff6b6b' : 'rgba(255,255,255,0.9)' }}; color: {{ request('filter') === 'overdue' ? 'white' : '#ff6b6b' }}; text-decoration: none; border-radius: var(--border-radius); font-weight: 600; transition: all 0.3s ease;">
                Overdue
            </a>
        </div>
    </div>

    @if($days->count() > 0)
        <div class="days-list">
            @foreach($days as $day)
                <div class="day-item {{ $day->is_completed ? 'completed' : ($day->isPastDue() ? 'past-due' : '') }} fade-in">
                    <label class="checkbox-container" data-day-id="{{ $day->id }}">
                        <input type="checkbox" class="checkbox-input" {{ $day->is_completed ? 'checked' : '' }} {{ (isset($isGuest) && $isGuest) ? 'disabled' : '' }}>
                        <div class="checkbox-circle" {{ (isset($isGuest) && $isGuest) ? 'style="opacity: 0.6; cursor: not-allowed;"' : '' }}></div>
                    </label>
                    <div class="day-info">
                        <div class="day-number">Day {{ $day->day_number }}</div>
                        <div class="day-date">
                            {{ $day->date->format('F j, Y') }}
                            @if($day->isToday())
                                <span style="background: var(--color-dark-blue); color: white; padding: 0.2rem 0.5rem; border-radius: 4px; font-size: 0.8rem; margin-left: 0.5rem;">TODAY</span>
                            @elseif($day->isPastDue())
                                <span style="background: #ff6b6b; color: white; padding: 0.2rem 0.5rem; border-radius: 4px; font-size: 0.8rem; margin-left: 0.5rem;">OVERDUE</span>
                            @elseif($day->isFuture())
                                <span style="background: var(--color-light-blue); color: var(--color-dark-blue); padding: 0.2rem 0.5rem; border-radius: 4px; font-size: 0.8rem; margin-left: 0.5rem;">UPCOMING</span>
                            @endif
                        </div>
                        @if($day->completed_at)
                            <div style="font-size: 0.9rem; color: var(--color-medium-blue); margin-top: 0.5rem;">
                                ✓ Completed on {{ $day->completed_at->format('M j, Y \a\t g:i A') }}
                            </div>
                        @endif
                    </div>
                    <div class="day-actions" style="margin-left: auto; display: flex; align-items: center; gap: 1rem;">
                        @if($day->quote)
                            <div class="day-quote shift-left">{{ $day->quote }}</div>
                        @endif
                        <a href="{{ route('days.show', $day) }}" 
                           style="padding: 0.5rem 1rem; background: rgba(162, 170, 219, 0.2); color: var(--color-dark-blue); text-decoration: none; border-radius: var(--border-radius); font-size: 0.9rem; transition: all 0.3s ease;">
                            View Details
                        </a>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="pagination">
            {{ $days->appends(request()->query())->links('pagination::simple-bootstrap-4') }}
        </div>
    @else
        <div style="text-align: center; padding: 3rem; color: var(--color-medium-blue);">
            <div style="font-size: 3rem; margin-bottom: 1rem;">📅</div>
            <h3>No days found</h3>
            <p>Try adjusting your filter or check back later.</p>
        </div>
    @endif
</div>

<div class="card" style="background: linear-gradient(135deg, var(--color-cream), var(--color-light-blue)); text-align: center;">
    <h3 style="color: var(--color-dark-blue); margin-bottom: 1rem;">Quick Stats</h3>
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 1rem;">
        <div>
            <div style="font-size: 2rem; font-weight: 700; color: var(--color-dark-blue);">{{ \App\Models\Day::where('is_completed', true)->count() }}</div>
            <div style="color: var(--color-medium-blue);">Completed</div>
        </div>
        <div>
            <div style="font-size: 2rem; font-weight: 700; color: #ff6b6b;">{{ \App\Models\Day::where('date', '<', today())->where('is_completed', false)->count() }}</div>
            <div style="color: var(--color-medium-blue);">Overdue</div>
        </div>
        <div>
            <div style="font-size: 2rem; font-weight: 700; color: var(--color-medium-blue);">{{ \App\Models\Day::where('date', '>', today())->count() }}</div>
            <div style="color: var(--color-medium-blue);">Upcoming</div>
        </div>
        <div>
            <div style="font-size: 2rem; font-weight: 700; color: var(--color-dark-blue);">{{ round((\App\Models\Day::where('is_completed', true)->count() / 1000) * 100, 1) }}%</div>
            <div style="color: var(--color-medium-blue);">Progress</div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Add staggered animation to day items
    document.addEventListener('DOMContentLoaded', function() {
        const dayItems = document.querySelectorAll('.day-item');
        dayItems.forEach((item, index) => {
            item.style.animationDelay = `${index * 0.05}s`;
        });
    });
</script>
@endsection
