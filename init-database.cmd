@echo off
REM Database Initialization Script for Windows
REM Run this after starting docker-compose if the database is empty

echo ============================================
echo Pharmacy Database Initialization Script
echo ============================================
echo.

echo Checking if containers are running...
docker ps | findstr pharmacy-db
if %ERRORLEVEL% NEQ 0 (
    echo ERROR: pharmacy-db container is not running!
    echo Please start Docker Desktop and run: docker-compose up -d
    pause
    exit /b 1
)

echo.
echo Checking current database tables...
docker exec pharmacy-db mysql -u pharmacy_user -ppharmacy_secure_password pharmacy_db -e "SHOW TABLES;"

echo.
echo Importing database schema...
docker exec -i pharmacy-db mysql -u pharmacy_user -ppharmacy_secure_password pharmacy_db < install\builder\drugstore.sql

if %ERRORLEVEL% EQU 0 (
    echo.
    echo ============================================
    echo Database imported successfully!
    echo ============================================
    echo.
    echo You can now access the application at:
    echo - Application: http://localhost:8080
    echo - phpMyAdmin: http://localhost:8000
    echo.
) else (
    echo.
    echo ERROR: Failed to import database!
    echo Please check the error messages above.
    echo.
)

pause
