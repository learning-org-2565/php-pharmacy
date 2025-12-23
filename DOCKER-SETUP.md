# Docker Setup Guide for Pharmacy Management System

This guide will help you run the Pharmacy Management System using Docker and docker-compose.

## Prerequisites

- Docker Desktop installed on your system
  - Windows: https://docs.docker.com/desktop/install/windows-install/
  - Mac: https://docs.docker.com/desktop/install/mac-install/
  - Linux: https://docs.docker.com/desktop/install/linux-install/
- Docker Compose (included with Docker Desktop)

## Quick Start

### 1. Start the Application

Open terminal/command prompt in the pharmacy directory and run:

```bash
docker-compose up -d
```

This will:
- Build the PHP application container
- Start MySQL database
- Start phpMyAdmin (optional)
- Create a network for all services

### 2. Access the Application

Once containers are running, access:

- **Pharmacy Application**: http://localhost:8080
- **phpMyAdmin**: http://localhost:8000
  - Username: `root`
  - Password: `root_password`

### 3. First Time Setup

When you first access http://localhost:8080, you'll be redirected to the installer:

1. Go through the installation wizard
2. Use these database credentials:
   - **Database Host**: `pharmacy-db`
   - **Database Name**: `pharmacy_db`
   - **Database Username**: `pharmacy_user`
   - **Database Password**: `pharmacy_secure_password`
   - **Table Prefix**: `ds_`

3. Complete the installation wizard
4. Create your admin account

## Docker Commands

### Start containers
```bash
docker-compose up -d
```

### Stop containers
```bash
docker-compose down
```

### View logs
```bash
# All containers
docker-compose logs -f

# Specific container
docker-compose logs -f pharmacy-app
docker-compose logs -f pharmacy-db
```

### Restart containers
```bash
docker-compose restart
```

### Rebuild containers (after code changes)
```bash
docker-compose up -d --build
```

### Stop and remove all (including volumes)
```bash
docker-compose down -v
```

## Container Details

### Services

1. **pharmacy-app** (PHP 8.1 + Apache)
   - Port: 8080
   - Contains the application code
   - Auto-restarts on failure

2. **pharmacy-db** (MySQL 8.0)
   - Port: 3306
   - Persistent data storage
   - Initialized with schema on first run

3. **phpmyadmin** (Latest)
   - Port: 8000
   - Web-based database management
   - Optional, can be removed if not needed

### Volumes

- **pharmacy-db-data**: Persistent MySQL data
- **./public/uploads**: Application uploads directory

### Network

- **pharmacy-network**: Bridge network connecting all services

## Configuration

### Database Configuration

Edit [docker-compose.yml](docker-compose.yml) to change database credentials:

```yaml
environment:
  MYSQL_DATABASE: pharmacy_db
  MYSQL_USER: pharmacy_user
  MYSQL_PASSWORD: pharmacy_secure_password
```

### Application Port

Change the application port by modifying the ports section:

```yaml
pharmacy-app:
  ports:
    - "9000:80"  # Access on port 9000 instead
```

### Environment Variables

Create a `.env` file (copy from `.env.example`) for environment-specific settings.

## Troubleshooting

### Port Already in Use

If port 8080 or 3306 is already in use:

```yaml
# Change in docker-compose.yml
pharmacy-app:
  ports:
    - "9000:80"  # Use different port
```

### Permission Issues

If you encounter permission errors:

```bash
# Linux/Mac
sudo chown -R $USER:$USER ./public/uploads

# Windows - run as Administrator
icacls .\public\uploads /grant Everyone:F
```

### Database Connection Issues

1. Make sure all containers are running:
   ```bash
   docker-compose ps
   ```

2. Check database logs:
   ```bash
   docker-compose logs pharmacy-db
   ```

3. Verify database host in config is `pharmacy-db` (not `localhost`)

4. If you get errors about missing tables or "Call to member function on bool":
   - The database might not have been initialized properly
   - Check if the SQL import succeeded:
     ```bash
     docker-compose logs pharmacy-db | grep "init.sql"
     ```
   - Manually import the database schema:
     ```bash
     docker exec -i pharmacy-db mysql -u pharmacy_user -ppharmacy_secure_password pharmacy_db < install/builder/drugstore.sql
     ```
   - Or reset the database completely:
     ```bash
     docker-compose down -v
     docker-compose up -d
     ```

### Clear Everything and Start Fresh

```bash
# Stop and remove everything
docker-compose down -v

# Remove images
docker-compose down --rmi all

# Start fresh
docker-compose up -d --build
```

## Development Mode

For development with live code reloading:

The application directory is mounted as a volume, so changes to PHP files are immediately reflected.

To rebuild after dependency changes:

```bash
docker-compose up -d --build
```

## Production Deployment

For production use:

1. **Change all default passwords** in docker-compose.yml
2. **Use environment variables** instead of hardcoded values
3. **Enable HTTPS** using a reverse proxy (nginx/traefik)
4. **Backup database** regularly
5. **Use Docker secrets** for sensitive data
6. **Remove phpMyAdmin** or secure it properly

### Production docker-compose example:

```yaml
services:
  pharmacy-app:
    environment:
      - DB_PASSWORD=${DB_PASSWORD}
    env_file:
      - .env.production
```

## Backup and Restore

### Backup Database

```bash
docker exec pharmacy-db mysqldump -u pharmacy_user -ppharmacy_secure_password pharmacy_db > backup.sql
```

### Restore Database

```bash
docker exec -i pharmacy-db mysql -u pharmacy_user -ppharmacy_secure_password pharmacy_db < backup.sql
```

### Backup Uploads

```bash
# Windows
xcopy /E /I .\public\uploads .\backups\uploads

# Linux/Mac
cp -r ./public/uploads ./backups/uploads
```

## Monitoring

### Check container health

```bash
docker-compose ps
docker stats
```

### Access container shell

```bash
# PHP container
docker exec -it pharmacy-app bash

# MySQL container
docker exec -it pharmacy-db mysql -u root -p
```

## Next Steps

After successful setup, you can:

1. Deploy to Kubernetes (see [K8S-SETUP.md](K8S-SETUP.md) - coming soon)
2. Deploy to Google Cloud Run (see [CLOUDRUN-SETUP.md](CLOUDRUN-SETUP.md) - coming soon)
3. Set up CI/CD pipelines
4. Configure monitoring and logging

## Support

For issues:
1. Check logs: `docker-compose logs -f`
2. Verify configuration in docker-compose.yml
3. Ensure Docker Desktop is running
4. Check firewall/antivirus settings

## Architecture

```
┌─────────────────┐     ┌──────────────────┐     ┌─────────────────┐
│   Browser       │────▶│  pharmacy-app    │────▶│  pharmacy-db    │
│  (localhost)    │     │  PHP 8.1+Apache  │     │  MySQL 8.0      │
│  Port: 8080     │     │  Port: 80        │     │  Port: 3306     │
└─────────────────┘     └──────────────────┘     └─────────────────┘
                               │
                               ▼
                        ┌──────────────────┐
                        │   phpmyadmin     │
                        │   Port: 8000     │
                        └──────────────────┘
```
