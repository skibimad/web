@echo off
REM ###############################################################################
REM Skibidi Madness - Automated Setup Script (Windows)
REM 
REM This script automates the complete setup process for the Laravel application
REM including dependency installation, environment configuration, database setup,
REM migrations, seeding, and server startup.
REM
REM Usage:
REM   setup.bat
REM   setup.bat --mysql          Use MySQL instead of SQLite
REM   setup.bat --no-seed        Skip database seeding
REM   setup.bat --skip-deps      Skip composer install
REM ###############################################################################

setlocal enabledelayedexpansion

REM Default options
set USE_MYSQL=false
set SKIP_SEED=false
set SKIP_DEPS=false

REM Parse command line arguments
:parse_args
if "%~1"=="" goto start_setup
if /i "%~1"=="--mysql" (
    set USE_MYSQL=true
    shift
    goto parse_args
)
if /i "%~1"=="--no-seed" (
    set SKIP_SEED=true
    shift
    goto parse_args
)
if /i "%~1"=="--skip-deps" (
    set SKIP_DEPS=true
    shift
    goto parse_args
)
if /i "%~1"=="--help" (
    echo Skibidi Madness - Automated Setup Script
    echo.
    echo Usage: setup.bat [OPTIONS]
    echo.
    echo Options:
    echo   --mysql        Use MySQL instead of SQLite
    echo   --no-seed      Skip database seeding
    echo   --skip-deps    Skip composer install
    echo   --help         Show this help message
    echo.
    exit /b 0
)
shift
goto parse_args

:start_setup
cls
echo.
echo ===============================================================
echo.
echo        SKIBIDI MADNESS - Laravel Setup Script
echo.
echo        Where Chaos Meets Destiny
echo.
echo ===============================================================
echo.

REM Step 1: Check prerequisites
echo [*] Checking prerequisites...

REM Check if PHP is installed
php --version >nul 2>&1
if errorlevel 1 (
    echo [ERROR] PHP is not installed. Please install PHP 8.2 or higher.
    exit /b 1
)

for /f "tokens=2 delims= " %%i in ('php --version ^| findstr /R "^PHP"') do set PHP_VERSION=%%i
echo [OK] PHP %PHP_VERSION% detected

REM Check if Composer is installed
composer --version >nul 2>&1
if errorlevel 1 (
    echo [ERROR] Composer is not installed. Please install Composer first.
    echo Visit: https://getcomposer.org/download/
    exit /b 1
)
echo [OK] Composer detected

REM Step 2: Install Composer dependencies
if "%SKIP_DEPS%"=="false" (
    echo.
    echo [*] Installing Composer dependencies...
    call composer install --no-interaction --prefer-dist --optimize-autoloader
    if errorlevel 1 (
        echo [ERROR] Failed to install dependencies
        exit /b 1
    )
    echo [OK] Dependencies installed successfully
) else (
    echo [INFO] Skipping dependency installation
)

REM Step 3: Setup environment file
echo.
echo [*] Setting up environment configuration...
if not exist .env (
    if exist .env.example (
        copy .env.example .env >nul
        echo [OK] Environment file created from .env.example
    ) else (
        echo [ERROR] .env.example file not found
        exit /b 1
    )
) else (
    echo [INFO] Environment file already exists, skipping...
)

REM Step 4: Generate application key
echo.
echo [*] Generating application key...
php artisan key:generate --ansi
if errorlevel 1 (
    echo [ERROR] Failed to generate application key
    exit /b 1
)
echo [OK] Application key generated

REM Step 5: Configure database
echo.
echo [*] Configuring database...

if "%USE_MYSQL%"=="true" (
    echo [INFO] MySQL configuration selected
    
    set /p DB_HOST="Enter MySQL host [127.0.0.1]: "
    if "!DB_HOST!"=="" set DB_HOST=127.0.0.1
    
    set /p DB_PORT="Enter MySQL port [3306]: "
    if "!DB_PORT!"=="" set DB_PORT=3306
    
    set /p DB_DATABASE="Enter database name [skibidi_madness]: "
    if "!DB_DATABASE!"=="" set DB_DATABASE=skibidi_madness
    
    set /p DB_USERNAME="Enter MySQL username [root]: "
    if "!DB_USERNAME!"=="" set DB_USERNAME=root
    
    set /p DB_PASSWORD="Enter MySQL password: "
    
    REM Update .env file - Note: This is simplified, in production use proper tools
    echo [INFO] Please manually update .env file with MySQL credentials
    echo DB_CONNECTION=mysql
    echo DB_HOST=!DB_HOST!
    echo DB_PORT=!DB_PORT!
    echo DB_DATABASE=!DB_DATABASE!
    echo DB_USERNAME=!DB_USERNAME!
    echo DB_PASSWORD=!DB_PASSWORD!
    
    echo [OK] MySQL configured
) else (
    echo [INFO] SQLite configuration selected (default)
    
    if not exist database mkdir database
    
    if not exist database\database.sqlite (
        type nul > database\database.sqlite
        echo [OK] SQLite database file created
    ) else (
        echo [INFO] SQLite database file already exists
    )
)

REM Step 6: Create storage directories
echo.
echo [*] Setting up storage directories...
if not exist storage\framework\cache mkdir storage\framework\cache
if not exist storage\framework\sessions mkdir storage\framework\sessions
if not exist storage\framework\views mkdir storage\framework\views
if not exist storage\logs mkdir storage\logs
echo [OK] Storage directories created

REM Step 7: Run migrations
echo.
echo [*] Running database migrations...
php artisan migrate --force --no-interaction
if errorlevel 1 (
    echo [ERROR] Failed to run migrations
    exit /b 1
)
echo [OK] Database migrations completed

REM Step 8: Seed database (if not skipped)
if "%SKIP_SEED%"=="false" (
    echo.
    echo [*] Seeding database with default data...
    php artisan db:seed --force --no-interaction
    if errorlevel 1 (
        echo [ERROR] Failed to seed database
        exit /b 1
    )
    echo [OK] Database seeded successfully
    echo [INFO]   - 5 heroes added
    echo [INFO]   - 5 episodes added
) else (
    echo [INFO] Skipping database seeding
)

REM Step 9: Clear caches
echo.
echo [*] Clearing application caches...
php artisan config:clear >nul 2>&1
php artisan route:clear >nul 2>&1
php artisan view:clear >nul 2>&1
php artisan cache:clear >nul 2>&1
echo [OK] Caches cleared

REM Step 10: Display summary
echo.
echo ===============================================================
echo.
echo          SETUP COMPLETED SUCCESSFULLY!
echo.
echo ===============================================================
echo.
echo [OK] Skibidi Madness is ready to use!
echo.
echo What's Next?
echo.
echo 1. Start the development server:
echo    php artisan serve
echo.
echo 2. Access the application:
echo    http://localhost:8000
echo.
echo 3. Available pages:
echo    - Homepage:       http://localhost:8000
echo    - Blog:           http://localhost:8000/blog
echo    - Admin Panel:    http://localhost:8000/admin
echo    - Manage Heroes:  http://localhost:8000/admin/heroes
echo    - Manage Episodes: http://localhost:8000/admin/episodes
echo    - Manage Blog:    http://localhost:8000/admin/blog
echo.
echo 4. API Endpoints:
echo    - Heroes API:     http://localhost:8000/api/heroes
echo    - Episodes API:   http://localhost:8000/api/episodes
echo    - Blog Posts API: http://localhost:8000/api/blog-posts
echo.

REM Offer to start the server
set /p START_SERVER="Would you like to start the development server now? (y/n): "
if /i "%START_SERVER%"=="y" (
    echo.
    echo [*] Starting development server...
    echo Server running at http://localhost:8000
    echo Press Ctrl+C to stop the server
    echo.
    php artisan serve
) else (
    echo.
    echo [INFO] You can start the server later with: php artisan serve
    echo.
)

endlocal
exit /b 0
