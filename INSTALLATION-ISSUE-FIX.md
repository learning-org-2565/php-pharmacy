# Installation Issue: Installer Not Redirecting Properly

## Problem

- You can access `http://18.141.193.123:8080/install/`
- You completed the installation successfully (no permission errors)
- But when you go to `http://18.141.193.123:8080/` you still get the database error
- The installer should redirect to the main app but doesn't

## Root Cause

The config file on your **local file system** (mounted as a Docker volume) has the old template configuration. The installer wrote a new config file **inside the container**, but because you're using volume mounts (`.:/var/www/html`), the local file takes precedence.

## Solution

You have TWO options:

---

### Option 1: Complete Fresh Installation (RECOMMENDED)

This ensures everything is properly set up:

```bash
# On your EC2 server, run these commands:

# 1. Stop containers
cd /home/ec2-user/pharmacy/php-pharmacy
docker compose down -v

# 2. Backup your current config (just in case)
cp config/config.php config/config.php.backup

# 3. Remove the old config file so installer can create a new one
rm config/config.php

# 4. Start containers
docker compose up -d

# 5. Wait for containers to be ready
sleep 30

# 6. Fix permissions
docker exec pharmacy-app chmod 777 /var/www/html/config/

# 7. NOW go to the installer in your browser:
# http://18.141.193.123:8080/install/

# 8. Complete the 3-step wizard with these credentials:
#    Database Host: pharmacy-db
#    Database Name: pharmacy_db
#    Database Username: pharmacy_user
#    Database Password: pharmacy_secure_password
#    Table Prefix: ds_
#
#    Then fill in your pharmacy info and admin account

# 9. After installation succeeds, check if config was created:
ls -la config/config.php

# 10. Try accessing the main application:
# http://18.141.193.123:8080/
```

---

### Option 2: Manually Create Config File

If the installer keeps failing to write the config file, create it manually:

```bash
# On your EC2 server:

cd /home/ec2-user/pharmacy/php-pharmacy

# Create the config file with correct values
cat > config/config.php << 'EOF'
<?php
/*This name will represent title in auto generated mail*/
define('NAME', 'My Pharmacy');
/*Domain name like www.yourdomain.com*/
define('URL', 'http://18.141.193.123:8080/');

/*Application Address*/
define('DIR_ROUTE', 'index.php?route=');
define('DIR', '/var/www/html/');
define('DIR_APP', DIR.'app/');
define('DIR_BUILDER', DIR.'builder/');
define('DIR_VIEW', DIR_APP.'views/');
define('DIR_IMAGE', DIR.'public/images/');
define('DIR_UPLOADS', DIR.'public/uploads/');
define('DIR_STORAGE', DIR_BUILDER.'storage/');
define('DIR_LIBRARY', DIR_BUILDER.'library/');
define('DIR_VENDOR', DIR_BUILDER.'vendor/');
define('DIR_LANGUAGE', DIR_APP.'language/');

/** MySQL settings **/
define('DB_HOSTNAME', 'pharmacy-db');
define('DB_USERNAME', 'pharmacy_user');
define('DB_PASSWORD', 'pharmacy_secure_password');
define('DB_DATABASE', 'pharmacy_db');
define('DB_PREFIX', 'ds_');

define('AUTH_KEY', 'BRQ(|eDdj&RSo&P;3tCJ>yh-5~49}exzb%0M(CX-jz%e4OCy|nj3-pgupyM{O%kG');
define('LOGGED_IN_SALT', 'mw&<3ohVNRNC2XA#JG3>J2JxF0j77y1iZ&g3vSZ7f~qJJ*wVL1htEOubAgTvPpzA');
define('TOKEN', 'PE8NLY1RiCH(1iMPSV?CPAw(|Y1D*6pk0|Jr>OLb%3P}DSlzQtGxbbp%50%hJq6A');
define('TOKEN_SALT', 'xO)gnh)b|EWzs>p#<#E|X9);9?r2P{nqrD6qILW*?TAZ3iZq-Emed(sKiTytNu~g');
EOF

# Now you STILL need to run the installer to create the database tables
# Go to: http://18.141.193.123:8080/install/
# Complete the wizard
```

---

### Option 3: Check What the Installer Actually Did

Run diagnostics to see if the installer actually created the database tables:

```bash
# Check if tables were created
docker exec pharmacy-db mysql -u pharmacy_user -ppharmacy_secure_password pharmacy_db -e "SHOW TABLES;"

# If you see ds_setting, ds_users, etc., the installer worked!
# The problem is just the config file.

# If you see NO tables or kk_* tables, the installer didn't complete properly
```

---

## Understanding the Issue

Your `docker-compose.yml` has this volume mount:
```yaml
volumes:
  - ./:/var/www/html
```

This means:
- **Local directory** (`./`) is mounted into the container at `/var/www/html`
- Any file changes in the container are reflected locally
- BUT: If a file exists locally, it takes precedence

When you modified `config/config.php` on your Windows machine to use `getenv()`, that file gets mounted into the container and OVERRIDES any changes the installer makes inside the container.

---

## Recommended Solution Steps

**Do this now on your EC2 server:**

```bash
# 1. Check if database tables exist
docker exec pharmacy-db mysql -u pharmacy_user -ppharmacy_secure_password pharmacy_db -e "SHOW TABLES;" | grep ds_setting

# If ds_setting exists:
echo "Tables exist! Just need to fix config file."

# 2. Remove the problematic config file
cd /home/ec2-user/pharmacy/php-pharmacy
rm config/config.php

# 3. Restart the app container
docker compose restart pharmacy-app

# 4. Fix permissions
docker exec pharmacy-app chmod 777 /var/www/html/config/

# 5. Go to installer ONE MORE TIME
# http://18.141.193.123:8080/install/
# Complete the form

# 6. This time it should work because:
#    - Config directory is writable
#    - Old config.php is deleted
#    - Installer can create a fresh config.php
#    - Database tables already exist (from previous install attempt)
```

---

## Verification

After following the steps above:

```bash
# 1. Check config file exists and has correct content
cat config/config.php | grep "DB_HOSTNAME"
# Should show: define('DB_HOSTNAME', 'pharmacy-db');
# NOT: define('DB_HOSTNAME', getenv('DB_HOSTNAME') ?: 'pharmacy-db');

# 2. Check tables exist
docker exec pharmacy-db mysql -u pharmacy_user -ppharmacy_secure_password pharmacy_db -e "SHOW TABLES;" | wc -l
# Should show many tables (20+)

# 3. Try accessing the app
curl -I http://localhost:8080/
# Should return HTTP 200 or 302 (redirect to login)
```

---

## Summary

The issue is that your local `config/config.php` (with `getenv()` calls) is mounted into the container and prevents the installer from creating the correct config file.

**Fix:** Delete the local `config/config.php`, ensure permissions are correct, and run the installer again.
