@echo off
REM Quick Start Script for Pharmacy Application (Windows)

echo ============================================
echo Pharmacy Management System - Quick Start
echo ============================================
echo.

echo Step 1: Checking Docker Desktop status...
docker ps >nul 2>&1
if %ERRORLEVEL% NEQ 0 (
    echo ERROR: Docker Desktop is not running!
    echo.
    echo Please start Docker Desktop and try again.
    echo After Docker Desktop is running, run this script again.
    pause
    exit /b 1
)

echo Docker Desktop is running!
echo.

echo Step 2: Starting containers...
docker-compose up -d

echo.
echo Step 3: Waiting for database to be ready (15 seconds)...
timeout /t 15 /nobreak >nul

echo.
echo Step 4: Checking if database tables exist...
docker exec pharmacy-db mysql -u pharmacy_user -ppharmacy_secure_password pharmacy_db -e "SHOW TABLES;" 2>nul | findstr ds_setting >nul

if %ERRORLEVEL% NEQ 0 (
    echo Database is empty. Importing schema...
    docker exec -i pharmacy-db mysql -u pharmacy_user -ppharmacy_secure_password pharmacy_db < install\builder\drugstore.sql
    if %ERRORLEVEL% EQU 0 (
        echo Database imported successfully!
    ) else (
        echo WARNING: Database import may have failed. Check logs.
    )
) else (
    echo Database already has tables. Skipping import.
)

echo.
echo ============================================
echo Pharmacy Application is ready!
echo ============================================
echo.
echo Access the application at:
echo - Application: http://localhost:8080
echo - phpMyAdmin: http://localhost:8000
echo.
echo To view logs: docker-compose logs -f
echo To stop: docker-compose down
echo.

pause
