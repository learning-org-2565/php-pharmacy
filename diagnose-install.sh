#!/bin/bash
# Diagnose Installation Issues

echo "============================================"
echo "Pharmacy Installation Diagnostics"
echo "============================================"
echo

echo "1. Checking if config file exists in container..."
docker exec pharmacy-app cat /var/www/html/config/config.php | head -35

echo
echo "2. Checking database tables..."
docker exec pharmacy-db mysql -u pharmacy_user -ppharmacy_secure_password pharmacy_db -e "SHOW TABLES;"

echo
echo "3. Checking if ds_setting table exists..."
docker exec pharmacy-db mysql -u pharmacy_user -ppharmacy_secure_password pharmacy_db -e "SELECT COUNT(*) as table_exists FROM information_schema.tables WHERE table_schema = 'pharmacy_db' AND table_name = 'ds_setting';"

echo
echo "4. If ds_setting exists, checking its contents..."
docker exec pharmacy-db mysql -u pharmacy_user -ppharmacy_secure_password pharmacy_db -e "SELECT id, name FROM ds_setting LIMIT 5;" 2>/dev/null || echo "Table ds_setting does not exist yet"

echo
echo "5. Checking install directory..."
docker exec pharmacy-app ls -la /var/www/html/install/ 2>/dev/null || echo "Install directory not found"

echo
echo "============================================"
echo "Diagnostic complete"
echo "============================================"
