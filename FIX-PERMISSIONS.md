# Fix Installer Permission Error

## Problem

When accessing `http://your-ip:8080/install/`, you get:
```
Error: Config files are not writable!
```

This means the installer cannot write to the `/var/www/html/config/` directory inside the Docker container.

## Solution (Choose One)

### Option 1: Quick Fix (Immediate - Use This Now)

Run these commands on your EC2 server:

```bash
# Fix config directory permissions
docker exec pharmacy-app chmod 777 /var/www/html/config/

# Fix uploads directory permissions
docker exec pharmacy-app chmod 777 /var/www/html/public/uploads/

# Set proper ownership
docker exec pharmacy-app chown -R www-data:www-data /var/www/html/config/
docker exec pharmacy-app chown -R www-data:www-data /var/www/html/public/uploads/
```

After running these commands, refresh the installer page:
```
http://18.141.193.123:8080/install/
```

The error should be gone and you can proceed with installation.

---

### Option 2: Automated Script

```bash
# Make the script executable
chmod +x fix-permissions.sh

# Run the fix script
./fix-permissions.sh
```

Then refresh the installer page.

---

### Option 3: Rebuild Container (Permanent Fix)

The Dockerfile has been updated to set correct permissions from the start.

Rebuild the container:

```bash
# Stop and remove current containers
docker compose down

# Rebuild with updated Dockerfile
docker compose up -d --build

# Wait 30 seconds for containers to start
sleep 30

# Access installer
# http://18.141.193.123:8080/install/
```

This ensures permissions are correct every time the container starts.

---

## Verification

Check if permissions are correct:

```bash
# Check config directory
docker exec pharmacy-app ls -la /var/www/html/config/

# Should show drwxrwxrwx (777) or similar
```

## After Fixing

Once permissions are fixed:

1. Refresh `http://18.141.193.123:8080/install/`
2. You should see the installation form (no error)
3. Fill in the database credentials:
   - Database Host: `pharmacy-db`
   - Database Name: `pharmacy_db`
   - Database Username: `pharmacy_user`
   - Database Password: `pharmacy_secure_password`
   - Table Prefix: `ds_`
4. Create your admin account
5. Click Install

## Why This Happens

Docker containers run with specific user permissions (www-data for Apache). The config directory needs to be writable by the web server to save the configuration file during installation.

## Security Note

After installation completes successfully:

1. The installer creates `config/config.php`
2. For better security, you can reduce permissions:
   ```bash
   docker exec pharmacy-app chmod 644 /var/www/html/config/config.php
   ```
3. Delete the install directory:
   ```bash
   docker exec pharmacy-app rm -rf /var/www/html/install/
   ```

---

## Summary

**Quick Fix (Do this now):**

```bash
docker exec pharmacy-app chmod 777 /var/www/html/config/
```

Then refresh the installer page and proceed with installation.
