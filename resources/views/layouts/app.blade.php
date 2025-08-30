<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/x-icon" href="/favicon_io/favicon.ico">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon_io/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon_io/favicon-16x16.png">
    <link rel="apple-touch-icon" href="/favicon_io/apple-touch-icon.png">
    <link rel="manifest" href="/favicon_io/site.webmanifest">
    <title>@yield('title', '1000 Days Tracker')</title>
    <style>
        :root {
            --color-cream: #FFF2E0;
            --color-light-blue: #C0C9EE;
            --color-medium-blue: #A2AADB;
            --color-dark-blue: #898AC4;
            --shadow-soft: 0 4px 20px rgba(137, 138, 196, 0.1);
            --shadow-medium: 0 8px 30px rgba(137, 138, 196, 0.15);
            --border-radius: 12px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, var(--color-cream) 0%, var(--color-light-blue) 100%);
            min-height: 100vh;
            color: #333;
            line-height: 1.6;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem;
        }

        .header {
            text-align: center;
            margin-bottom: 3rem;
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(10px);
            padding: 2rem;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow-soft);
        }

        .header h1 {
            color: var(--color-dark-blue);
            font-size: 3rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .header p {
            color: var(--color-medium-blue);
            font-size: 1.2rem;
        }

        .nav {
            display: flex;
            justify-content: center;
            gap: 1rem;
            margin-bottom: 2rem;
        }

        .nav a {
            padding: 1rem 2rem;
            background: rgba(255, 255, 255, 0.9);
            color: var(--color-dark-blue);
            text-decoration: none;
            border-radius: var(--border-radius);
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: var(--shadow-soft);
        }

        .nav a:hover, .nav a.active {
            background: var(--color-medium-blue);
            color: white;
            transform: translateY(-2px);
            box-shadow: var(--shadow-medium);
        }

        .card {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border-radius: var(--border-radius);
            padding: 2rem;
            box-shadow: var(--shadow-soft);
            margin-bottom: 2rem;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
            margin-bottom: 3rem;
        }

        .stat-card {
            background: linear-gradient(135deg, var(--color-light-blue), var(--color-medium-blue));
            color: white;
            padding: 2rem;
            border-radius: var(--border-radius);
            text-align: center;
            box-shadow: var(--shadow-medium);
            transition: transform 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-5px);
        }

        .stat-number {
            font-size: 3rem;
            font-weight: 700;
            display: block;
        }

        .stat-label {
            font-size: 1.1rem;
            opacity: 0.9;
            margin-top: 0.5rem;
        }

        /* Modern Circular Checkbox */
        .checkbox-container {
            display: inline-flex;
            align-items: center;
            cursor: pointer;
            user-select: none;
            margin-right: 1rem;
        }

        .checkbox-input {
            opacity: 0;
            position: absolute;
            pointer-events: none;
        }

        .checkbox-circle {
            width: 24px;
            height: 24px;
            border: 3px solid var(--color-medium-blue);
            border-radius: 50%;
            position: relative;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            display: flex;
            align-items: center;
            justify-content: center;
            background: white;
        }

        .checkbox-circle::after {
            content: '';
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background: var(--color-dark-blue);
            transform: scale(0);
            transition: transform 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .checkbox-input:checked + .checkbox-circle {
            border-color: var(--color-dark-blue);
            background: linear-gradient(135deg, var(--color-medium-blue), var(--color-dark-blue));
            box-shadow: 0 0 20px rgba(137, 138, 196, 0.4);
        }

        .checkbox-input:checked + .checkbox-circle::after {
            transform: scale(1);
            background: white;
        }

        .checkbox-container:hover .checkbox-circle {
            border-color: var(--color-dark-blue);
            box-shadow: 0 0 15px rgba(137, 138, 196, 0.3);
        }

        .day-item {
            display: flex;
            align-items: center;
            padding: 1.5rem;
            background: rgba(255, 255, 255, 0.7);
            border-radius: var(--border-radius);
            margin-bottom: 1rem;
            transition: all 0.3s ease;
            border-left: 4px solid var(--color-medium-blue);
        }

        .day-item:hover {
            background: rgba(255, 255, 255, 0.9);
            transform: translateX(5px);
            box-shadow: var(--shadow-medium);
        }

        .day-item.completed {
            border-left-color: var(--color-dark-blue);
            background: linear-gradient(90deg, rgba(162, 170, 219, 0.1), rgba(255, 255, 255, 0.7));
        }

        .day-item.past-due {
            border-left-color: #ff6b6b;
            background: linear-gradient(90deg, rgba(255, 107, 107, 0.1), rgba(255, 255, 255, 0.7));
        }

        .day-info {
            flex: 1;
            margin-left: 1rem;
        }

        .day-number {
            font-weight: 700;
            color: var(--color-dark-blue);
            font-size: 1.2rem;
        }

        .day-date {
            color: var(--color-medium-blue);
            font-size: 0.9rem;
            margin: 0.25rem 0;
        }

        .day-task {
            color: #555;
            font-size: 1rem;
        }

        .day-quote {
            font-style: italic;
            color: var(--color-dark-blue);
            padding: 0.5rem;
            background: rgba(162, 170, 219, 0.1);
            border-radius: 8px;
            border-left: 3px solid var(--color-medium-blue);
            max-width: 600px;
            flex-shrink: 0;
        }

        .shift-left {
            position: relative;
            left: -40px;
        }

        .progress-bar {
            width: 100%;
            height: 20px;
            background: rgba(255, 255, 255, 0.5);
            border-radius: 10px;
            overflow: hidden;
            margin: 1rem 0;
        }

        .progress-fill {
            height: 100%;
            background: linear-gradient(90deg, var(--color-medium-blue), var(--color-dark-blue));
            border-radius: 10px;
            transition: width 0.3s ease;
        }

        .pagination {
            display: flex;
            justify-content: center;
            gap: 0.5rem;
            margin-top: 2rem;
        }

        .pagination a, .pagination span {
            padding: 0.5rem 1rem;
            background: rgba(255, 255, 255, 0.9);
            color: var(--color-dark-blue);
            text-decoration: none;
            border-radius: var(--border-radius);
            transition: all 0.3s ease;
        }

        .pagination a:hover, .pagination .active {
            background: var(--color-medium-blue);
            color: white;
        }

        @media (max-width: 768px) {
            .container {
                padding: 1rem;
            }
            
            .header h1 {
                font-size: 2rem;
            }
            
            .nav {
                display: grid;
                grid-template-columns: repeat(2, 1fr);
                gap: 0.5rem;
                justify-items: center;
            }
            
            .stats-grid {
                grid-template-columns: 1fr;
            }
            
            .day-item {
                flex-direction: column;
                align-items: flex-start;
            }
            
            .checkbox-container {
                margin-bottom: 1rem;
            }
        }

        .fade-in {
            animation: fadeIn 0.5s ease-in;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .loading {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 2px solid rgba(137, 138, 196, 0.3);
            border-radius: 50%;
            border-top-color: var(--color-dark-blue);
            animation: spin 1s ease-in-out infinite;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        /* Mobile responsiveness */
        @media (max-width: 768px) {
            .container {
                padding: 1rem;
            }

            .header {
                padding: 1rem;
                margin-bottom: 2rem;
            }

            .header h1 {
                font-size: 1.8rem;
            }

            .header p {
                font-size: 0.9rem;
            }

            .card {
                margin-bottom: 1.5rem;
            }

            .stats-grid {
                grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
                gap: 0.5rem;
            }

            .stat-card {
                padding: 1rem;
            }

            .stat-number {
                font-size: 1.5rem;
            }

            .day-item {
                padding: 1rem;
                flex-direction: column;
                align-items: flex-start;
            }

            .day-info {
                margin-bottom: 0.5rem;
            }

            .day-quote {
                max-width: 100%;
                margin-top: 0.5rem;
                position: static;
                left: auto;
            }

            .shift-left {
                position: static;
                left: auto;
            }

            .day-actions {
                flex-direction: column;
                gap: 0.5rem;
                margin-left: 0;
                align-items: flex-start;
            }

            .pagination {
                text-align: center;
            }

            .pagination .page-link {
                padding: 0.5rem 0.75rem;
                font-size: 0.9rem;
            }
        }

        @media (max-width: 480px) {
            .container {
                padding: 0.5rem;
            }

            .header h1 {
                font-size: 1.5rem;
            }

            .stat-number {
                font-size: 1.2rem;
            }

            .day-item {
                padding: 0.75rem;
            }

            .day-number {
                font-size: 1rem;
            }

            .day-date {
                font-size: 0.9rem;
            }

            .day-quote {
                font-size: 0.9rem;
                padding: 0.25rem;
            }

            .day-actions {
                flex-direction: column;
                gap: 0.5rem;
                margin-left: 0;
                align-items: flex-start;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <header class="header">
            <h1>1000 Days Tracker</h1>
            <p>Transform your life, one day at a time</p>
        </header>

        <nav class="nav">
            <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">Dashboard</a>
            <a href="{{ route('days.index') }}" class="{{ request()->routeIs('days.*') ? 'active' : '' }}">All Days</a>
            
            @guest
                <a href="{{ route('login') }}">Login</a>
                <a href="{{ route('register') }}">Register</a>
            @else
                <span style="padding: 1rem 2rem; background: rgba(162, 170, 219, 0.2); color: var(--color-dark-blue); border-radius: var(--border-radius); font-weight: 600;">
                    Hi, {{ auth()->user()->name }}
                </span>
                <a href="{{ route('logout') }}" 
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                   style="background: #ff6b6b; color: white;">
                    Logout
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            @endguest
        </nav>

        @if(request()->routeIs('dashboard'))
        <audio autoplay loop>
            <source src="/music.mp3" type="audio/mpeg">
            Your browser does not support the audio element.
        </audio>
        @endif

        <main>
            @yield('content')
        </main>
    </div>

    <script>
        // CSRF Token for AJAX requests
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        // Toggle day completion
        function toggleDay(dayId, element) {
            const circle = element.querySelector('.checkbox-circle');
            const dayItem = element.closest('.day-item');
            
            // Add loading state
            circle.innerHTML = '<div class="loading"></div>';
            
            fetch(`/days/${dayId}/toggle`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({})
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Remove loading state
                    circle.innerHTML = '';
                    
                    // Update checkbox state
                    const checkbox = element.querySelector('.checkbox-input');
                    checkbox.checked = data.is_completed;
                    
                    // Update day item appearance
                    if (data.is_completed) {
                        dayItem.classList.add('completed');
                        dayItem.classList.remove('past-due');
                        
                        // Add quote if provided
                        if (data.quote) {
                            let quoteElement = dayItem.querySelector('.day-quote');
                            if (!quoteElement) {
                                quoteElement = document.createElement('div');
                                quoteElement.className = 'day-quote shift-left';
                                const actionsDiv = dayItem.querySelector('.day-actions');
                                const viewButton = actionsDiv.querySelector('a');
                                actionsDiv.insertBefore(quoteElement, viewButton);
                            }
                            quoteElement.textContent = data.quote;
                            quoteElement.classList.add('fade-in');
                        }
                    } else {
                        dayItem.classList.remove('completed');
                        
                        // Remove quote
                        const quoteElement = dayItem.querySelector('.day-quote');
                        if (quoteElement) {
                            quoteElement.remove();
                        }
                    }
                    
                    // Update progress if on dashboard
                    updateProgress();
                }
            })
            .catch(error => {
                console.error('Error:', error);
                // Remove loading state
                circle.innerHTML = '';
            });
        }

        function updateProgress() {
            // This would typically fetch updated stats from the server
            // For now, we'll just reload the page if on dashboard
            if (window.location.pathname === '/') {
                setTimeout(() => {
                    window.location.reload();
                }, 1000);
            }
        }

        // Add click handlers to all checkboxes
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.checkbox-container').forEach(container => {
                container.addEventListener('click', function(e) {
                    e.preventDefault();
                    
                    // Check if the checkbox is disabled (guest mode)
                    const checkbox = this.querySelector('.checkbox-input');
                    if (checkbox.disabled) {
                        return; // Don't do anything for disabled checkboxes
                    }
                    
                    const dayId = this.dataset.dayId;
                    if (dayId) {
                        toggleDay(dayId, this);
                    }
                });
            });
        });
    </script>

    @yield('scripts')
</body>
</html>
