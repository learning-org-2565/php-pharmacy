# FINAL SETUP INSTRUCTIONS - Pharmacy Management System

## IMPORTANT: Read This First!

After extensive analysis of all files, here's what you need to know:

**The database has TWO different table prefixes:**
- SQL file creates tables with `kk_` prefix (e.g., `kk_setting`, `kk_users`)
- Your config expects `ds_` prefix (e.g., `ds_setting`, `ds_users`)

**The application has a built-in INSTALLER that:**
1. Reads the SQL file
2. Replaces `kk_` prefix with `ds_` prefix
3. Creates all tables with correct prefix
4. Initializes settings
5. Creates your admin account
6. Generates the final config file

**YOU MUST RUN THE INSTALLER - Do not manually import SQL!**

---

## Complete Setup Process (Step-by-Step)

### Step 1: Start Docker Desktop

1. Open Docker Desktop application
2. Wait for it to show "Engine running" status
3. Verify in system tray (Docker icon should be active)

### Step 2: Start Containers

Open terminal in the pharmacy directory and run:

```bash
docker-compose up -d
```

**Wait 30-60 seconds** for all containers to initialize.

### Step 3: Verify Containers Are Running

```bash
docker-compose ps
```

You should see 3 containers running:
- `pharmacy-app` (Status: Up)
- `pharmacy-db` (Status: Up)
- `pharmacy-phpmyadmin` (Status: Up)

### Step 4: Access the Installation Wizard

Open your browser and go to:

```
http://localhost:8080/install/
```

**IMPORTANT:** You MUST access `/install/` not just `http://localhost:8080`

### Step 5: Complete the 3-Step Installation

#### Installation Step 1: Welcome Screen
- Click "Continue" or "Next"

#### Installation Step 2: Configuration Form

Fill in the form with these **exact values**:

**Database Configuration:**
- Database Host: `pharmacy-db`
- Database Name: `pharmacy_db`
- Database Username: `pharmacy_user`
- Database Password: `pharmacy_secure_password`
- Table Prefix: `ds_` (keep as is)

**Pharmacy Information:**
- Pharmacy Name: `Your Pharmacy Name`
- Email: `your-email@example.com`
- Phone: `Your phone number`

**Admin Account:**
- First Name: `Your First Name`
- Last Name: `Your Last Name`
- Username: `admin` (or your choice)
- Password: `Your secure password`
- Email: `admin@example.com`

Click "Install" or "Submit"

#### Installation Step 3: Success

You'll see a success message. The installer has:
- ✓ Created all database tables with `ds_` prefix
- ✓ Initialized settings
- ✓ Created your admin account
- ✓ Generated config/config.php file
- ✓ Set up security tokens

### Step 6: Access the Application

Now you can access:

```
http://localhost:8080/
```

Login with the admin credentials you created in Step 5.

---

## What Happens During Installation

The installer (`install/app/controllers/StepController.php`) performs these actions:

1. **Validates** database connection
2. **Reads** `install/builder/drugstore.sql` (1,163 lines)
3. **Parses** SQL file line by line
4. **Replaces** table prefix `kk_` → `ds_`
5. **Executes** SQL to create all tables
6. **Initializes** `ds_setting` table with default configuration
7. **Creates** admin user in `ds_users` table
8. **Writes** new `config/config.php` with:
   - Database credentials
   - Security tokens (AUTH_KEY, LOGGED_IN_SALT, TOKEN, TOKEN_SALT)
   - Application paths
9. **Sends** confirmation email (if email configured)

---

## Tables Created (with ds_ prefix)

After installation, your database will have these tables:

- `ds_accounts` - Chart of accounts
- `ds_account_transaction` - Accounting transactions
- `ds_attached_files` - File uploads
- `ds_customers` - Customer records
- `ds_doctors` - Doctor information
- `ds_invoices` - Sales invoices
- `ds_medicines` - Medicine catalog
- `ds_purchases` - Purchase orders
- `ds_setting` - Application configuration
- `ds_users` - User accounts
- `ds_user_role` - User roles/permissions
- And many more...

---

## Troubleshooting

### Error: "Config files are not writable!"

**Cause:** The installer cannot write to the config directory due to file permissions.

**Solution:** Run this command on your server:
```bash
docker exec pharmacy-app chmod 777 /var/www/html/config/
```

Then refresh the installer page and proceed.

See [FIX-PERMISSIONS.md](FIX-PERMISSIONS.md) for detailed solutions.

### Error: "Table 'pharmacy_db.ds_setting' doesn't exist"

**Cause:** You accessed `http://localhost:8080` directly without running the installer.

**Solution:**
1. Go to `http://localhost:8080/install/`
2. Complete the installation wizard

### Error: "Table 'pharmacy_db.kk_setting' already exists"

**Cause:** Docker auto-imported the SQL with `kk_` prefix, and now installer is trying to create tables.

**Solution:** Reset the database:
```bash
# Stop containers
docker-compose down -v

# Start fresh (this removes the auto-imported kk_ tables)
docker-compose up -d

# Wait 30 seconds, then go to http://localhost:8080/install/
```

### Can't Access Installation Page

**Check 1:** Containers running?
```bash
docker-compose ps
```

**Check 2:** Port 8080 available?
```bash
netstat -ano | findstr :8080
```

**Check 3:** View logs
```bash
docker-compose logs -f pharmacy-app
```

### Database Connection Failed During Installation

**Verify credentials match docker-compose.yml:**
- Host: `pharmacy-db` (NOT `localhost`)
- Username: `pharmacy_user`
- Password: `pharmacy_secure_password`
- Database: `pharmacy_db`

**Check database is ready:**
```bash
docker exec pharmacy-db mysql -u pharmacy_user -ppharmacy_secure_password -e "SELECT 1;"
```

### Installation Already Completed

If `config/config.php` already has database credentials, the installer may not run.

**To reinstall:**
1. Stop containers: `docker-compose down -v`
2. Delete or backup: `config/config.php`
3. Start containers: `docker-compose up -d`
4. Run installer: `http://localhost:8080/install/`

---

## Post-Installation

### Access Points

- **Main Application:** http://localhost:8080
- **Admin Login:** http://localhost:8080/index.php?route=login
- **phpMyAdmin:** http://localhost:8000
  - Server: `pharmacy-db`
  - Username: `root`
  - Password: `root_password`

### Default Admin Login

Use the credentials you created during installation Step 2.

### Configuration File

After installation, check `config/config.php`:

```php
define('DIR', '/var/www/html/');
define('DB_HOSTNAME', 'pharmacy-db');
define('DB_USERNAME', 'pharmacy_user');
define('DB_PASSWORD', 'pharmacy_secure_password');
define('DB_DATABASE', 'pharmacy_db');
define('DB_PREFIX', 'ds_');
```

### Security Recommendations

1. **Change default passwords** after first login
2. **Delete install folder** after setup: `rm -rf install/`
3. **Update security tokens** in config.php
4. **Enable HTTPS** for production
5. **Regular database backups**

---

## Quick Commands Reference

```bash
# Start application
docker-compose up -d

# Stop application
docker-compose down

# View logs
docker-compose logs -f

# Reset everything (fresh start)
docker-compose down -v
docker-compose up -d

# Access database
docker exec -it pharmacy-db mysql -u pharmacy_user -ppharmacy_secure_password pharmacy_db

# Check tables
docker exec pharmacy-db mysql -u pharmacy_user -ppharmacy_secure_password pharmacy_db -e "SHOW TABLES;"

# Backup database
docker exec pharmacy-db mysqldump -u pharmacy_user -ppharmacy_secure_password pharmacy_db > backup.sql

# Restore database
docker exec -i pharmacy-db mysql -u pharmacy_user -ppharmacy_secure_password pharmacy_db < backup.sql
```

---

## Summary

**DO NOT** manually import the SQL file - it will create tables with the wrong prefix.

**DO** run the installer at `http://localhost:8080/install/` which handles:
- ✓ Prefix replacement (kk_ → ds_)
- ✓ Settings initialization
- ✓ Admin account creation
- ✓ Config file generation
- ✓ Security token generation

The installer is the ONLY correct way to set up this application.

---

## Application Architecture

```
User Browser
    ↓
http://localhost:8080/install/ (First time)
    ↓
Installation Wizard
    ↓
Creates ds_* tables + config.php
    ↓
http://localhost:8080/ (Normal access)
    ↓
index.php → builder/startup.php → bootstrap.php
    ↓
Application Routes → Controllers → Models
    ↓
Database (ds_* tables)
```

---

## Need Help?

1. Check logs: `docker-compose logs -f`
2. Verify containers: `docker-compose ps`
3. Test database: `docker exec pharmacy-db mysql -u pharmacy_user -ppharmacy_secure_password -e "SHOW DATABASES;"`
4. Check installer access: `http://localhost:8080/install/`

For additional details, see:
- [DOCKER-SETUP.md](DOCKER-SETUP.md) - Docker configuration details
- [QUICKSTART.md](QUICKSTART.md) - Quick reference guide
