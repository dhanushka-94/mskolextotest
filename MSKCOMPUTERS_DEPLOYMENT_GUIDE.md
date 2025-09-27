# MSK COMPUTERS Deployment Guide - mskcomputers.lk

## 🚀 Complete Deployment Guide for mskcomputers.lk

### 📋 Pre-Deployment Checklist

#### 1. **Domain & Hosting Setup**
- [ ] Domain: `mskcomputers.lk` purchased and configured
- [ ] SSL Certificate obtained (Let's Encrypt or purchased)
- [ ] Hosting provider chosen (Recommended: VPS/Cloud hosting)
- [ ] PHP 8.1+ support confirmed
- [ ] MySQL/MariaDB database available
- [ ] Composer available on server

#### 2. **Server Requirements**
```bash
# Minimum Requirements:
- PHP >= 8.1
- MySQL >= 5.7 or MariaDB >= 10.3
- Nginx or Apache web server
- Composer
- Node.js & NPM (for asset compilation)
- Git (for deployment)

# PHP Extensions Required:
- BCMath
- Ctype
- Fileinfo
- JSON
- Mbstring
- OpenSSL
- PDO
- Tokenizer
- XML
- GD or Imagick (for image processing)
```

### 🛠️ Step-by-Step Deployment Process

#### Step 1: Prepare Local Project
```bash
# 1. Clean and optimize the project
composer install --optimize-autoloader --no-dev
php artisan config:cache
php artisan route:cache
php artisan view:cache

# 2. Build production assets
npm install
npm run build

# 3. Create deployment archive
git archive --format=zip --output=mskcomputers-v1.0.zip HEAD
```

#### Step 2: Server Setup

**A. Create Project Directory**
```bash
# On your server
cd /var/www/
sudo mkdir mskcomputers.lk
sudo chown $USER:$USER mskcomputers.lk
cd mskcomputers.lk
```

**B. Upload and Extract Files**
```bash
# Upload your project files
# Extract the archive
unzip mskcomputers-v1.0.zip

# Set proper permissions
sudo chown -R www-data:www-data /var/www/mskcomputers.lk
sudo chmod -R 755 /var/www/mskcomputers.lk
sudo chmod -R 775 /var/www/mskcomputers.lk/storage
sudo chmod -R 775 /var/www/mskcomputers.lk/bootstrap/cache
```

#### Step 3: Environment Configuration

**Create Production .env File:**
```bash
cp .env.example .env
nano .env
```

**Production .env Configuration:**
```env
APP_NAME="MSK COMPUTERS"
APP_ENV=production
APP_KEY=base64:YOUR_GENERATED_KEY_HERE
APP_DEBUG=false
APP_URL=https://mskcomputers.lk

LOG_CHANNEL=stack
LOG_DEPRECATIONS_CHANNEL=null
LOG_LEVEL=error

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=mskcomputers_db
DB_USERNAME=your_db_username
DB_PASSWORD=your_secure_db_password

BROADCAST_DRIVER=log
CACHE_DRIVER=file
FILESYSTEM_DISK=local
QUEUE_CONNECTION=sync
SESSION_DRIVER=file
SESSION_LIFETIME=120

MEMCACHED_HOST=127.0.0.1

REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379

MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your_email@gmail.com
MAIL_PASSWORD=your_app_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="info@mskcomputers.lk"
MAIL_FROM_NAME="MSK COMPUTERS"

AWS_ACCESS_KEY_ID=
AWS_SECRET_ACCESS_KEY=
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=
AWS_USE_PATH_STYLE_ENDPOINT=false

PUSHER_APP_ID=
PUSHER_APP_KEY=
PUSHER_APP_SECRET=
PUSHER_HOST=
PUSHER_PORT=443
PUSHER_SCHEME=https
PUSHER_APP_CLUSTER=mt1

VITE_PUSHER_APP_KEY="${PUSHER_APP_KEY}"
VITE_PUSHER_HOST="${PUSHER_HOST}"
VITE_PUSHER_PORT="${PUSHER_PORT}"
VITE_PUSHER_SCHEME="${PUSHER_SCHEME}"
VITE_PUSHER_APP_CLUSTER="${PUSHER_APP_CLUSTER}"

# Timezone Configuration
APP_TIMEZONE="Asia/Colombo"

# Cache Configuration for Production
CACHE_DRIVER=file
SESSION_DRIVER=database
QUEUE_CONNECTION=database

# Security
SESSION_SECURE_COOKIE=true
SESSION_SAME_SITE=strict
```

#### Step 4: Database Setup

**Create Database:**
```sql
CREATE DATABASE mskcomputers_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER 'mskcomputers_user'@'localhost' IDENTIFIED BY 'secure_password_here';
GRANT ALL PRIVILEGES ON mskcomputers_db.* TO 'mskcomputers_user'@'localhost';
FLUSH PRIVILEGES;
```

**Run Migrations:**
```bash
cd /var/www/mskcomputers.lk
php artisan key:generate
php artisan migrate --force
php artisan db:seed --force
```

#### Step 5: Web Server Configuration

**Nginx Configuration (`/etc/nginx/sites-available/mskcomputers.lk`):**
```nginx
server {
    listen 80;
    listen [::]:80;
    server_name mskcomputers.lk www.mskcomputers.lk;
    return 301 https://$server_name$request_uri;
}

server {
    listen 443 ssl http2;
    listen [::]:443 ssl http2;
    server_name mskcomputers.lk www.mskcomputers.lk;
    root /var/www/mskcomputers.lk/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";
    add_header X-XSS-Protection "1; mode=block";
    add_header Referrer-Policy "strict-origin-when-cross-origin";
    add_header Content-Security-Policy "default-src 'self'; script-src 'self' 'unsafe-inline' 'unsafe-eval'; style-src 'self' 'unsafe-inline'; img-src 'self' data: https:; font-src 'self' data:;";

    # SSL Configuration
    ssl_certificate /etc/letsencrypt/live/mskcomputers.lk/fullchain.pem;
    ssl_certificate_key /etc/letsencrypt/live/mskcomputers.lk/privkey.pem;
    
    # SSL Security
    ssl_protocols TLSv1.2 TLSv1.3;
    ssl_ciphers ECDHE-RSA-AES128-GCM-SHA256:ECDHE-RSA-AES256-GCM-SHA384;
    ssl_prefer_server_ciphers off;
    ssl_session_cache shared:SSL:10m;
    ssl_session_timeout 10m;

    index index.php;

    charset utf-8;

    # Security Headers
    add_header Strict-Transport-Security "max-age=31536000; includeSubDomains" always;

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
        fastcgi_hide_header X-Powered-By;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }

    # Cache static assets
    location ~* \.(css|js|jpg|jpeg|png|gif|ico|svg|woff|woff2|ttf|eot)$ {
        expires 1y;
        add_header Cache-Control "public, immutable";
        access_log off;
    }

    # Gzip compression
    gzip on;
    gzip_vary on;
    gzip_min_length 1024;
    gzip_types text/plain text/css text/xml text/javascript application/javascript application/xml+rss application/json;

    # Rate limiting
    limit_req_zone $binary_remote_addr zone=api:10m rate=10r/s;
    location /api/ {
        limit_req zone=api burst=20 nodelay;
    }
}
```

**Apache Configuration (if using Apache):**
```apache
<VirtualHost *:80>
    ServerName mskcomputers.lk
    ServerAlias www.mskcomputers.lk
    Redirect permanent / https://mskcomputers.lk/
</VirtualHost>

<VirtualHost *:443>
    ServerName mskcomputers.lk
    ServerAlias www.mskcomputers.lk
    DocumentRoot /var/www/mskcomputers.lk/public

    # SSL Configuration
    SSLEngine on
    SSLCertificateFile /etc/letsencrypt/live/mskcomputers.lk/fullchain.pem
    SSLCertificateKeyFile /etc/letsencrypt/live/mskcomputers.lk/privkey.pem

    # Security Headers
    Header always set Strict-Transport-Security "max-age=31536000; includeSubDomains"
    Header always set X-Content-Type-Options nosniff
    Header always set X-Frame-Options SAMEORIGIN
    Header always set X-XSS-Protection "1; mode=block"

    <Directory /var/www/mskcomputers.lk/public>
        AllowOverride All
        Require all granted
    </Directory>

    # Cache static files
    <LocationMatch "\.(css|js|png|jpg|jpeg|gif|ico|svg)$">
        ExpiresActive On
        ExpiresDefault "access plus 1 year"
    </LocationMatch>

    ErrorLog ${APACHE_LOG_DIR}/mskcomputers_error.log
    CustomLog ${APACHE_LOG_DIR}/mskcomputers_access.log combined
</VirtualHost>
```

#### Step 6: SSL Certificate Setup

**Using Let's Encrypt (Recommended):**
```bash
# Install Certbot
sudo apt update
sudo apt install certbot python3-certbot-nginx

# Obtain SSL certificate
sudo certbot --nginx -d mskcomputers.lk -d www.mskcomputers.lk

# Test automatic renewal
sudo certbot renew --dry-run
```

#### Step 7: Final Configuration

**Install Dependencies:**
```bash
cd /var/www/mskcomputers.lk
composer install --optimize-autoloader --no-dev
```

**Cache Everything:**
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache
```

**Set File Permissions:**
```bash
sudo chown -R www-data:www-data /var/www/mskcomputers.lk
sudo chmod -R 755 /var/www/mskcomputers.lk
sudo chmod -R 775 /var/www/mskcomputers.lk/storage
sudo chmod -R 775 /var/www/mskcomputers.lk/bootstrap/cache
```

**Enable Site:**
```bash
# For Nginx
sudo ln -s /etc/nginx/sites-available/mskcomputers.lk /etc/nginx/sites-enabled/
sudo nginx -t
sudo systemctl reload nginx

# For Apache
sudo a2ensite mskcomputers.lk
sudo systemctl reload apache2
```

### 🔧 Post-Deployment Tasks

#### 1. **Performance Optimization**
```bash
# Enable OPcache in PHP
sudo nano /etc/php/8.1/fpm/php.ini

# Add these settings:
opcache.enable=1
opcache.memory_consumption=256
opcache.interned_strings_buffer=16
opcache.max_accelerated_files=20000
opcache.revalidate_freq=2
opcache.fast_shutdown=1
```

#### 2. **Backup Setup**
```bash
# Create backup script
sudo nano /usr/local/bin/msk_backup.sh
```

```bash
#!/bin/bash
# MSK Computers Backup Script

BACKUP_DIR="/var/backups/mskcomputers"
DATE=$(date +%Y%m%d_%H%M%S)
DB_NAME="mskcomputers_db"
DB_USER="mskcomputers_user"
DB_PASS="your_db_password"
SITE_DIR="/var/www/mskcomputers.lk"

# Create backup directory
mkdir -p $BACKUP_DIR

# Backup database
mysqldump -u$DB_USER -p$DB_PASS $DB_NAME > $BACKUP_DIR/database_$DATE.sql

# Backup files
tar -czf $BACKUP_DIR/files_$DATE.tar.gz $SITE_DIR

# Keep only last 7 backups
find $BACKUP_DIR -name "*.sql" -mtime +7 -delete
find $BACKUP_DIR -name "*.tar.gz" -mtime +7 -delete

echo "Backup completed: $DATE"
```

```bash
# Make script executable
sudo chmod +x /usr/local/bin/msk_backup.sh

# Add to crontab (daily backup at 2 AM)
sudo crontab -e
# Add: 0 2 * * * /usr/local/bin/msk_backup.sh
```

#### 3. **Monitoring Setup**
```bash
# Install monitoring tools
sudo apt install htop iotop nethogs

# Create log monitoring script
sudo nano /usr/local/bin/msk_monitor.sh
```

```bash
#!/bin/bash
# Basic monitoring for MSK Computers

LOG_FILE="/var/log/msk_monitor.log"
DATE=$(date '+%Y-%m-%d %H:%M:%S')

# Check disk space
DISK_USAGE=$(df / | grep -vE '^Filesystem' | awk '{print $5}' | sed 's/%//g')
if [ $DISK_USAGE -gt 80 ]; then
    echo "$DATE - WARNING: Disk usage is ${DISK_USAGE}%" >> $LOG_FILE
fi

# Check database connection
php -r "
try {
    new PDO('mysql:host=127.0.0.1;dbname=mskcomputers_db', 'mskcomputers_user', 'your_db_password');
    echo 'Database connection: OK\n';
} catch(PDOException \$e) {
    echo 'Database connection: FAILED\n';
    file_put_contents('/var/log/msk_monitor.log', '$DATE - ERROR: Database connection failed\n', FILE_APPEND);
}
"
```

### 🚦 Testing Deployment

#### 1. **Pre-Go-Live Checklist**
- [ ] Website loads at https://mskcomputers.lk
- [ ] SSL certificate working (green padlock)
- [ ] All pages accessible
- [ ] Admin panel functional
- [ ] Database connectivity working
- [ ] Email functionality working
- [ ] Cart operations working
- [ ] Product search working
- [ ] Mobile responsiveness verified
- [ ] Page load speed optimized (<3 seconds)

#### 2. **Load Testing**
```bash
# Install Apache Bench for simple load testing
sudo apt install apache2-utils

# Test homepage load
ab -n 100 -c 10 https://mskcomputers.lk/

# Test product page load
ab -n 50 -c 5 https://mskcomputers.lk/categories/brand-new-laptop
```

### 📧 DNS Configuration

**Add these DNS records:**
```
Type: A
Name: @
Value: YOUR_SERVER_IP

Type: A  
Name: www
Value: YOUR_SERVER_IP

Type: CNAME
Name: mail
Value: mskcomputers.lk

Type: MX
Name: @
Priority: 10
Value: mail.mskcomputers.lk
```

### 🔒 Security Hardening

#### 1. **Firewall Setup**
```bash
sudo ufw enable
sudo ufw allow 22/tcp
sudo ufw allow 80/tcp
sudo ufw allow 443/tcp
sudo ufw deny 3306/tcp
```

#### 2. **Hide Sensitive Information**
```bash
# Hide Nginx version
sudo nano /etc/nginx/nginx.conf
# Add: server_tokens off;

# Hide PHP version
sudo nano /etc/php/8.1/fpm/php.ini
# Set: expose_php = Off
```

### 📊 SEO & Analytics Setup

#### 1. **Google Analytics**
Add Google Analytics code to `resources/views/layouts/app.blade.php`

#### 2. **Google Search Console**
- Verify ownership of mskcomputers.lk
- Submit sitemap: https://mskcomputers.lk/sitemap.xml

#### 3. **Robots.txt**
Already configured at: https://mskcomputers.lk/robots.txt

### 🚀 Go-Live Process

#### 1. **Final Steps**
```bash
# Clear all caches
php artisan cache:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Set proper permissions
sudo chown -R www-data:www-data /var/www/mskcomputers.lk
sudo chmod -R 755 /var/www/mskcomputers.lk

# Restart services
sudo systemctl restart nginx
sudo systemctl restart php8.1-fpm
```

#### 2. **Verify Everything Works**
- [ ] Visit https://mskcomputers.lk
- [ ] Test all major functionality
- [ ] Check admin panel
- [ ] Verify SSL certificate
- [ ] Test contact forms
- [ ] Check page load speeds

### 📞 Support & Maintenance

#### 1. **Regular Maintenance Tasks**
```bash
# Weekly maintenance script
#!/bin/bash
cd /var/www/mskcomputers.lk

# Clear logs older than 30 days
find storage/logs/ -name "*.log" -mtime +30 -delete

# Clear old cache files
php artisan cache:clear

# Update composer dependencies (if needed)
# composer update --no-dev

# Restart services
sudo systemctl restart php8.1-fpm
```

#### 2. **Emergency Contacts**
- Hosting Provider Support
- Domain Registrar Support  
- SSL Certificate Provider
- Backup administrator contact

---

## 🎉 Congratulations!

Your MSK COMPUTERS website is now live at **https://mskcomputers.lk**

### Quick Access Links:
- **Website**: https://mskcomputers.lk
- **Admin Panel**: https://mskcomputers.lk/admin
- **Sitemap**: https://mskcomputers.lk/sitemap.xml
- **Server Monitoring**: Check logs in `/var/log/`

### Next Steps:
1. Set up Google Analytics
2. Configure email marketing
3. Monitor website performance
4. Regular security updates
5. Content updates and SEO optimization

**Your professional e-commerce website is now ready to serve customers across Sri Lanka!** 🇱🇰
