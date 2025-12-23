@echo off
REM Status Check Script for Pharmacy Application

echo ============================================
echo Pharmacy Application - Status Check
echo ============================================
echo.

echo [1/5] Checking Docker Desktop...
docker --version >nul 2>&1
if %ERRORLEVEL% NEQ 0 (
    echo [FAIL] Docker is not installed or not in PATH
    goto :end
) else (
    echo [OK] Docker is installed
)

echo.
echo [2/5] Checking if Docker is running...
docker ps >nul 2>&1
if %ERRORLEVEL% NEQ 0 (
    echo [FAIL] Docker Desktop is not running!
    echo        Please start Docker Desktop and try again.
    goto :end
) else (
    echo [OK] Docker Desktop is running
)

echo.
echo [3/5] Checking containers status...
docker ps --filter "name=pharmacy" --format "table {{.Names}}\t{{.Status}}\t{{.Ports}}"

echo.
echo [4/5] Checking if pharmacy-db container exists...
docker ps -a --filter "name=pharmacy-db" --format "{{.Names}}" | findstr pharmacy-db >nul
if %ERRORLEVEL% NEQ 0 (
    echo [WARN] pharmacy-db container not found
    echo        Run 'docker-compose up -d' to create containers
    goto :end
) else (
    echo [OK] pharmacy-db container exists
)

echo.
echo [5/5] Checking database tables...
docker exec pharmacy-db mysql -u pharmacy_user -ppharmacy_secure_password pharmacy_db -e "SHOW TABLES;" 2>nul | findstr ds_setting >nul
if %ERRORLEVEL% NEQ 0 (
    echo [WARN] Database tables not found!
    echo.
    echo        You need to run the installation wizard:
    echo        http://localhost:8080/install/
    echo.
    echo        See SETUP-INSTRUCTIONS.md for details
) else (
    echo [OK] Database has tables
    echo.
    echo ============================================
    echo All checks passed! Application should work.
    echo ============================================
    echo.
    echo Access the application at:
    echo - Application: http://localhost:8080
    echo - phpMyAdmin: http://localhost:8000
)

:end
echo.
echo ============================================
echo.
pause
