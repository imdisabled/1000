@extends('layouts.app')

@section('title', 'Register - 1000 Days Tracker')

@section('content')
<div class="card" style="max-width: 500px; margin: 0 auto;">
    <h2 style="color: var(--color-dark-blue); margin-bottom: 1rem; text-align: center;">Start Your Journey!</h2>
    <p style="color: var(--color-medium-blue); text-align: center; margin-bottom: 2rem;">
        Create your account and begin your personal 1000-day transformation
    </p>
    
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div style="margin-bottom: 1.5rem;">
            <label for="name" style="display: block; margin-bottom: 0.5rem; color: var(--color-dark-blue); font-weight: 600;">
                Your Name
            </label>
            <input id="name" type="text" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus
                   style="width: 100%; padding: 1rem; border: 2px solid var(--color-light-blue); border-radius: var(--border-radius); font-size: 1rem; transition: all 0.3s ease;"
                   class="@error('name') error @enderror"
                   onfocus="this.style.borderColor='var(--color-medium-blue)'; this.style.boxShadow='0 0 0 3px rgba(162, 170, 219, 0.1)'"
                   onblur="this.style.borderColor='var(--color-light-blue)'; this.style.boxShadow='none'">

            @error('name')
                <div style="color: #ff6b6b; font-size: 0.9rem; margin-top: 0.5rem;">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div style="margin-bottom: 1.5rem;">
            <label for="email" style="display: block; margin-bottom: 0.5rem; color: var(--color-dark-blue); font-weight: 600;">
                Email Address
            </label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="email"
                   style="width: 100%; padding: 1rem; border: 2px solid var(--color-light-blue); border-radius: var(--border-radius); font-size: 1rem; transition: all 0.3s ease;"
                   class="@error('email') error @enderror"
                   onfocus="this.style.borderColor='var(--color-medium-blue)'; this.style.boxShadow='0 0 0 3px rgba(162, 170, 219, 0.1)'"
                   onblur="this.style.borderColor='var(--color-light-blue)'; this.style.boxShadow='none'">

            @error('email')
                <div style="color: #ff6b6b; font-size: 0.9rem; margin-top: 0.5rem;">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div style="margin-bottom: 1.5rem;">
            <label for="password" style="display: block; margin-bottom: 0.5rem; color: var(--color-dark-blue); font-weight: 600;">
                Password
            </label>
            <input id="password" type="password" name="password" required autocomplete="new-password"
                   style="width: 100%; padding: 1rem; border: 2px solid var(--color-light-blue); border-radius: var(--border-radius); font-size: 1rem; transition: all 0.3s ease;"
                   class="@error('password') error @enderror"
                   onfocus="this.style.borderColor='var(--color-medium-blue)'; this.style.boxShadow='0 0 0 3px rgba(162, 170, 219, 0.1)'"
                   onblur="this.style.borderColor='var(--color-light-blue)'; this.style.boxShadow='none'">

            @error('password')
                <div style="color: #ff6b6b; font-size: 0.9rem; margin-top: 0.5rem;">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div style="margin-bottom: 1.5rem;">
            <label for="password-confirm" style="display: block; margin-bottom: 0.5rem; color: var(--color-dark-blue); font-weight: 600;">
                Confirm Password
            </label>
            <input id="password-confirm" type="password" name="password_confirmation" required autocomplete="new-password"
                   style="width: 100%; padding: 1rem; border: 2px solid var(--color-light-blue); border-radius: var(--border-radius); font-size: 1rem; transition: all 0.3s ease;"
                   onfocus="this.style.borderColor='var(--color-medium-blue)'; this.style.boxShadow='0 0 0 3px rgba(162, 170, 219, 0.1)'"
                   onblur="this.style.borderColor='var(--color-light-blue)'; this.style.boxShadow='none'">
        </div>

        <div style="margin-bottom: 1.5rem;">
            <button type="submit" 
                    style="width: 100%; padding: 1rem 2rem; background: linear-gradient(135deg, var(--color-medium-blue), var(--color-dark-blue)); color: white; border: none; border-radius: var(--border-radius); font-size: 1rem; font-weight: 600; cursor: pointer; transition: all 0.3s ease;"
                    onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='var(--shadow-medium)'"
                    onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none'">
                Begin My 1000-Day Journey
            </button>
        </div>

        <div style="text-align: center;">
            <a href="{{ route('login') }}" 
               style="color: var(--color-medium-blue); text-decoration: none;">
                Already have an account? Login here
            </a>
        </div>
    </form>
</div>

<div class="card" style="max-width: 500px; margin: 2rem auto 0; text-align: center; background: linear-gradient(135deg, var(--color-cream), var(--color-light-blue));">
    <h3 style="color: var(--color-dark-blue); margin-bottom: 1rem;">🎯 What You'll Get</h3>
    <div style="text-align: left;">
        <div style="margin-bottom: 1rem; display: flex; align-items: center;">
            <span style="font-size: 1.5rem; margin-right: 1rem;">✨</span>
            <span style="color: var(--color-dark-blue);">Your personal 1000-day tracking system</span>
        </div>
        <div style="margin-bottom: 1rem; display: flex; align-items: center;">
            <span style="font-size: 1.5rem; margin-right: 1rem;">🎨</span>
            <span style="color: var(--color-dark-blue);">Beautiful, modern interface with progress tracking</span>
        </div>
        <div style="margin-bottom: 1rem; display: flex; align-items: center;">
            <span style="font-size: 1.5rem; margin-right: 1rem;">🤖</span>
            <span style="color: var(--color-dark-blue);">AI-powered motivational quotes</span>
        </div>
        <div style="display: flex; align-items: center;">
            <span style="font-size: 1.5rem; margin-right: 1rem;">📈</span>
            <span style="color: var(--color-dark-blue);">Complete progress analytics and insights</span>
        </div>
    </div>
</div>
@endsection
