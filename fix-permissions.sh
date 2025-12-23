#!/bin/bash
# Fix file permissions for pharmacy application installer

echo "============================================"
echo "Fixing File Permissions for Installer"
echo "============================================"
echo

echo "Setting permissions on config directory..."
docker exec pharmacy-app chmod -R 777 /var/www/html/config/

echo "Setting permissions on install directory..."
docker exec pharmacy-app chmod -R 755 /var/www/html/install/

echo "Setting ownership to www-data (Apache user)..."
docker exec pharmacy-app chown -R www-data:www-data /var/www/html/config/
docker exec pharmacy-app chown -R www-data:www-data /var/www/html/public/uploads/

echo
echo "============================================"
echo "Permissions fixed!"
echo "============================================"
echo
echo "Now try the installer again:"
echo "http://18.141.193.123:8080/install/"
echo
