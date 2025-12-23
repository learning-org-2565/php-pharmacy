# Pharmacy Management System - Docker Edition

A complete pharmacy management system with Docker support for easy deployment.

## Quick Start (3 Steps)

### 1. Start Docker Desktop
Make sure Docker Desktop is installed and running.

### 2. Run the Start Script script
```cmd
start.cmd
```

### 3. Complete Installation Wizard
Open your browser to:
```
http://localhost:8080/install/
```

Fill in the form with these credentials:
- **Database Host:** `pharmacy-db`
- **Database Name:** `pharmacy_db`
- **Database Username:** `pharmacy_user`
- **Database Password:** `pharmacy_secure_password`
- **Table Prefix:** `ds_`

Then create your admin account and click Install.

## That's It!

After installation, access your pharmacy system at:
- **Application:** http://localhost:8080
- **Database Admin:** http://localhost:8000

## Documentation

- **[SETUP-INSTRUCTIONS.md](SETUP-INSTRUCTIONS.md)** - Complete setup guide with troubleshooting
- **[QUICKSTART.md](QUICKSTART.md)** - Quick reference
- **[DOCKER-SETUP.md](DOCKER-SETUP.md)** - Docker configuration details

## Important Notes

1. **You MUST run the installer** - Don't try to manually import the SQL file
2. **Use `pharmacy-db` as database host** - NOT `localhost`
3. **The installer creates the tables** - with the correct `ds_` prefix
4. **After installation** - You can delete the `install/` folder for security

## System Requirements

- Docker Desktop (Windows/Mac/Linux)
- 2GB RAM minimum
- 1GB free disk space

## Features

- Medicine inventory management
- Sales and invoicing
- Purchase order management
- Customer records
- Doctor prescriptions
- Accounting integration
- User role management
- Report generation

## Support

Run status check:
```cmd
check-status.cmd
```

View logs:
```bash
docker-compose logs -f
```

Reset and start fresh:
```bash
docker-compose down -v
docker-compose up -d
```

## Architecture

```
Your Browser
    ↓
localhost:8080 → pharmacy-app (PHP/Apache)
    ↓
pharmacy-db (MySQL)
    ↑
localhost:8000 → phpMyAdmin
```

## License

Check the original application license terms.

## Credits

Original Application: PHP Store Pharmacy Management System
Docker Configuration: Custom setup for containerized deployment
