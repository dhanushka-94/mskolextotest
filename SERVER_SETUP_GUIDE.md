# MSK COMPUTERS Server Setup Guide

## 🖥️ Complete Server Setup for mskcomputers.lk

### 🚀 Recommended Hosting Providers for Sri Lanka

#### **Option 1: Local Sri Lankan Providers**
- **LKDomain** - Great for local businesses
- **Hostlanka** - Reliable local hosting
- **Sri Lanka Telecom (SLT)** - Enterprise solutions
- **Dialog** - Cloud hosting services

#### **Option 2: International Providers**
- **DigitalOcean** - $5-10/month VPS (Recommended)
- **Vultr** - Global cloud hosting
- **Linode** - Developer-friendly
- **AWS Lightsail** - Amazon's simple hosting

### 📋 Server Specifications (Minimum)

```
CPU: 1 vCPU (2 vCPU recommended)
RAM: 1GB (2GB recommended)
Storage: 25GB SSD (50GB recommended)
Bandwidth: 1TB/month
OS: Ubuntu 20.04 LTS or Ubuntu 22.04 LTS
```

### 🔧 Initial Server Setup

#### Step 1: Connect to Your Server
```bash
# Connect via SSH (replace with your server IP)
ssh root@your_server_ip

# Or if you have a regular user
ssh username@your_server_ip
```

#### Step 2: Update System
```bash
# Update package list
sudo apt update

# Upgrade all packages
sudo apt upgrade -y

# Install essential packages
sudo apt install -y curl wget git unzip software-properties-common apt-transport-https ca-certificates gnupg lsb-release
```

#### Step 3: Create a New User (if using root)
```bash
# Create new user
sudo adduser mskadmin

# Add user to sudo group
sudo usermod -aG sudo mskadmin

# Switch to new user
su - mskadmin
```

### 🐘 Install PHP 8.1

```bash
# Add PHP repository
sudo add-apt-repository ppa:ondrej/php -y
sudo apt update

# Install PHP 8.1 and required extensions
sudo apt install -y php8.1 php8.1-fpm php8.1-mysql php8.1-xml php8.1-mbstring php8.1-curl php8.1-zip php8.1-gd php8.1-bcmath php8.1-json php8.1-tokenizer php8.1-fileinfo php8.1-ctype php8.1-openssl

# Verify PHP installation
php -v
```

### 🗄️ Install MySQL

```bash
# Install MySQL server
sudo apt install -y mysql-server

# Secure MySQL installation
sudo mysql_secure_installation

# Login to MySQL and create database
sudo mysql -u root -p
```

**In MySQL console:**
```sql
-- Create database
CREATE DATABASE mskcomputers_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- Create user
CREATE USER 'mskcomputers_user'@'localhost' IDENTIFIED BY 'YourSecurePassword123!';

-- Grant privileges
GRANT ALL PRIVILEGES ON mskcomputers_db.* TO 'mskcomputers_user'@'localhost';

-- Flush privileges
FLUSH PRIVILEGES;

-- Exit
EXIT;
```

### 🌐 Install Nginx

```bash
# Install Nginx
sudo apt install -y nginx

# Start and enable Nginx
sudo systemctl start nginx
sudo systemctl enable nginx

# Check status
sudo systemctl status nginx
```

### 🎼 Install Composer

```bash
# Download Composer installer
curl -sS https://getcomposer.org/installer -o composer-setup.php

# Install Composer globally
sudo php composer-setup.php --install-dir=/usr/local/bin --filename=composer

# Remove installer
rm composer-setup.php

# Verify installation
composer --version
```

### 📦 Install Node.js and NPM

```bash
# Install Node.js 18.x LTS
curl -fsSL https://deb.nodesource.com/setup_18.x | sudo -E bash -
sudo apt install -y nodejs

# Verify installation
node --version
npm --version
```

### 🔐 Configure Firewall

```bash
# Enable UFW firewall
sudo ufw enable

# Allow SSH (important!)
sudo ufw allow 22/tcp

# Allow HTTP and HTTPS
sudo ufw allow 80/tcp
sudo ufw allow 443/tcp

# Check firewall status
sudo ufw status
```

### 📁 Setup Project Directory

```bash
# Create project directory
sudo mkdir -p /var/www/mskcomputers.lk

# Set ownership
sudo chown $USER:$USER /var/www/mskcomputers.lk

# Set permissions
sudo chmod 755 /var/www/mskcomputers.lk
```

### 🔄 Upload Your Project

#### Option 1: Using Git (Recommended)
```bash
# Clone your repository
cd /var/www/mskcomputers.lk
git clone https://github.com/yourusername/mskcomputers.git .

# Or if you don't have a Git repository, create one
git init
# Then upload files via FTP/SFTP and commit
```

#### Option 2: Using FTP/SFTP
```bash
# Use FileZilla, WinSCP, or similar to upload files to:
# /var/www/mskcomputers.lk/
```

### ⚙️ Configure Laravel Application

```bash
# Navigate to project directory
cd /var/www/mskcomputers.lk

# Install dependencies
composer install --optimize-autoloader --no-dev

# Copy environment file
cp .env.example .env

# Edit environment file
nano .env
```

**Update .env with your details:**
```env
APP_NAME="MSK COMPUTERS"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://mskcomputers.lk

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=mskcomputers_db
DB_USERNAME=mskcomputers_user
DB_PASSWORD=YourSecurePassword123!

# Add other configuration as needed
```

```bash
# Generate application key
php artisan key:generate

# Run migrations
php artisan migrate --force

# Seed database (if needed)
php artisan db:seed --force

# Install NPM dependencies and build assets
npm install
npm run build

# Cache configuration
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### 🌐 Configure Nginx

```bash
# Create Nginx configuration
sudo nano /etc/nginx/sites-available/mskcomputers.lk
```

**Add this configuration:**
```nginx
server {
    listen 80;
    listen [::]:80;
    server_name mskcomputers.lk www.mskcomputers.lk;
    root /var/www/mskcomputers.lk/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";

    index index.php;

    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.1-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

```bash
# Enable the site
sudo ln -s /etc/nginx/sites-available/mskcomputers.lk /etc/nginx/sites-enabled/

# Remove default site
sudo rm /etc/nginx/sites-enabled/default

# Test Nginx configuration
sudo nginx -t

# Restart Nginx
sudo systemctl restart nginx
```

### 🔐 Install SSL Certificate

```bash
# Install Certbot
sudo apt install -y certbot python3-certbot-nginx

# Obtain SSL certificate
sudo certbot --nginx -d mskcomputers.lk -d www.mskcomputers.lk

# Test automatic renewal
sudo certbot renew --dry-run
```

### 📂 Set File Permissions

```bash
# Set ownership
sudo chown -R www-data:www-data /var/www/mskcomputers.lk

# Set directory permissions
sudo find /var/www/mskcomputers.lk -type d -exec chmod 755 {} \;

# Set file permissions
sudo find /var/www/mskcomputers.lk -type f -exec chmod 644 {} \;

# Set writable permissions for Laravel
sudo chmod -R 775 /var/www/mskcomputers.lk/storage
sudo chmod -R 775 /var/www/mskcomputers.lk/bootstrap/cache

# Secure .env file
sudo chmod 600 /var/www/mskcomputers.lk/.env
```

### 🚀 Final Testing

#### Test Your Website
```bash
# Test PHP-FPM
sudo systemctl status php8.1-fpm

# Test Nginx
sudo systemctl status nginx

# Test MySQL
sudo systemctl status mysql

# Check if website loads
curl -I http://mskcomputers.lk
```

#### Test Database Connection
```bash
cd /var/www/mskcomputers.lk
php artisan tinker
```

In Tinker:
```php
DB::connection()->getPdo();
// Should not throw any errors
exit
```

### 📊 Performance Optimization

#### Enable PHP OPcache
```bash
# Edit PHP configuration
sudo nano /etc/php/8.1/fpm/php.ini

# Add these lines (or uncomment if they exist):
opcache.enable=1
opcache.memory_consumption=256
opcache.interned_strings_buffer=16
opcache.max_accelerated_files=20000
opcache.revalidate_freq=2
opcache.fast_shutdown=1

# Restart PHP-FPM
sudo systemctl restart php8.1-fpm
```

#### Optimize Nginx
```bash
# Edit Nginx configuration
sudo nano /etc/nginx/nginx.conf

# Add in http block:
gzip on;
gzip_vary on;
gzip_min_length 1024;
gzip_types text/plain text/css text/xml text/javascript application/javascript application/xml+rss application/json;

# Restart Nginx
sudo systemctl restart nginx
```

### 💾 Setup Automated Backups

```bash
# Create backup script
sudo nano /usr/local/bin/msk_backup.sh
```

**Add backup script:**
```bash
#!/bin/bash
BACKUP_DIR="/var/backups/mskcomputers"
DATE=$(date +%Y%m%d_%H%M%S)
DB_NAME="mskcomputers_db"
DB_USER="mskcomputers_user"
DB_PASS="YourSecurePassword123!"

mkdir -p $BACKUP_DIR

# Database backup
mysqldump -u$DB_USER -p$DB_PASS $DB_NAME > $BACKUP_DIR/db_$DATE.sql

# Files backup
tar -czf $BACKUP_DIR/files_$DATE.tar.gz /var/www/mskcomputers.lk

# Keep only last 7 days
find $BACKUP_DIR -name "*.sql" -mtime +7 -delete
find $BACKUP_DIR -name "*.tar.gz" -mtime +7 -delete
```

```bash
# Make executable
sudo chmod +x /usr/local/bin/msk_backup.sh

# Add to crontab (daily at 2 AM)
sudo crontab -e
# Add: 0 2 * * * /usr/local/bin/msk_backup.sh
```

### 📈 Monitoring Setup

```bash
# Install monitoring tools
sudo apt install -y htop iotop nethogs

# Check logs
sudo tail -f /var/log/nginx/error.log
sudo tail -f /var/www/mskcomputers.lk/storage/logs/laravel.log
```

### 🎯 Domain DNS Configuration

**Add these DNS records at your domain registrar:**

| Type  | Name | Value              | TTL  |
|-------|------|--------------------|------|
| A     | @    | your_server_ip     | 3600 |
| A     | www  | your_server_ip     | 3600 |
| CNAME | mail | mskcomputers.lk    | 3600 |

### ✅ Post-Setup Checklist

- [ ] Website loads at http://mskcomputers.lk
- [ ] SSL certificate working (https://mskcomputers.lk)
- [ ] Admin panel accessible
- [ ] Database connection working
- [ ] Email sending functional
- [ ] Backups configured
- [ ] Firewall enabled
- [ ] Performance optimized

### 🆘 Troubleshooting

#### Common Issues:

**1. 502 Bad Gateway**
```bash
sudo systemctl restart php8.1-fpm nginx
```

**2. Permission Denied**
```bash
sudo chown -R www-data:www-data /var/www/mskcomputers.lk
sudo chmod -R 775 /var/www/mskcomputers.lk/storage
```

**3. Database Connection Failed**
```bash
# Check MySQL status
sudo systemctl status mysql

# Test connection
mysql -u mskcomputers_user -p mskcomputers_db
```

**4. Laravel Application Error**
```bash
# Check logs
tail -f /var/www/mskcomputers.lk/storage/logs/laravel.log

# Clear caches
cd /var/www/mskcomputers.lk
php artisan cache:clear
php artisan config:clear
```

### 📞 Support Contacts

- **Server Issues**: Contact your hosting provider
- **Domain Issues**: Contact your domain registrar
- **SSL Issues**: Check Certbot documentation
- **Application Issues**: Check Laravel logs

---

## 🎉 Congratulations!

Your MSK COMPUTERS website should now be live at **https://mskcomputers.lk**

### Next Steps:
1. Test all functionality thoroughly
2. Set up Google Analytics
3. Submit sitemap to Google Search Console
4. Monitor performance and security
5. Plan regular maintenance schedule

**Your professional e-commerce website is now ready to serve customers! 🚀**
