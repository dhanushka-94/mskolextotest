@echo off
echo ================================================
echo MSK Computers - Preparing for aaaPanel Deployment
echo ================================================

echo.
echo 1. Installing production dependencies...
composer install --optimize-autoloader --no-dev

echo.
echo 2. Clearing application cache...
if exist bootstrap\cache\*.php del /q bootstrap\cache\*.php

echo.
echo 3. Creating deployment package...
echo Please manually:
echo - Copy .env.production to .env and update with your server details
echo - Create ZIP of entire project folder
echo - Upload to aaaPanel using File Manager

echo.
echo 4. Remember to:
echo - Generate new APP_KEY on server
echo - Set correct database credentials
echo - Upload vendor folder or run composer on server
echo - Set folder permissions (storage: 755)

echo.
echo ================================================
echo Ready for aaaPanel deployment!
echo Follow the AAAPANEL_DEPLOYMENT_GUIDE.md
echo ================================================
pause
