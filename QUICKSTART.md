# Quick Start Guide

Get your Pharmacy Management System running in 3 simple steps!

## Prerequisites

- Docker Desktop must be installed and running
- Windows: [Download Docker Desktop](https://docs.docker.com/desktop/install/windows-install/)

## Start the Application

### For Windows Users (Easy Way)

1. **Start Docker Desktop** (wait for it to fully start)

2. **Run the start script** - Double-click or run in terminal:
   ```cmd
   start.cmd
   ```

   This script will:
   - Check if Docker is running
   - Start all containers (PHP app, MySQL, phpMyAdmin)
   - Wait for database to be ready
   - Automatically import the database schema
   - Show you the URLs to access

3. **Access the application**:
   - Main Application: http://localhost:8080
   - Database Admin (phpMyAdmin): http://localhost:8000

### Manual Steps (Alternative)

If you prefer manual control or the script doesn't work:

```bash
# 1. Start containers
docker-compose up -d

# 2. Wait 30 seconds for database to initialize

# 3. Import database schema
docker exec -i pharmacy-db mysql -u pharmacy_user -ppharmacy_secure_password pharmacy_db < install/builder/drugstore.sql

# 4. Verify tables were created
docker exec pharmacy-db mysql -u pharmacy_user -ppharmacy_secure_password pharmacy_db -e "SHOW TABLES;"
```

## Troubleshooting

### "Docker Desktop is not running"
- Start Docker Desktop application
- Wait for the Docker icon in system tray to show "running"
- Try again

### Database connection errors
```bash
# Reset everything and start fresh
docker-compose down -v
docker-compose up -d

# Wait 30 seconds, then run the database import script
init-database.cmd
```

### Port already in use
If port 8080 or 3306 is already in use by another application:

1. Stop the other application, OR
2. Edit `docker-compose.yml` and change the ports:
   ```yaml
   pharmacy-app:
     ports:
       - "9000:80"  # Change 8080 to 9000
   ```

### View Logs
```bash
# View all logs
docker-compose logs -f

# View specific service
docker-compose logs -f pharmacy-app
docker-compose logs -f pharmacy-db
```

## Stopping the Application

```bash
# Stop containers (keeps data)
docker-compose down

# Stop and remove all data (fresh start next time)
docker-compose down -v
```

## Next Steps

- For detailed documentation, see [DOCKER-SETUP.md](DOCKER-SETUP.md)
- Default login credentials should be in the database or installer
- Check the application documentation for user management

## Support

If you encounter issues:

1. Check Docker Desktop is running
2. Run `docker-compose logs -f` to see error messages
3. Try `docker-compose down -v` and start fresh
4. Check firewall/antivirus isn't blocking Docker

## Architecture Overview

```
Browser (You)
    ↓
localhost:8080 → pharmacy-app (PHP/Apache)
    ↓
pharmacy-db (MySQL 8.0)
    ↑
localhost:8000 → phpMyAdmin (Database Admin)
```

All services run in isolated Docker containers and communicate through a private network.
