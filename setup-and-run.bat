@echo off
echo ========================================
echo ZenPlan Authentication Setup
echo ========================================
echo.

echo [Step 1/3] Installing Laravel Socialite...
call composer require laravel/socialite
if %errorlevel% neq 0 (
    echo ERROR: Failed to install Socialite
    pause
    exit /b 1
)
echo.

echo [Step 2/3] Running database migrations...
call php artisan migrate
if %errorlevel% neq 0 (
    echo ERROR: Failed to run migrations
    pause
    exit /b 1
)
echo.

echo [Step 3/3] Starting Laravel development server...
echo.
echo ========================================
echo SETUP COMPLETE!
echo ========================================
echo.
echo Vite is running on: http://localhost:5173
echo Laravel will run on: http://localhost:8000
echo.
echo Visit http://localhost:8000 to see your authentication system!
echo.
echo Press Ctrl+C to stop the server when done.
echo ========================================
echo.

call php artisan serve
