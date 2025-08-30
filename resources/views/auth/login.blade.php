@extends('layouts.app')

@section('content')
<div style="max-width: 500px; margin: 2rem auto; padding: 0 1rem;">
    <div class="card">
        <div style="text-align: center; margin-bottom: 2rem;">
            <h1 style="color: var(--color-dark-blue); font-size: 2.5rem; margin-bottom: 0.5rem;">Welcome Back!</h1>
            <p style="color: var(--color-medium-blue); font-size: 1.1rem;">Continue your 1000-day journey</p>
        </div>

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div style="margin-bottom: 1.5rem;">
                <label for="email" style="display: block; margin-bottom: 0.5rem; color: var(--color-dark-blue); font-weight: 600;">Email Address</label>
                <input id="email" type="email" 
                       class="form-control @error('email') is-invalid @enderror" 
                       name="email" 
                       value="{{ old('email') }}" 
                       required autocomplete="email" autofocus
                       style="width: 100%; padding: 1rem; border: 2px solid var(--color-light-blue); border-radius: var(--border-radius); font-size: 1rem; transition: all 0.3s ease;"
                       onfocus="this.style.borderColor='var(--color-medium-blue)'; this.style.boxShadow='0 0 0 3px rgba(162, 170, 219, 0.1)'"
                       onblur="this.style.borderColor='var(--color-light-blue)'; this.style.boxShadow='none'">

                @error('email')
                    <span style="color: #e53e3e; font-size: 0.9rem; margin-top: 0.5rem; display: block;">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div style="margin-bottom: 1.5rem;">
                <label for="password" style="display: block; margin-bottom: 0.5rem; color: var(--color-dark-blue); font-weight: 600;">Password</label>
                <input id="password" type="password" 
                       class="form-control @error('password') is-invalid @enderror" 
                       name="password" 
                       required autocomplete="current-password"
                       style="width: 100%; padding: 1rem; border: 2px solid var(--color-light-blue); border-radius: var(--border-radius); font-size: 1rem; transition: all 0.3s ease;"
                       onfocus="this.style.borderColor='var(--color-medium-blue)'; this.style.boxShadow='0 0 0 3px rgba(162, 170, 219, 0.1)'"
                       onblur="this.style.borderColor='var(--color-light-blue)'; this.style.boxShadow='none'">

                @error('password')
                    <span style="color: #e53e3e; font-size: 0.9rem; margin-top: 0.5rem; display: block;">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div style="margin-bottom: 1.5rem;">
                <label style="display: flex; align-items: center; cursor: pointer;">
                    <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}
                           style="margin-right: 0.5rem; transform: scale(1.2);">
                    <span style="color: var(--color-medium-blue);">Remember Me</span>
                </label>
            </div>

            <div style="margin-bottom: 1.5rem;">
                <button type="submit" 
                        style="width: 100%; padding: 1rem; background: linear-gradient(135deg, var(--color-dark-blue), var(--color-medium-blue)); color: white; border: none; border-radius: var(--border-radius); font-size: 1.1rem; font-weight: 600; cursor: pointer; transition: all 0.3s ease;"
                        onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 10px 25px rgba(137, 138, 196, 0.3)'"
                        onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 15px rgba(137, 138, 196, 0.2)'">
                    Login to Your Journey
                </button>
            </div>

            <div style="text-align: center;">
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" 
                       style="color: var(--color-medium-blue); text-decoration: none; font-weight: 500;">
                        Forgot Your Password?
                    </a>
                @endif
            </div>
        </form>

        <div style="text-align: center; margin-top: 2rem; padding-top: 2rem; border-top: 1px solid var(--color-light-blue);">
            <p style="color: var(--color-medium-blue); margin-bottom: 1rem;">Don't have an account yet?</p>
            <a href="{{ route('register') }}" 
               style="display: inline-block; padding: 0.8rem 2rem; background: linear-gradient(135deg, var(--color-cream), var(--color-light-blue)); color: var(--color-dark-blue); text-decoration: none; border-radius: var(--border-radius); font-weight: 600; transition: all 0.3s ease;"
               onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 8px 20px rgba(192, 201, 238, 0.3)'"
               onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 15px rgba(192, 201, 238, 0.2)'">
                Start Your 1000-Day Journey
            </a>
        </div>

        <div style="background: linear-gradient(135deg, rgba(255, 242, 224, 0.5), rgba(192, 201, 238, 0.3)); padding: 1.5rem; border-radius: var(--border-radius); margin-top: 2rem;">
            <h4 style="color: var(--color-dark-blue); margin-bottom: 1rem; text-align: center;">Demo Account</h4>
            <p style="color: var(--color-medium-blue); font-size: 0.9rem; text-align: center; margin-bottom: 1rem;">
                Try the demo with hezSec's account:
            </p>
            <div style="background: rgba(255, 255, 255, 0.7); padding: 1rem; border-radius: 8px; font-family: monospace; font-size: 0.9rem;">
                <strong>Email:</strong> hezSec@1000days.com<br>
                <strong>Password:</strong> password
            </div>
        </div>
    </div>
</div>
@endsection
