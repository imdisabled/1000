# 1000 Days Tracker

A beautiful, modern Larav4. **Database setup**:
   ```bash
   php artisan migrate
   ```

5. **Create hezSec user** (for demo purposes):
   ```bash
   php artisan tinker --execute="
   \$admin = \App\Models\User::create([
       'name' => 'hezSec',
       'email' => 'hezSec@1000days.com', 
       'password' => bcrypt('password'),
       'is_admin' => true
   ]);
   echo 'hezSec user created';
   "
   ```

6. **Start the server**:
   ```bash
   php artisan serve
   ```

7. **Access the application**:
   Open your browser and visit `http://localhost:8000`n to track your 1000-day journey with advanced features including circular checkboxes, n8n integration for quote generation, and a stunning UI using a custom color palette.

## Features

- ✨ **Modern UI**: Beautiful design with advanced circular checkboxes and smooth animations
- � **Multi-User Authentication**: Login/register system with personal 1000-day journeys
- 👥 **Guest Access**: Visitors can view hezSec's progress in read-only mode
- �📅 **1000 Day Tracking**: Track your progress through 1000 days of meaningful tasks
- 🎯 **Daily Tasks**: Pre-loaded with 30 different types of productive tasks that cycle through your journey
- 🎨 **Custom Color Palette**: Designed with #FFF2E0, #C0C9EE, #A2AADB, #898AC4
- 🤖 **n8n Integration**: Automatic quote generation when completing tasks
- 📊 **Progress Tracking**: Visual progress bars and completion statistics
- 🔄 **Real-time Updates**: AJAX-powered checkbox interactions
- 📱 **Responsive Design**: Works beautifully on desktop and mobile
- 🎭 **Advanced Animations**: Smooth transitions and loading states

## Color Scheme

- **Cream**: `#FFF2E0` - Background highlights and cards
- **Light Blue**: `#C0C9EE` - Secondary elements and gradients  
- **Medium Blue**: `#A2AADB` - Primary interactive elements
- **Dark Blue**: `#898AC4` - Text and accent colors

## Installation

### Prerequisites

- PHP 8.1 or higher
- Composer
- SQLite (default) or MySQL/PostgreSQL

### Setup

1. **Install dependencies**:
   ```bash
   composer install
   ```

2. **Environment setup**:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

3. **Database setup**:
   ```bash
   php artisan migrate
   php artisan seed:days
   ```

4. **Start the server**:
   ```bash
   php artisan serve
   ```

5. **Access the application**:
   Open your browser and visit `http://localhost:8000`

## n8n Integration

### Setting up Quote Generation

1. **Configure n8n webhook URL** in your `.env` file:
   ```env
   N8N_WEBHOOK_URL=https://your-n8n-domain.com/webhook/generate-quote
   ```

2. **n8n Workflow Structure**:
   Create a workflow in n8n that accepts POST requests with:
   ```json
   {
     "day_number": 123,
     "date": "2025-08-30",
     "task": "Complete morning workout routine"
   }
   ```

3. **Expected Response**:
   Your n8n workflow should return:
   ```json
   {
     "quote": "Your motivational quote here!"
   }
   ```

If n8n is unavailable, the app will fall back to default congratulatory messages.

## Usage

### Guest Access
- **View hezSec Progress**: Guests can view hezSec's 1000-day journey in read-only mode
- **See Progress Stats**: View completion statistics and current status
- **Modern UI Preview**: Experience the beautiful interface before registering

### User Registration & Login
- **Create Account**: Register to start your personal 1000-day journey
- **Personal Progress**: Each user gets their own set of 1000 days starting from registration
- **Secure Authentication**: Password-protected accounts with remember functionality

### Dashboard
- View overall progress and statistics
- See today's task and quick completion
- Monitor overdue tasks
- Preview upcoming challenges

### All Days View
- Browse all 1000 days with pagination
- Filter by: All, Completed, Pending, Overdue
- Toggle completion status with modern checkboxes (authenticated users only)
- View individual day details

### Individual Day View
- Detailed view of each day's task
- Progress context and journey statistics
- Navigate between consecutive days
- View completion status and quotes

### Modern Checkbox Features
- **Circular Design**: Beautiful circular checkboxes instead of squares
- **Smooth Animations**: CSS transitions with cubic-bezier easing
- **Loading States**: Visual feedback during AJAX operations
- **Gradient Effects**: Completed states show beautiful gradients
- **Hover Effects**: Interactive hover states with shadows

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Redberry](https://redberry.international/laravel-development)**
- **[Active Logic](https://activelogic.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
