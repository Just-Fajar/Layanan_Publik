@echo off
REM ============================================
REM Automated Test Runner Script
REM Multi-Module Authentication System
REM ============================================

echo.
echo ================================
echo   Automated Test Suite Runner
echo ================================
echo.

REM Check if vendor directory exists
if not exist "vendor" (
    echo [ERROR] Vendor directory not found!
    echo Please run: composer install
    pause
    exit /b 1
)

REM Check if PHPUnit exists
if not exist "vendor\bin\phpunit" (
    echo [ERROR] PHPUnit not found!
    echo Please run: composer install
    pause
    exit /b 1
)

:menu
echo.
echo Select Test Suite:
echo.
echo 1. Run ALL Tests (120+ tests)
echo 2. Run E-sport User Tests
echo 3. Run Calendar Event User Tests
echo 4. Run E-sport Admin Tests
echo 5. Run Calendar Admin Tests
echo 6. Run Service Unit Tests
echo 7. Run Policy Unit Tests
echo 8. Run Tests with Coverage Report
echo 9. Run Tests in Parallel (Fast)
echo 0. Exit
echo.
set /p choice="Enter your choice (0-9): "

if "%choice%"=="1" goto all_tests
if "%choice%"=="2" goto esport_user
if "%choice%"=="3" goto calendar_user
if "%choice%"=="4" goto esport_admin
if "%choice%"=="5" goto calendar_admin
if "%choice%"=="6" goto services
if "%choice%"=="7" goto policies
if "%choice%"=="8" goto coverage
if "%choice%"=="9" goto parallel
if "%choice%"=="0" goto end
goto invalid

:all_tests
echo.
echo ========================================
echo Running ALL Tests (120+ tests)...
echo ========================================
echo.
php artisan test
goto result

:esport_user
echo.
echo ========================================
echo Running E-sport User Tests...
echo ========================================
echo.
php artisan test tests\Feature\Esport\UserRegistrationTest.php
php artisan test tests\Feature\Esport\UserAuthenticationTest.php
php artisan test tests\Feature\Esport\TournamentRegistrationTest.php
goto result

:calendar_user
echo.
echo ========================================
echo Running Calendar Event User Tests...
echo ========================================
echo.
php artisan test tests\Feature\CalendarEvent\UserRegistrationTest.php
php artisan test tests\Feature\CalendarEvent\EventRegistrationTest.php
goto result

:esport_admin
echo.
echo ========================================
echo Running E-sport Admin Tests...
echo ========================================
echo.
php artisan test tests\Feature\Esport\Admin\
goto result

:calendar_admin
echo.
echo ========================================
echo Running Calendar Admin Tests...
echo ========================================
echo.
php artisan test tests\Feature\CalendarEvent\Admin\
goto result

:services
echo.
echo ========================================
echo Running Service Unit Tests...
echo ========================================
echo.
php artisan test tests\Unit\Services\
goto result

:policies
echo.
echo ========================================
echo Running Policy Unit Tests...
echo ========================================
echo.
php artisan test tests\Unit\Policies\
goto result

:coverage
echo.
echo ========================================
echo Running Tests with Coverage Report...
echo ========================================
echo.
echo This may take a few minutes...
php artisan test --coverage --min=70
goto result

:parallel
echo.
echo ========================================
echo Running Tests in Parallel (Fast)...
echo ========================================
echo.
php artisan test --parallel
goto result

:invalid
echo.
echo [ERROR] Invalid choice! Please enter 0-9.
goto menu

:result
echo.
echo ========================================
echo Test Execution Completed!
echo ========================================
echo.
echo Press any key to return to menu...
pause >nul
goto menu

:end
echo.
echo ========================================
echo Thank you for testing!
echo ========================================
echo.
pause
exit /b 0
